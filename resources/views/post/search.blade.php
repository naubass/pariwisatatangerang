<x-app-layout>
    <x-navigation-auth />
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Judul / Heading -->
            <h2 class="text-2xl font-bold mb-6">Hasil Pencarian:</h2>

            <!-- Tombol kembali -->
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">
                    ← Kembali ke halaman utama
                </a>
            </div>

            <!-- Wisata Cards -->
@if($posts->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="cardContainer">
        @foreach ($posts as $post)
            <a href="{{ route('dashboard.post.details', $post->slug) }}" class="block h-full">
                <div class="category-card max-w-sm mx-auto bg-white rounded-lg shadow hover:shadow-lg transition duration-300 h-full flex flex-col">
                    <!-- Gambar -->
                    <img src="{{ Storage::url($post->thumbnail) }}" alt="Thumbnail"
                        class="rounded-t-lg w-full h-40 object-cover">

                    <!-- Konten -->
                    <div class="p-3 flex flex-col justify-between flex-grow text-sm">
                        <div>
                            <h3 class="text-base font-semibold mb-1">{{ $post->name }}</h3>
                            <p class="text-gray-600">{{ $post->category->name }}</p>
                            <p class="text-gray-600">{{ $post->place }}</p>
                        </div>

                        @foreach ($post->pricings as $pricing)
                            <p class="text-green-600 font-bold mt-3">Rp {{ number_format($pricing->price, 0, ',', '.') }}</p>
                        @endforeach
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@else
    <p class="text-gray-600">Tidak ada hasil ditemukan untuk keyword tersebut.</p>
@endif

        </div>
    </div>
</x-app-layout>
