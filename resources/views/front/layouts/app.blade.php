<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>
    @yield('title')
  </title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  @stack('after-styles')
  <style>
    .swiper-pagination-bullet {
      background-color: #9ca3af; /* warna default (abu) */
      opacity: 1;
    }
  
    .swiper-pagination-bullet-active {
      background-color: #22c55e !important; /* hijau (tailwind green-500) */
    }
  </style>
  
  
</head>
<body>
    @yield('content')
</body>
</html>