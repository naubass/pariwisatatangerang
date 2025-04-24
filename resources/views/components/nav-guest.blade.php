<nav class="bg-green-500 shadow sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- Brand -->
      <div class="flex-shrink-0">
        <a href="#" class="text-white font-bold text-xl">Holi-Rang</a>
      </div>

      <!-- Toggle Button (Mobile) -->
      <div class="md:hidden">
        <button id="menu-toggle" class="text-white focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <!-- Right Section (Desktop) -->
      <div class="hidden md:flex space-x-4">
        <a href="{{ route('login') }}"
           class="px-4 py-2 border border-white text-white rounded hover:bg-white hover:text-green-600 transition">
          Login
        </a>
        <a href="{{ route('register') }}"
           class="px-4 py-2 bg-white text-green-600 rounded hover:bg-yellow-400 hover:text-white transition">
          Register
        </a>
      </div>
    </div>
  </div>

  <!-- Mobile Menu with Animation -->
  <div id="mobile-menu"
       class="md:hidden overflow-hidden transition-all duration-300 ease-in-out max-h-0">
    <div class="px-4 pb-4">
      <a href="{{ route('login') }}"
         class="block px-4 py-2 text-white border border-white hover:bg-white hover:text-green-600 transition rounded my-1 text-center">
        Login
      </a>
      <a href="{{ route('register') }}"
         class="block px-4 py-2 bg-white text-green-600  hover:bg-yellow-400 hover:text-white transition rounded my-1 text-center">
        Register
      </a>
    </div>
  </div>

  <!-- Script Toggle -->
  <script>
    const toggleBtn = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");

    toggleBtn.addEventListener("click", () => {
      if (mobileMenu.classList.contains("max-h-0")) {
        mobileMenu.classList.remove("max-h-0");
        mobileMenu.classList.add("max-h-[200px]");
      } else {
        mobileMenu.classList.add("max-h-0");
        mobileMenu.classList.remove("max-h-[200px]");
      }
    });
  </script>
</nav>
