{{-- resources/views/layouts/admin.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        @include('partials.admin.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm p-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
                    <div class="flex items-center gap-3">
                        {{-- ## BAGIAN YANG DIPERBAIKI ## --}}
                        @auth
                            {{-- Kode ini hanya akan berjalan jika user sudah login --}}
                            <span class="text-sm font-semibold text-gray-600">{{ Auth::user()->name ?? Auth::user()->email }}</span>
                        @endauth
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 md:p-8 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-admin.toast-notification />
</body>
</html>