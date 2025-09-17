@php
    $cwd = getcwd();
    $cssName = basename(glob($cwd . '/build/assets/*.css')[0], '.css');
    $jsName = basename(glob($cwd . '/build/assets/*.js')[0], '.js');
    $css = asset('build/assets/' . $cssName . '.css');
    $js = asset('build/assets/' . $jsName . '.js');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo_coi.png') }}" />
    <title>@yield('title', 'Color of Indonesia')</title>
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <link rel="stylesheet" href="{{ $css }}" id="css">
    <script src="{{ $js }}" id="js"></script>
</head>
<body class="bg-purple-25">

    <div
        class="fixed inset-0 z-0 bg-repeat-round opacity-25"
        style="background-image: url('{{ asset('assets/images/backdropcoi.png') }}'); background-size: 1650px ;">
    </div>

    <div class="relative z-10 flex flex-col min-h-screen">

        <header>
            @include('partials.navbar')
        </header>

        <main class="flex-grow">
            @yield('content')
        </main>

        {{-- Footer akan otomatis terdorong ke bawah --}}
        @include('partials.footer')
    </div>
    @include('partials.whatsapp-fab')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script> {{-- <-- TAMBAHKAN BARIS INI --}}
    <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>


    @stack('scripts')
</body>
</html>
