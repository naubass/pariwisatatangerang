<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Repositories\PostRepository;
use App\Observers\TransactionObserver;
use App\Repositories\PricingRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\PricingRepositoryInterface;
use App\Repositories\TransactionRepository;
use App\Repositories\TransactionRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void 
    {
        //
        $this->app->singleton(PostRepositoryInterface::class, PostRepository::class);
        $this->app->singleton(PricingRepositoryInterface::class, PricingRepository::class);
        $this->app->singleton(TransactionRepositoryInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Transaction::observe(TransactionObserver::class);
    }
}
