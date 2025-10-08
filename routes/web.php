<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\GoogleController;
use Chatify\Http\Controllers\MessagesController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/pricing', [FrontController::class, 'pricing'])->name('front.pricing');

// Midtrans Payment Routes
Route::match(['get', 'post'], '/dashboard/posts/booking/payment/midtrans/notification',
[PostController::class, 'paymentMidtransNotification'])
    ->name('post.payment_midtrans_notification');

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chat/{user_id}', [\Chatify\Http\Controllers\MessagesController::class, 'index'])->name('chat');

    // web.php
   // Komentar
   Route::post('/dashboard/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
//    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
   Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
   Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard'); // Buat file ini di resources/views/admin/dashboard.blade.php
        })->name('admin.dashboard');
        Route::get('/posts', [PostController::class, 'index'])->name('post.index');
    });

    // Route::fallback(function () {
    //     return view('errors.404');
    // });

    Route::middleware('role:customer')->group(function () {
        Route::get('/dashboard/transactions', [DashboardController::class, 'transactions'])
        ->name('dashboard.post.transactions');

        // model binding {transactions}
        Route::get('/dashboard/transaction/{transaction}', [DashboardController::class, 'transaction_details'])
        ->name('dashboard.post.transaction_details');

        Route::delete('/dashboard/transaction/{transaction}', [DashboardController::class, 'destroy'])
        ->name('dashboard.post.transaction_destroy');

        Route::get('/dashboard/posts', [PostController::class, 'index'])
        ->name('dashboard');

        // slug web-design
        Route::get('/dashboard/post/{post:slug}', [PostController::class, 'details'])
        ->name('dashboard.post.details');

        Route::get('/dashboard/post/getticket/{pricing}', [PostController::class, 'getticket'])
        ->name('dashboard.post.getticket');

        Route::post('/dashboard/post/checkout', [PostController::class, 'checkout'])->name('dashboard.post.checkout');

        Route::get('/dashboard/search/posts', [PostController::class, 'search_posts'])
        ->name('dashboard.search.posts');

        Route::get('/dashboard/post/checkout/success', [PostController::class, 'checkout_success'])
        ->name('dashboard.post.checkout_success');

        Route::get('/posts/{post}/testimonials', [PostController::class, 'getTestimonials'])
        ->name('posts.testimonials');

        Route::post('/dashboard/posts/booking/payment/midtrans', [PostController::class, 'paymentStoreMidtrans'])
        ->name('post.payment_store_midtrans');

        Route::get('/dashboard/posts/search', [PostController::class, 'search_keyword'])->name('dashboard.posts.search');

    });
});

require __DIR__.'/auth.php';
