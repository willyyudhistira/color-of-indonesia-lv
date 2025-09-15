<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

</head>
<body class="bg-gray-100 font-sans">
    
    {{-- Backdrop overlay untuk mobile (tersembunyi secara default) --}}
    <div id="sidebar-backdrop" class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

    {{-- Sidebar akan selalu di-include di sini --}}
    @include('partials.admin.sidebar')

    {{-- Wrapper Konten Utama --}}
    {{-- Diberi margin kiri di layar besar (lg) agar tidak tertutup sidebar --}}
    <div class="lg:ml-64 flex flex-col flex-1">
        
        {{-- Top Bar dipindahkan ke dalam wrapper ini --}}
        @include('partials.admin.topbar')

        {{-- Konten dari setiap halaman akan dirender di sini --}}
        <main class="flex-1 p-6 md:p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>

     {{-- Script-script penting --}}
    <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-admin.toast-notification />

    {{-- ========================================================== --}}
    {{-- == 2. TAMBAHKAN SLOT SCRIPT SEBELUM PENUTUP </body> == --}}
    {{-- ========================================================== --}}
    @stack('scripts')
</body>
</html>