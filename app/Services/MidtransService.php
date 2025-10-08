<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    public function __construct()
    {
        // Konfigurasi Midtrans saat service diinisialisasi
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');
    }

    /**
     * Membuat Snap Token dari parameter transaksi
     *
     * @param array $params
     * @return string 
     * @throws \Exception
     */
    public function createSnapToken(array $params): string
    {
        try {
            $transaction = Snap::createTransaction($params);

            Log::info('✅ Midtrans Snap token created successfully.', [
                'order_id' => $params['transaction_details']['order_id'],
                'token' => $transaction->token
            ]);

            return $transaction->token;
        } catch (\Exception $e) {
            Log::error('❌ Gagal membuat Snap Token Midtrans', [
                'message' => $e->getMessage(),
                'params' => $params,
            ]);
            throw $e;
        }
    }

    /**
     * Menangani notifikasi dari Midtrans
     *
     * @return array
     * @throws \Exception
     */
    public function handleNotification(): array
    {
        try {
            $notification = new Notification();

            Log::info('📩 Midtrans Notification Received', [
                'order_id' => $notification->order_id,
                'transaction_status' => $notification->transaction_status
            ]);

            return [
                'order_id'          => $notification->order_id,
                'transaction_status'=> $notification->transaction_status,
                'gross_amount'      => $notification->gross_amount,
                'custom_field1'     => $notification->custom_field1,
                'custom_field2'     => $notification->custom_field2,
            ];
        } catch (\Exception $e) {
            Log::error('❌ Gagal menangani notifikasi Midtrans', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
