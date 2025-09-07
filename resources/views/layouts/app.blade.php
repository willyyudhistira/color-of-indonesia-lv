<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Color of Indonesia')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-purple-25">

    <div 
        class="fixed inset-0 z-0 bg-repeat-y opacity-25" 
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

</body>
</html>