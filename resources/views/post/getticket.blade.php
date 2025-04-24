<x-app-layout>
    <x-navigation-auth />

     {{-- Flash Message --}}
     @if (session('error'))
     <div class="max-w-2xl mx-auto mt-4 px-4">
         <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
             {{ session('error') }}
         </div>
     </div>
 @elseif (session('success'))
     <div class="max-w-2xl mx-auto mt-4 px-4">
         <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
             {{ session('success') }}
         </div>
     </div>
 @endif

    <input type="hidden" name="pricing_id" value="{{ $pricing->id }}">

    <div class="max-w-2xl mx-auto bg-white p-8 mt-12 rounded-2xl shadow-md border border-purple-100">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold text-purple-700">🎫 Form Pembelian Tiket</h1>
            <p class="text-gray-500 mt-2 text-sm">Isi data dengan benar untuk melanjutkan pembelian tiket wisata</p>
        </div>

        <form action="{{ route('dashboard.post.checkout') }}" method="POST" class="space-y-5">
            @csrf
        
            <input type="hidden" name="pricing_id" value="{{ $pricing->id }}">
        
            <!-- Tempat Wisata -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Wisata</label>
                <input type="text" value="{{ $pricing->post->name }}" readonly
                    class="w-full px-4 py-2 bg-gray-100 border rounded-lg text-gray-700" />
            </div>
        
            <!-- Harga Tiket -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Tiket (per orang)</label>
                <input type="text" value="Rp {{ number_format($pricing->price) }}" readonly
                    class="w-full px-4 py-2 bg-gray-100 border rounded-lg text-gray-700" />
            </div>
        
            <!-- Nama Customer -->
            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label>
                <input type="text" name="customer_name" id="customer_name" required
                value="{{ Auth::user()->name }}" readonly
                class="w-full px-4 py-2 bg-gray-100 border rounded-lg text-gray-700" />
            </div>
            
            <!-- Email Customer -->
            <div>
                <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email Customer</label>
                <input type="email" name="customer_email" id="customer_email" required
                value="{{ Auth::user()->email }}" readonly
                class="w-full px-4 py-2 bg-gray-100 border rounded-lg text-gray-700" />
            </div>

            <!-- Jumlah Tiket -->
            <div>
                <label for="total_ticket" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tiket</label>
                <input type="number" name="total_ticket" id="total_ticket" min="1" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400" />
            </div>
        
            <!-- Tanggal Mulai -->
            <div>
                <label for="started_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="started_at" id="started_at" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400" />
            </div>

            <!-- Tanggal Berakhir (Auto) -->
            <input type="hidden" name="ended_at" id="ended_at">
        
            <!-- Tombol Submit -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                    🚀 Beli Tiket Sekarang
                </button>
            </div>
        </form>
    </div>

    {{-- <script>
        document.getElementById('started_at').addEventListener('change', function() {
            const startedAt = new Date(this.value);
            startedAt.setDate(startedAt.getDate() + 1); // Menambah satu hari
            const endedAt = startedAt.toISOString().split('T')[0]; // Format yyyy-mm-dd
            document.getElementById('ended_at').value = endedAt;
        });
    </script> --}}
</x-app-layout>
