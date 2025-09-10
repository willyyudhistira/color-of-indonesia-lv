@php
    $navLinks = [
        ['title' => 'Home', 'route' => 'home'],
        ['title' => 'About Us', 'route' => 'about'],
        ['title' => 'Events', 'route' => 'events.index'],
        // ## BAGIAN YANG DIPERBARUI ##
        ['title' => 'Gallery', 'dropdown' => [
            ['title' => 'Photo', 'route' => 'gallery.index'],
            ['title' => 'Video', 'route' => 'videos.index'],
        ]],
        ['title' => 'E-Certificate', 'route' => '#'], // Menggunakan # sebagai placeholder
        // ## AKHIR BAGIAN ##
        ['title' => 'News', 'route' => 'news.index'],
        ['title' => 'Sponsorship', 'route' => 'sponsorship'],
        ['title' => 'Contact Us', 'route' => 'contact.index'],
    ];
@endphp

<nav class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md">
    <div class="container mx-auto px-6 md:px-20 flex justify-between items-center h-24">
        <a href="{{ route('home') }}" class="flex-shrink-0">
            <img src="{{ asset('assets/images/logo_coi.png') }}" alt="Color Of Indonesia Logo" class="h-20" />
        </a>

        {{-- Menu Desktop --}}
        <div class="hidden md:flex items-center space-x-8 font-semibold text-gray-800">
    @foreach ($navLinks as $link)
        @if (isset($link['dropdown']))
            {{-- TAMPILAN UNTUK ITEM DROPDOWN (GALLERY) --}}
            <div class="relative">
                <button id="gallery-dropdown-button" class="flex items-center gap-1 transition-colors duration-300 hover:text-purple-600 focus:outline-none">
                    <span>{{ $link['title'] }}</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                </button>
                <div id="gallery-dropdown-menu" class="hidden absolute left-1/2 -translate-x-1/2 mt-2 w-40 bg-white rounded-md shadow-lg py-1 z-50">
                    @foreach($link['dropdown'] as $item)
                        <a href="{{ route($item['route']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ $item['title'] }}</a>
                    @endforeach
                </div>
            </div>
        @else
            {{-- TAMPILAN UNTUK ITEM BIASA --}}
            @php $isActive = request()->routeIs($link['route']); @endphp
            <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}" class="transition-colors duration-300 hover:text-purple-600 {{ $isActive ? 'text-purple-600 font-bold' : '' }}">
                {{ $link['title'] }}
            </a>
        @endif
    @endforeach

            <div class="relative">
                @guest
                    <a href="{{ route('login') }}" title="Login"
                        class="text-gray-800 transition-colors duration-300 hover:text-purple-600">
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                @else
                {{-- Tombol untuk membuka dropdown --}}
                <button id="profile-button"
                    class="block transition-colors duration-300 hover:text-purple-600 focus:outline-none">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>

                {{-- Konten Dropdown (diberi class 'hidden' secara default) --}}
                <div id="profile-dropdown"
                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                    @if (Auth::user()->role === 'admin')
                        <a href="/admin/dashboard"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
                @endauth
            </div>
        </div>

        {{-- Tombol Menu Mobile --}}
        <div class="md:hidden">
            <button id="mobile-menu-button" class="text-gray-800 focus:outline-none">
                {{-- SVG Hamburger Icon --}}
                <svg id="hamburger-icon" class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                {{-- SVG Close Icon --}}
                <svg id="close-icon" class="w-8 h-8 hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Dropdown Menu Mobile --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white w-full shadow-lg border-t border-gray-100">
        <div class="flex flex-col items-center space-y-5 py-6">
            @foreach ($navLinks as $link)
                @if (isset($link['dropdown']))
                    {{-- Di mobile, kita tampilkan sebagai sub-judul --}}
                    <div class="text-center">
                        <span class="font-bold text-gray-500">{{ $link['title'] }}</span>
                        <div class="flex flex-col items-center space-y-3 mt-2">
                             @foreach($link['dropdown'] as $item)
                                <a href="{{ route($item['route']) }}" class="text-gray-800 font-semibold hover:text-purple-600">{{ $item['title'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}" class="text-gray-800 font-semibold hover:text-purple-600">
                        {{ $link['title'] }}
                    </a>
                @endif
            @endforeach

            <div class="w-3/4 border-t border-gray-200 my-2"></div>

            {{-- Link Auth Mobile Dinamis --}}
            @guest
                <a href="{{ route('login') }}" class="text-gray-800 font-semibold hover:text-purple-600">Login</a>
            @else
            @if (Auth::user()->role === 'admin')
                <a href="/admin/dashboard" class="text-gray-800 font-semibold hover:text-purple-600">Dashboard</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="w-full text-center">
                @csrf
                <button type="submit" class="text-gray-800 font-semibold hover:text-purple-600">Logout</button>
            </form>
            @endauth
        </div>
    </div>
</nav>

{{-- Spacer untuk mendorong konten ke bawah navbar --}}
<div class="h-20"></div>