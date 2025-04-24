<nav class="bg-green-500 px-4 py-3 shadow sticky top-0 z-50">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Kiri: Logo dan Menu Desktop -->
        <div class="flex items-center space-x-6">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="text-white text-xl font-bold">Holi-Rang</a>
    
            <!-- Menu Kategori (Desktop) -->
            <ul id="navbarMenu" class="hidden md:flex flex-row space-x-4 text-white">
                <li><a href="#destinasi" class="hover:underline">Destinasi</a></li>
                <li><a href="#paket" class="hover:underline">Paket Wisata</a></li>
                <li><a href="#kuliner" class="hover:underline">Kuliner</a></li>
                <li><a href="#event" class="hover:underline">Event</a></li>
                <li><a href="#kontak" class="hover:underline">Kontak</a></li>
            </ul>
        </div>
    
        <!-- Kanan: Dropdown User (desktop) + Hamburger (mobile) -->
        <div class="flex items-center space-x-4">
            <!-- User Dropdown (Desktop) -->
            <div class="relative hidden md:block">
                <button id="dropdownBtn" class="flex items-center space-x-2 text-white focus:outline-none">
                    <img src="{{ Auth::user()->photo ? Storage::url(Auth::user()->photo) : asset('storage/default/profile.jpg') }}"
                         alt="Profile Photo" class="w-10 h-10 rounded-full object-cover"/>
                    <span>Welcome, {{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
    
                <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg hidden z-50">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="{{ route('dashboard.post.transactions') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Transactions</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Log Out</button>
                    </form>
                </div>
            </div>
    
            <!-- Hamburger (mobile only) -->
            <button id="menuToggle" class="text-white md:hidden focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu (Kategori + User Info) -->
<div id="navbarMenuMobile" class="md:hidden hidden px-4 pb-4 animate-slide-down">
    <!-- Menu Kategori Mobile -->
    <ul class="flex flex-col space-y-2 text-white mt-4 animate-fade-in">
        <li><a href="#destinasi" class="hover:underline">Destinasi</a></li>
        <li><a href="#paket" class="hover:underline">Paket Wisata</a></li>
        <li><a href="#kuliner" class="hover:underline">Kuliner</a></li>
        <li><a href="#event" class="hover:underline">Event</a></li>
        <li><a href="#kontak" class="hover:underline">Kontak</a></li>
    </ul>

    <!-- Garis Pemisah -->
    <hr class="my-4 border-white/40" />

    <!-- Info User Mobile -->
    <div class="space-y-2 text-white animate-fade-in">
        <div class="flex items-center space-x-3">
            <img
                src="{{ Auth::user()->photo ? Storage::url(Auth::user()->photo) : asset('storage/default/profile.jpg') }}"
                alt="Profile"
                class="w-10 h-10 rounded-full object-cover"
            />
            <div>
                <p class="font-semibold">{{ Auth::user()->name }}</p>
                <p class="text-sm text-white/80">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="block hover:underline">Profile</a>
        <a href="{{ route('dashboard.post.transactions') }}" class="block hover:underline">Transactions</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left hover:underline">Log Out</button>
        </form>
    </div>
</div>

<!-- Tambahkan style animation di bawah -->
<style>
    @keyframes slide-down {
        0% {
            opacity: 0;
            transform: translateY(-10%);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .animate-slide-down {
        animation: slide-down 0.3s ease-out;
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-in;
    }
</style>




    <!-- Scripts -->
    <script>
        // Toggle desktop dropdown
        document.getElementById("dropdownBtn")?.addEventListener("click", () => {
            document.getElementById("dropdownMenu")?.classList.toggle("hidden");
        });

        // Toggle mobile menu
        document.getElementById("menuToggle").addEventListener("click", () => {
            document.getElementById("navbarMenuMobile").classList.toggle("hidden");
        });

        // Optional: Close dropdown on outside click
        document.addEventListener("click", (e) => {
            const dropdown = document.getElementById("dropdownMenu");
            const btn = document.getElementById("dropdownBtn");
            if (dropdown && btn && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add("hidden");
            }
        });
    </script>
</nav>
