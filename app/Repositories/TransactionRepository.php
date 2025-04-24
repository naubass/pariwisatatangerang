<?php

namespace App\Repositories;

use App\Models\Transaction;
use PhpParser\Node\Expr\Cast\String_;


class TransactionRepository implements TransactionRepositoryInterface
{
    public function findByBookingId(string $bookingId)
    {
        return Transaction::where('booking_trx_id', $bookingId)->first();
    } 

    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function getUserTransactions(int $userId)
    {
        return Transaction::with('pricings.post')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}