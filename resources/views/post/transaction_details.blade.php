<x-app-layout>
    <x-navigation-auth />

    <div class="max-w-4xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-semibold text-center mb-8">Detail Transaksi</h1>

        <div class="bg-white rounded-lg shadow-lg p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- ID Transaksi -->
                <div class="space-y-2">
                    <strong class="text-lg font-medium">ID Transaksi:</strong>
                    <div class="text-gray-600">{{ $transaction->booking_trx_id }}</div>
                </div>

                <!-- Tempat Wisata -->
                <div class="space-y-2">
                    <strong class="text-lg font-medium">Tempat Wisata:</strong>
                    <div class="text-gray-600">{{ $transaction->pricings->post->name }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Jumlah Tiket -->
                <div class="space-y-2">
                    <strong class="text-lg font-medium">Jumlah Tiket:</strong>
                    <div class="text-gray-600">{{ $transaction->total_ticket }}</div>
                </div>

                <!-- Total Bayar -->
                <div class="space-y-2">
                    <strong class="text-lg font-medium">Total Bayar:</strong>
                    <div class="text-gray-600">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Waktu Kunjungan -->
                <div class="space-y-2">
                    <strong class="text-lg font-medium">Waktu Kunjungan:</strong>
                    <div class="text-gray-600">{{ $transaction->started_at }} - {{ $transaction->ended_at }}</div>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <strong class="text-lg font-medium">Status:</strong>
                    @if($transaction->isActive()) <!-- Periksa apakah transaksi aktif -->
                        <div class="inline-flex items-center space-x-4 bg-green-100 text-green-800 px-4 py-2 rounded-full shadow-lg">
                            <div class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-semibold">Lunas</span>
                        </div>
                    @else
                        <div class="inline-flex items-center space-x-4 bg-yellow-100 text-red-800 px-4 py-2 rounded-full shadow-lg">
                            <div class="flex items-center justify-center w-10 h-10 bg-red-500 text-white rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M6.938 4.438a9.951 9.951 0 0112.124 0m0 12.124a9.951 9.951 0 01-12.124 0" />
                                </svg>
                            </div>
                            <span class="font-semibold">Expired</span>
                        </div>
                    @endif
                </div>


            </div>

            <!-- Jenis Pembayaran -->
            <div class="space-y-2">
                <strong class="text-lg font-medium">Jenis Pembayaran:</strong>
                <div class="text-gray-600">{{ ucfirst($transaction->payment_type) ?? '-' }}</div>
            </div>

            <!-- Bukti Pembayaran -->
            @if($transaction->proof)
                <div class="space-y-2">
                    <strong class="text-lg font-medium">Bukti Pembayaran:</strong>
                    <div class="text-gray-600">
                        <img src="{{ Storage::url($transaction->proof) }}" alt="Bukti" class="w-full md:w-72 rounded-lg shadow-lg">
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('dashboard.post.transactions') }}"
               class="inline-block bg-red-500 hover:bg-red-400 text-white font-medium px-6 py-3 rounded-lg shadow-lg transition-all duration-300">
                ← Kembali ke Transaksi
            </a>
        </div>
    </div>
</x-app-layout>
