<x-app-layout>
    <x-navigation-auth />

    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6">Daftar Transaksi</h1>

        @if($transactions->isEmpty())
            <div class="text-gray-600">Kamu belum memiliki transaksi.</div>
        @else
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-left text-sm font-semibold text-gray-600">
                        <tr>
                            <th class="px-6 py-3">ID Transaksi</th>
                            <th class="px-6 py-3">Tempat Wisata</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Total Tiket</th>
                            <th class="px-6 py-3">Total Bayar</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @foreach($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $transaction->booking_trx_id }}</td>
                                <td class="px-6 py-4">{{ $transaction->pricings->post->name }}</td>
                                <td class="px-6 py-4">{{ $transaction->started_at }} - {{ $transaction->ended_at }}</td>
                                <td class="px-6 py-4">{{ $transaction->total_ticket }} tiket</td>
                                <td class="px-6 py-4">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($transaction->isActive())
                                        <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">Lunas</span>
                                    @else
                                        <span class="bg-yellow-100 text-red-800 text-xs px-3 py-1 rounded-full">Expired</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-x-2">
                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('dashboard.post.transaction_details', $transaction->id) }}"
                                           class="flex items-center gap-x-1 bg-blue-100 text-blue-700 hover:bg-blue-200 text-xs font-semibold px-3 py-1 rounded-full transition duration-200">
                                            {{-- Icon: Document Text --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h5.586A2 2 0 0114 4.586L18.414 9A2 2 0 0119 10.414V20a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span>Detail</span>
                                        </a>
                                
                                        {{-- Tombol Hapus (jika expired) --}}
                                        @if(!$transaction->isActive())
                                            <form action="{{ route('dashboard.post.transaction_destroy', $transaction->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="flex items-center gap-x-1 bg-red-100 text-red-700 hover:bg-red-200 text-xs font-semibold px-3 py-1 rounded-full transition duration-200"
                                                        title="Hapus">
                                                    {{-- Icon: Trash --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <div class="mt-6">
            <a href="{{ route('dashboard') }}"
               class="inline-block bg-red-500 hover:bg-red-400 text-white font-medium px-4 py-2 rounded">
                ← Kembali
            </a>
        </div>
    </div>

    
</x-app-layout>
