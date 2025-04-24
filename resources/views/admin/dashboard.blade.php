<x-app-layout>
    <x-navigation-auth />

    <div class="container mx-auto py-10 px-4">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">👨‍💼 Admin Dashboard</h1>
                    <p class="text-gray-600 mt-1">
                        Selamat datang, <span class="font-semibold">{{ Auth::user()->name }}</span>! Anda login sebagai 
                        <span class="text-green-600 font-semibold">Admin</span>.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card: Jumlah Customer -->
                <div class="bg-gradient-to-r from-blue-100 to-blue-200 rounded-lg p-4 shadow-md">
                    <h2 class="text-lg font-semibold text-blue-900">👥 Jumlah Customer</h2>
                    <p class="text-3xl font-bold mt-2 text-blue-900">
                        {{ \App\Models\User::role('customer')->count() }}
                    </p>
                </div>

                <!-- Card: Jumlah Destinasi -->
                <div class="bg-gradient-to-r from-green-100 to-green-200 rounded-lg p-4 shadow-md">
                    <h2 class="text-lg font-semibold text-green-900">📍 Destinasi</h2>
                    <p class="text-3xl font-bold mt-2 text-green-900">
                        {{ \App\Models\Post::count() }}
                    </p>
                </div>

                <!-- Card: Total Transaksi -->
                <div class="bg-gradient-to-r from-yellow-100 to-yellow-200 rounded-lg p-4 shadow-md">
                    <h2 class="text-lg font-semibold text-yellow-900">💸 Total Transaksi</h2>
                    <p class="text-3xl font-bold mt-2 text-yellow-900">
                        {{ \App\Models\Transaction::count() }}
                    </p>
                </div>

                <!-- Card: Komentar -->
                <div class="bg-gradient-to-r from-purple-100 to-purple-200 rounded-lg p-4 shadow-md">
                    <h2 class="text-lg font-semibold text-purple-900">💬 Komentar</h2>
                    <p class="text-3xl font-bold mt-2 text-purple-900">
                        {{ \App\Models\Comment::count() }}
                    </p>
                </div>
            </div>

            <div class="mt-10">
                <h3 class="text-xl font-bold mb-3 text-gray-700">🔥 Mulai Interaksi</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('chat', ['user_id']) }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                        💬 Buka Chatting
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
