<x-app-layout>
    <x-navigation-auth />

    <div class="max-w-3xl mx-auto bg-white mt-10 p-8 rounded-2xl shadow-lg border border-gray-200">
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-purple-700">🎫 Konfirmasi Pembelian Tiket</h1>
            <p class="text-gray-500 mt-1">Pastikan data berikut sudah benar sebelum melanjutkan ke pembayaran.</p>
        </div>

        {{-- Ringkasan Data --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">👤 Nama Customer</h2>
                <p class="text-gray-800">{{ Auth::user()->name }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">📧 Email Customer</h2>
                <p class="text-gray-800">{{ Auth::user()->email }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">📍 Tempat Wisata</h2>
                <p class="text-gray-800">{{ $pricing->post->name }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">💰 Harga Tiket</h2>
                <p class="text-gray-800">Rp{{ number_format($pricing->price, 0, ',', '.') }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">🎟️ Total Tiket</h2>
                <p class="text-gray-800">{{ $total_ticket }} Tiket</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">🧾 Total Pembayaran</h2>
                <p class="text-gray-800 font-bold text-purple-700">Rp{{ number_format($grand_total, 0, ',', '.') }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">📅 Tanggal Mulai</h2>
                <p class="text-gray-800">{{ \Carbon\Carbon::parse($started_at)->format('d M Y') }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">⏳ Tanggal Berakhir</h2>
                <p class="text-gray-800">{{ \Carbon\Carbon::parse($ended_at)->format('d M Y') }}</p>
            </div>
        </div>

        {{-- Form Konfirmasi Pembayaran --}}
        <form id="payment-form" action="{{ route('post.payment_store_midtrans') }}" method="POST">
            @csrf
            <input type="text" hidden name="payment-method" value="Midtrans">
            <input type="hidden" name="customer_name" value="{{ Auth::user()->name }}">
            <input type="hidden" name="customer_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="pricing_id" value="{{ $pricing->id }}">
            <input type="hidden" name="total_ticket" value="{{ $total_ticket }}">
            <input type="hidden" name="grand_total" value="{{ $grand_total }}">
            <input type="hidden" name="started_at" value="{{ $started_at }}">
            <input type="hidden" name="ended_at" value="{{ $ended_at }}">

            <div class="flex flex-col md:flex-row gap-4 mt-6">
                <a href="{{ route('dashboard.post.details', $pricing->post->slug) }}" class="w-full md:w-1/2 text-center bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition">
                    ❌ Batalkan
                </a>
                <button id="pay-button" type="button" class="w-full md:w-1/2 bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                    ✅ Lanjutkan Pembayaran
                </button>
            </div>
        </form>
    </div>
    @push('scripts')
    <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.clientKey') }}">
</script>

    <script>
        document.getElementById('pay-button').addEventListener('click', function (e) {
            e.preventDefault();
    
            // Ambil data dari form
            const form = document.getElementById('payment-form');
            const formData = new FormData(form);
    
            fetch("{{ route('post.payment_store_midtrans') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
            pricing_id: {{ $pricing->id }},
            total_ticket: {{ $total_ticket }},
            customer_name: "{{ $user->name }}",
            customer_email: "{{ $user->email }}",
            grand_total: {{ $grand_total }},
            started_at: "{{ $started_at }}",
            ended_at: "{{ $ended_at }}"
        })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Response data:", data);
                if (data.snap_token) {
                    // Open Snap popup
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            alert("Pembayaran sukses!");
                            window.location.href = "{{ route('dashboard.post.checkout_success') }}";
                        },
                        onPending: function(result) {
                            alert("Pembayaran pending. Silakan cek status di halaman transaksi.");
                            window.location.href = "{{ route('dashboard.post.checkout') }}";
                        },
                        onError: function(result) {
                            alert("Pembayaran gagal.");
                        },
                        onClose: function() {
                            alert("Transaksi dibatalkan.");
                        }
                    });
                } else {
                    alert("Gagal membuat Snap Token!");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Terjadi kesalahan.");
            });
        });
    </script>
    @endpush
    
    

   
</x-app-layout>
