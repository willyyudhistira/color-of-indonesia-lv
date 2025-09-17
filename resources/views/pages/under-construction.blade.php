<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Segera Hadir - Color of Indonesia</title>

    {{-- Memuat Vite untuk Tailwind CSS --}}
     <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:opsz,wght@8..144,700;8..144,900&family=Figtree:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="antialiased font-sans">
    <div class="relative min-h-screen bg-gray-900 text-white flex items-center justify-center overflow-hidden">
        {{-- Background Gradient Effect --}}
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-purple-900/80 via-transparent to-pink-900/50 opacity-50"></div>
        <div class="absolute -top-1/4 -left-1/4 w-96 h-96 bg-purple-600 rounded-full opacity-20 filter blur-3xl animate-blob"></div>
        <div class="absolute -bottom-1/4 -right-1/4 w-96 h-96 bg-pink-600 rounded-full opacity-20 filter blur-3xl animate-blob animation-delay-4000"></div>

        <div class="relative z-10 text-center p-8">
            {{-- Ikon --}}
            <div class="flex justify-center mb-8">
                <svg class="w-24 h-24 text-white/80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.953 11.953 0 0112 15c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12a8.959 8.959 0 01-2.716 6.284" />
                </svg>
            </div>

            <h1 class="font-serif text-5xl md:text-7xl font-extrabold tracking-tight">
                Segera Hadir
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-white/80 max-w-2xl mx-auto">
                Sesuatu yang hebat sedang kami persiapkan. Website Color of Indonesia akan segera diluncurkan untuk membawa warna budaya nusantara ke panggung dunia.
            </p>
        </div>
    </div>
</body>
</html>
