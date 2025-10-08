<?php

namespace App\Services;

use App\Models\Pricing;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PricingRepositoryInterface;
use App\Repositories\TransactionRepositoryInterface;
use Illuminate\Auth\Events\Validated;

class TransactionService
{
    protected $transactionRepository;
    protected $pricingRepository;

    public function __construct(
        TransactionRepositoryInterface $transactionRepository, 
        PricingRepositoryInterface $pricingRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->pricingRepository = $pricingRepository;
    }
    
    public function getRecentPricing()
{
    $pricingId = session()->get('pricing_id'); // HARUSNYA INT
    return $this->pricingRepository->findById($pricingId);
}


    public function createAndPrepareCheckout(array $data)
{
    $user = Auth::user();

    $pricing = $this->pricingRepository->findById($data['pricing_id']);

    $total_ticket = $pricing->price * $data['total_ticket'];
    $grand_total = $total_ticket;

    // Hitung ended_at jika belum diisi
    $ended_at = $data['ended_at'] ?? \Carbon\Carbon::parse($data['started_at'])->addDay(1)->format('Y-m-d');

    // simpan transaksi ke database
    $trxData = [
        'user_id' => $user->id,
        'pricing_id' => $pricing->id, 
        'total_ticket' => $data['total_ticket'],
        'grand_total' => $grand_total,
        'started_at' => $data['started_at'],
        'ended_at' => $data['ended_at'],
    ];

    session()->put('pricing_id', $pricing->id); // ✅ Simpan hanya ID-nya


    return [
        'pricing' => $pricing,
        'user' => $user,
        'total_ticket' => $data['total_ticket'],
        'sub_total' => $total_ticket,
        'grand_total' => $grand_total,
        'started_at' => $data['started_at'],
        'ended_at' => $ended_at, 
    ];
}

public function getUserTransactions()
    {
        $user = Auth::user();

        return $this->transactionRepository->getUserTransactions($user->id);
    }

    public function calculateEndedAt($started_at)
{
    return \Carbon\Carbon::parse($started_at)->addDay(1)->format('Y-m-d');
}


}