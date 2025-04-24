<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | Holi-Rang</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen font-sans bg-white">

<div class="flex h-full">
  <!-- Left Panel -->
  <div class="w-full md:w-1/2 flex flex-col justify-center items-center px-6 md:px-20">
    <h1 class="text-4xl font-bold text-green-500 mb-10">Daftar Akun</h1>
    
    <form method="POST" action="{{ route('register') }}" class="w-full max-w-sm space-y-4">
      @csrf

      <div>
        <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}"
          class="w-full px-4 py-3 rounded-xl bg-gray-200 border-none focus:outline-none focus:ring-2 focus:ring-green-400 @error('name') ring-2 ring-red-500 @enderror" required>
        @error('name')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}"
          class="w-full px-4 py-3 rounded-xl bg-gray-200 border-none focus:outline-none focus:ring-2 focus:ring-green-400 @error('email') ring-2 ring-red-500 @enderror" required>
        @error('email')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <input type="password" name="password" placeholder="Password"
          class="w-full px-4 py-3 rounded-xl bg-gray-200 border-none focus:outline-none focus:ring-2 focus:ring-green-400 @error('password') ring-2 ring-red-500 @enderror" required>
        @error('password')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
          class="w-full px-4 py-3 rounded-xl bg-gray-200 border-none focus:outline-none focus:ring-2 focus:ring-green-400" required>
        @error('password_confirmation')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <button type="submit"
        class="w-full py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full transition duration-300">
        REGISTER
      </button>

      <div class="text-center text-sm text-green-600 font-medium">
        <a href="{{ route('login') }}" class="hover:underline">Sudah punya akun? Login di sini</a>
      </div>

      <div class="flex items-center gap-2 my-4">
        <hr class="flex-grow border-gray-300">
        <span class="text-gray-500 text-sm">atau</span>
        <hr class="flex-grow border-gray-300">
      </div>

      <a href="{{ route('google.login') }}"
         class="flex items-center justify-center gap-3 border border-gray-400 py-3 rounded-full hover:bg-gray-100 transition">
        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
        <span class="text-sm font-medium text-gray-700">Daftar dengan Google</span>
      </a>
    </form>
  </div>

  <!-- Right Panel -->
  <div class="hidden md:block w-1/2 bg-cover bg-center" style="background-image: url('/photo/model2.jpg');"></div>
</div>

</body>
</html>
