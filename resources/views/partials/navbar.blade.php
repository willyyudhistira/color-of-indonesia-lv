@php
    $navLinks = [
        ['title' => 'Home', 'path' => '/'],
        ['title' => 'About Us', 'path' => '/about'],
        ['title' => 'Events', 'path' => '/events'],
        ['title' => 'Gallery', 'path' => '/gallery'],
        ['title' => 'News', 'path' => '/news'],
        ['title' => 'Sponsorship', 'path' => '/sponsorship'],
        ['title' => 'Contact Us', 'path' => '/contact'],
    ];
@endphp

<nav x-data="{ isOpen: false }" class="fixed px-20 top-0 left-0 right-0 z-50 bg-white shadow-md">
    <div class="container mx-auto px-6 flex justify-between items-center h-20">
        <a href="{{ url('/') }}" class="flex-shrink-0">
            <img src="{{ asset('assets/images/logo_coi.png') }}" alt="Color Of Indonesia Logo" class="h-12" />
        </a>
        
        <div class="hidden md:flex items-center space-x-8 font-semibold text-gray-800">
            @foreach ($navLinks as $link)
                @php
                    $isActive = request()->is(ltrim($link['path'], '/') ?: '/');
                @endphp
                <a href="{{ url($link['path']) }}"
                   class="transition-colors duration-300 hover:text-purple-600 {{ $isActive ? 'text-purple-600 font-bold' : '' }}">
                    {{ $link['title'] }}
                </a>
            @endforeach
             <a href="#" title="Login / Register" class="text-gray-800 transition-colors duration-300 hover:text-purple-600">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>
        </div>

        <div class="md:hidden">
            <button @click="isOpen = !isOpen" class="text-gray-800 focus:outline-none">
                <svg x-show="!isOpen" class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-show="isOpen" class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    
    <div 
        x-show="isOpen" 
        @click.away="isOpen = false"
        x-transition
        class="md:hidden bg-white w-full shadow-lg border-t border-gray-100"
    >
        <div class="flex flex-col items-center space-y-5 py-6">
            @foreach ($navLinks as $link)
                <a href="{{ url($link['path']) }}" class="text-gray-800 font-semibold hover:text-purple-600 {{ request()->is(ltrim($link['path'], '/')) ? 'text-purple-600' : '' }}">
                    {{ $link['title'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>

{{-- Spacer untuk mendorong konten ke bawah navbar --}}
<div class="h-20"></div>