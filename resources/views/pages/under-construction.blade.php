<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coming Soon - Color of Indonesia</title>

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
                <img src="{{ asset('assets/images/logo_coi.png') }}" alt="Color Of Indonesia Logo" class="h-50" />
            </div>

            <h1 class="font-serif text-5xl md:text-7xl font-extrabold tracking-tight">
                Coming Soon
            </h1>
            <p class="mt-4 text-xl md:text-2xl text-white/80 max-w-2xl mx-auto">
                Something great is in the making. The Color of Indonesia website will soon be launched to bring the colors of the archipelago's culture to the world stage.
            </p>
        </div>
    </div>
</body>
</html>