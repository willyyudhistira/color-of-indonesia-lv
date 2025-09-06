<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Color of Indonesia')</title>

    {{-- Ini akan memanggil file CSS dan JS yang sudah dikompilasi oleh Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-white">

    <div 
        class="fixed inset-0 z-0 bg-repeat opacity-10" 
        style="background-image: url('{{ asset('assets/images/backdropcoi.png') }}')">
    </div>

    <div class="relative z-10 flex flex-col min-h-screen">
        
        <header>
            {{-- Memanggil Navbar --}}
            @include('partials.navbar')
        </header>

        {{-- Konten utama dari setiap halaman akan muncul di sini --}}
        <main class="flex-grow">
            @yield('content')
        </main>

        {{-- Memanggil Footer --}}
        @include('partials.footer')

    </div>

</body>
</html>