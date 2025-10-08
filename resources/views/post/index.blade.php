<x-app-layout>
    <x-navigation-auth />
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Search & Filter -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <!-- Search Form -->
            <form action="{{ route('dashboard.posts.search') }}" method="GET" class="w-full md:w-1/3 flex items-center gap-2">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                        </svg>
                    </div>
                    <input type="text" name="search" placeholder="Cari tempat wisata..."
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                        value="{{ request('search') }}" />
                </div>
                <button type="submit"
                    class="bg-green-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm transition">
                    Cari
                </button>
            </form> 
            
            

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('dashboard') }}">
                    <button class="category-btn bg-black text-white px-4 py-1 rounded-full hover:bg-gray-600 {{ request('category') ? '' : 'ring-2 ring-white' }}">
                        All
                    </button>
                </a>
                @foreach ( $postByCategory as $category => $posts )
                    <a href="{{ route('dashboard') }}?category={{ Str::slug($category) }}">
                        <button class="bg-green-500 text-white px-4 py-1 rounded-full hover:bg-yellow-600 {{ request('category') === Str::slug($category) ? 'ring-2 ring-white' : '' }}">
                            {{ $category }}
                        </button>
                    </a>
                @endforeach
            </div>
        </div>

       <!-- Wisata Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="cardContainer">
            @foreach ($postByCategory as $category => $posts)
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
            @endforeach
        </div>



    </div>
</div>

<!-- Script -->
{{-- <script>
    // Filter berdasarkan kategori
    const buttons = document.querySelectorAll('.category-btn');
    const cards = document.querySelectorAll('.category-card');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const category = btn.getAttribute('data-category');

            // Toggle active class
            buttons.forEach(b => b.classList.remove('active', 'bg-blue-700'));
            btn.classList.add('active', 'bg-blue-700');

            // Tampilkan/hidden card
            cards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                if (category === 'all' || cardCategory === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script> --}}


{{-- <!-- Dropdown Script -->
<script>
    document.getElementById("userDropdownBtn").addEventListener("click", function () {
        document.getElementById("userDropdown").classList.toggle("hidden");
    });
</script> --}}
</x-app-layout>