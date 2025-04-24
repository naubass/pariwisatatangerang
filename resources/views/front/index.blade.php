@extends('front.layouts.app')
@section('title', 'Holi-Rang')
@section('content')

<!-- Navbar -->
<x-nav-guest />

<!-- Hero Section -->
<section class="bg-cover bg-center text-white h-[530px] flex items-center justify-center" style="background-image: url('/photo/model1.jpg');">
  <div class="container mx-auto text-center" data-aos="fade-down">
    <h1 class="text-4xl md:text-5xl font-bold mb-4">Jelajahi Keindahan Tangerang</h1>
    <p class="text-lg md:text-xl mb-6">Beli tiket wisata favoritmu dengan mudah dan cepat</p>
    <a href="#destinasi" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black px-6 py-3 rounded-lg text-lg font-semibold transition">Lihat Destinasi</a>
  </div>
</section>


<!-- Destinasi Section -->
<section class="py-16 bg-white" id="destinasi">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-center mb-10" data-aos="fade-up">Destinasi Populer</h2>

    <div class="swiper mySwiper">
      <div class="swiper-wrapper">

        @foreach ($postByCategory as $category => $posts)
          @foreach ($posts as $post)
            @php $isEven = $loop->iteration % 2 == 0; @endphp
            <div class="swiper-slide">
              <div class="flex flex-col md:flex-row {{ $isEven ? 'md:flex-row-reverse' : '' }} items-center bg-white rounded-lg overflow-hidden">
                <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->name }}" class="w-full md:w-1/2 h-64 object-cover" data-aos="fade-{{ $isEven ? 'left' : 'right' }}">
                <div class="p-6 md:w-1/2" data-aos="fade-{{ $isEven ? 'right' : 'left' }}">
                  <h5 class="text-2xl font-semibold mb-2">{{ $post->name }}</h5>
                  <p class="text-gray-600 mb-4">{{ $post->about }}</p>
                </div>
              </div>
            </div>
          @endforeach
        @endforeach

      </div>

      {{-- <!-- Swiper Nav -->
      <div class="flex justify-center mt-8 gap-4">
        <!-- Navigation -->
        <div class="swiper-button-prev custom-swiper-nav"></div>
        <div class="swiper-button-next custom-swiper-nav"></div>
      </div> --}}

      <!-- Pagination -->
  <div class="swiper-pagination mt-8"></div>
    </div>
  </div>
</section>



<!-- Promo Section -->
<section class="bg-gray-100 py-16" id="promo">
  <div class="max-w-4xl mx-auto text-center px-4" data-aos="fade-up">
    <h2 class="text-3xl font-bold mb-4">Pesan Tiket Sekarang!</h2>
    <p class="text-gray-600 mb-6">Dapatkan kenyamanan liburan bersama kami.</p>
    <a href="{{ route('login') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg text-lg transition">Lihat Tiket</a>
  </div>
</section>

<!-- Testimonial Section -->
<section class="py-16 bg-white" id="testimonial">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-center mb-10" data-aos="fade-up">Apa Kata Mereka?</h2>
    
    <!-- Swiper Testimonial -->
    <div class="swiper testimonialSwiper pb-12">
      <div class="swiper-wrapper">
        @foreach ($testimonials as $testimonial)
          <div class="swiper-slide">
            <div class="bg-gray-100 p-6 rounded-lg shadow-md h-full mx-2">
              
              <!-- Rating Bintang -->
              <div class="flex items-center mb-4">
                @for ($i = 0; $i < 5; $i++)
                  <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-5 h-5 text-yellow-400 mr-1">
                    <path d="M12 .587l3.668 7.431 8.2 1.193-5.934 5.782 1.4 8.173L12 18.897l-7.334 3.847 1.4-8.173L.132 9.211l8.2-1.193z"/>
                  </svg>
                @endfor
              </div>

              <!-- Deskripsi -->
              <p class="text-gray-700 mb-4">“{{ $testimonial->description }}”</p>

              <!-- Profil -->
              <div class="flex items-center space-x-4">
                <img src="{{ Storage::url($testimonial->photo) }}" alt="User" class="w-12 h-12 rounded-full object-cover">
                <div>
                  <h4 class="text-lg font-semibold">{{ $testimonial->name }}</h4>
                  <p class="text-sm text-gray-500">Testimonial</p>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white text-center py-4">
  &copy; 2025 Holi-Rang. All rights reserved.
</footer>

<!-- Swiper CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<!-- AOS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    once: false, // animasi hanya sekali
    duration: 800, // durasi default animasi
  });

  const swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
      delay: 2000, // delay antar slide dalam milidetik (5000 = 5 detik)
      disableOnInteraction: false, // tetap autoplay walau user klik/geser
    },
    speed: 1300, // durasi transisi slide (default: 300ms)
    effect: "slide", // bisa juga coba 'fade', 'cube', 'coverflow', dll
    
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });

  new Swiper(".testimonialSwiper", {
  loop: true,
  spaceBetween: 20,
  slidesPerView: 1.2,
  centeredSlides: false,
  autoplay: {
    delay: 0, // Semakin kecil, semakin cepat dan tanpa jeda
    disableOnInteraction: false,
  },
  speed: 3000, // Perpindahan antar slide dibuat lama biar smooth
  grabCursor: true,
  allowTouchMove: false, // Biar tidak bisa di-drag manual (opsional)
  breakpoints: {
    768: {
      slidesPerView: 2.2,
    },
    1024: {
      slidesPerView: 3,
    },
  },
});

</script>



@endsection
