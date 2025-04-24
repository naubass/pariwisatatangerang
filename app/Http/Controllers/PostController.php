<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Pricing;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Services\PaymentService;
use App\Services\PricingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    protected $postService;
    protected $pricingService;
    protected $transactionService;
    protected $paymentService; 

    public function __construct(
        PostService $postService, 
        PricingService $pricingService, 
        TransactionService $transactionService,
        PaymentService $paymentService
    )
    {
        $this->postService = $postService;
        $this->pricingService = $pricingService;
        $this->transactionService = $transactionService;
        $this->paymentService = $paymentService;
    }

    // Method untuk tampilkan halaman detail post
    public function details(Post $post)
    {
        $post->load(['category', 'postadmins.admin', 'comments.user', 'comments.replies.user',]);
        $testimonials = $this->postService->getPostTestimonials($post);
        $pricings = $post->pricings;

        $subscribedPricingIds = [];

        if (Auth::check()) {
            $user = Auth::user();
            foreach ($pricings as $pricing) {
                if ($pricing->isSubscribedByUser($user->id)) {
                    $subscribedPricingIds[] = $pricing->id;
                }
            }
        }

        return view('post.details', compact('post', 'testimonials', 'pricings', 'subscribedPricingIds'));
    }

    public function index(Request $request)
    {
        $categorySlug = $request->query('category'); // Ambil dari query string

        $postByCategory = $this->postService->groupByPostCategory($categorySlug);

        

        return view('post.index', compact('postByCategory'));
    }

    public function getticket(Pricing $pricing)
    {
        $pricing = $this->pricingService->getPricingWithPost($pricing->id);
        $user = Auth::user();

        if ($pricing->isSubscribedByUser($user->id)) {
            return redirect()->route('dashboard.post.details', $pricing->post_id)
                             ->with('error', 'Kamu sudah memesan tiket ini.');
        }

        return view('post.getticket', compact('pricing', 'user'));
    }

    // Method untuk menampilkan halaman checkout
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'pricing_id' => 'required|exists:pricings,id',
            'total_ticket' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'started_at' => 'required|date',
        ]);

        $validated['ended_at'] = Carbon::parse($validated['started_at'])->addDay()->format('Y-m-d');

        // Hitung ulang grand total dari DB (anti manipulasi)
        $pricing = Pricing::findOrFail($validated['pricing_id']);
        $validated['grand_total'] = $pricing->price * $validated['total_ticket'];

        // Persiapkan data untuk checkout
        $checkoutData = $this->transactionService->createAndPrepareCheckout($validated);

        return view('post.checkout', $checkoutData);
    }

    // Method untuk menangani pembayaran Midtrans
    public function paymentStoreMidtrans(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'pricing_id' => 'required|exists:pricings,id',
                'total_ticket' => 'required|integer|min:1',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email',
                'grand_total' => 'required|numeric|min:0',
                'started_at' => 'required|date',
                'ended_at' => 'required|date',
            ]);

            // Menghasilkan Snap Token untuk pembayaran Midtrans
            $snapToken = $this->paymentService->createPayment($request->pricing_id, $validated);

return response()->json(['snap_token' => $snapToken['snap_token']]); // ✅ Ambil string token-nya langsung

            return response()->json(['snap_token' => $snapToken]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('❌ Gagal membuat Snap Token:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Gagal membuat transaksi Midtrans',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Method untuk menangani notifikasi pembayaran dari Midtrans
    public function paymentMidtransNotification(Request $request)
    {
        try {
            // Menghandle notifikasi pembayaran
            $transactionStatus = $this->paymentService->handlePaymentNotification();

            // Perbarui status transaksi di database berdasarkan status notifikasi
            if ($transactionStatus) {
                return response()->json(['status' => 'Transaction successful']);
            }

            return response()->json(['error' => 'Failed to process notification.'], 500);
        } catch (\Exception $e) {
            Log::error('Failed to handle Midtrans notification:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to process notification.'], 500);
        }
    }

    // Method untuk halaman sukses checkout
    public function checkout_success()
    {
        $pricing = $this->transactionService->getRecentPricing();

        if (!$pricing) {
            return redirect()->route('dashboard.post.details')->with('error', 'No recent subscription found.');
        }

        return view('post.checkout_success', compact('pricing'));
    }

    public function search_keyword(Request $request)
{
    $request->validate([
        'search' => 'required|string'
    ]);

    $keyword = $request->input('search'); // gunakan input langsung

    $posts = $this->postService->searchPosts($keyword);

    return view('post.search', compact('posts', 'keyword'));
}

}
