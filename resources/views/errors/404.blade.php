{{-- resources/views/errors/404.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-white min-h-screen flex items-center justify-center p-6">
    <div class="text-center max-w-md animate-fade-in-up">
    
        <h1 class="text-6xl font-extrabold text-green-500 mb-4">404</h1>
        <p class="text-xl font-semibold text-gray-800 mb-2">Oops! Halaman tidak ditemukan</p>
        <p class="text-gray-600 mb-6">Kayaknya kamu nyasar deh... Halaman ini nggak ada atau udah dipindah.</p>
        
        <a href="{{ Auth::user() && Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('dashboard') }}"
            class="inline-block px-6 py-3 bg-green-500 text-white text-sm font-semibold rounded-full shadow hover:bg-yellow-500 transition duration-300 ease-in-out">
             Kembali ke Beranda
         </a>
         
    </div>

    <style>
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>

</body>
</html>
