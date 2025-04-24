<x-app-layout>
    <x-navigation-auth />

    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-2xl">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-green-600 mb-2">✅ Pembayaran Berhasil!</h2>
            <p class="text-gray-600">Terima kasih sudah melakukan pembelian tiket. Berikut detail transaksi Anda:</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
            <h4 class="text-xl font-semibold mb-4">📌 Rincian Tiket</h4>
            <ul class="text-sm text-gray-700 space-y-2">
                <li><strong>Nama Tempat:</strong> {{ $pricing->post->name }}</li>
                <li><strong>Harga per Tiket:</strong> Rp{{ number_format($pricing->price, 0, ',', '.') }}</li>
            </ul>
        </div>
 
        <div class="flex flex-col md:flex-row gap-4 mt-8">
            <a href="{{ route('dashboard.post.details', $pricing->post->slug ?? $pricing->post->id) }}"
               class="w-full md:w-1/2 text-center bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition">
                🔙 Kembali ke Halaman Wisata
            </a>
            {{-- <a href="{{ route('dashboard.post.subscriptions') }}"
               class="w-full md:w-1/2 text-center bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                📄 Lihat Riwayat Transaksi
            </a> --}}
        </div>
    </div>
</x-app-layout>
