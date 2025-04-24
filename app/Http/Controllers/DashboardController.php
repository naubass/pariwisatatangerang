<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function transactions() 
    {
        $transactions = $this->transactionService->getUserTransactions();
        return view('post.transactions', compact('transactions'));
    }


    public function transaction_details(Transaction $transaction)
    {
        return view('post.transaction_details', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
{
    // Opsional: pastikan yang menghapus adalah pemilik transaksinya
    if ($transaction->user_id !== Auth::id()) {
        abort(403);
    }

    // Pastikan hanya transaksi expired yang bisa dihapus
    if ($transaction->isActive()) {
        return back()->with('error', 'Transaksi yang masih aktif tidak dapat dihapus.');
    }

    $transaction->delete();

    return back()->with('success', 'Transaksi berhasil dihapus.');
}

}
