<?php

namespace App\Services;

use App\Models\Pricing;
use App\Helpers\TransactionHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\MidtransService;
use App\Repositories\PricingRepositoryInterface;
use App\Repositories\TransactionRepositoryInterface;

class PaymentService
{
    protected MidtransService $midtransService;
    protected PricingRepositoryInterface $pricingRepository;
    protected TransactionRepositoryInterface $transactionRepository;

    public function __construct(
        MidtransService $midtransService,
        PricingRepositoryInterface $pricingRepository,
        TransactionRepositoryInterface $transactionRepository
    ) {
        $this->midtransService = $midtransService;
        $this->pricingRepository = $pricingRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function createPayment(int $pricingId, array $data): array
    {
        $user = Auth::user();

        $pricing = $this->pricingRepository->findWithPostById($pricingId);
        if (!$pricing) {
            Log::error('❌ Pricing tidak ditemukan', ['pricing_id' => $pricingId]);
            throw new \Exception('Data pricing tidak ditemukan.');
        }

        $totalTicket = (int) $data['total_ticket'];
        if ($totalTicket <= 0) {
            throw new \Exception('Jumlah tiket harus lebih dari 0.');
        }

        $grandTotal = $pricing->price * $totalTicket;
        $orderId = TransactionHelper::generateUniqueTrxId();

        $snapParams = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grandTotal,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => '081234567890',
            ],
            'item_details' => [[
                'id' => 'PRC-' . $pricing->id,
                'price' => $pricing->price,
                'quantity' => $totalTicket,
                'name' => $pricing->post->name ?? 'Tiket Wisata',
            ]],
            'custom_field1' => $user->id,
            'custom_field2' => json_encode([
                'pricing_id' => $pricing->id,
                'total_ticket' => $totalTicket, 
                'started_at' => $data['started_at'],
                'ended_at' => $data['ended_at'],
            ]),



        ];

        Log::info('📦 Request ke Midtrans', $snapParams);

        $snapToken = $this->midtransService->createSnapToken($snapParams);

        return [
            'snap_token' => $snapToken,
            'grand_total' => $grandTotal,
            'booking_trx_id' => $orderId,
        ];
    }

    public function handlePaymentNotification(): string
    {
        $notification = $this->midtransService->handleNotification();

        $customData = json_decode($notification['custom_field2'] ?? '', true);

        if (!$customData || !isset($customData['pricing_id'])) {
            Log::error('❌ Data custom_field2 tidak valid', ['custom_field2' => $notification['custom_field2'] ?? null]);
            return 'invalid_data';
        }

        $orderId = $notification['order_id'];
        if ($this->transactionRepository->findByBookingId($orderId)) {
            Log::warning("⚠️ Transaksi sudah pernah dibuat: $orderId");
            return 'duplicate';
        }

        if (in_array($notification['transaction_status'], ['capture', 'settlement'])) {
            $pricing = $this->pricingRepository->findById($customData['pricing_id']);
            if ($pricing) {
                $this->storeTransaction($notification, $pricing, $customData);
            }
        }

        return $notification['transaction_status'];
    }

    protected function storeTransaction(array $notification, Pricing $pricing, array $data): void
    {
        $this->transactionRepository->create([
            'user_id' => $notification['custom_field1'],
            'pricing_id' => $pricing->id,
            'total_ticket' => $data['total_ticket'],
            'grand_total' => $notification['gross_amount'],
            'payment_type' => 'Midtrans',
            'is_paid' => true,
            'booking_trx_id' => $notification['order_id'],
            'started_at' => $data['started_at'],
            'ended_at' => $data['ended_at'],
        ]);

        Log::info('✅ Transaksi berhasil disimpan', ['order_id' => $notification['order_id']]);
    }
}
