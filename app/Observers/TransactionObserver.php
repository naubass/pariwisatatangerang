<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Helpers\TransactionHelper;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */

    public function creating($transaction)
    {
        $transaction->booking_trx_id = TransactionHelper::generateUniqueTrxId();
    }
    
    public function created(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
