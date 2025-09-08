@php
    $adminMenus = [
        ['name' => 'Home Page', 'route' => 'admin.dashboard', 'icon' => 'solar:home-2-bold'],
        ['name' => 'Programs', 'route' => 'admin.programs.index', 'icon' => 'solar:clipboard-list-bold'],
        ['name' => 'Main Event', 'route' => 'admin.main-events.index', 'icon' => 'solar:confetti-bold'],
        ['name' => 'Events', 'route' => 'admin.events.index', 'icon' => 'solar:calendar-bold'],
        ['name' => 'Gallery', 'route' => 'admin.gallery.index', 'icon' => 'solar:gallery-wide-bold'],
        ['name' => 'Sponsor', 'route' => 'admin.sponsors.index', 'icon' => 'solar:star-bold'], // <-- MENU BARU DITAMBAHKAN
        ['name' => 'News', 'route' => 'admin.news.index', 'icon' => 'solar:document-text-bold'],
        ['name' => 'Testimonials', 'route' => 'admin.testimonials.index', 'icon' => 'solar:chat-round-like-bold'],
    ];
@endphp

<aside class="w-64 bg-purple-800 text-white flex flex-col flex-shrink-0">
    {{-- Logo --}}
    <div class="h-20 flex items-center justify-center px-4 border-b border-purple-900">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <img src="{{ asset('assets/images/logo_coi.png') }}" alt="Logo" class="h-10" />
            <span class="text-xl font-bold">Admin Panel</span>
        </a>
    </div>
    
    {{-- Navigasi Menu --}}
    <nav class="flex-1 px-4 py-6 space-y-2">
        <h2 class="px-4 mb-2 text-xs font-bold uppercase text-purple-300">
            Content Management
        </h2>
        @foreach ($adminMenus as $menu)
            @php $isActive = request()->routeIs($menu['route']); @endphp
            <a href="{{ $menu['route'] !== '#' ? route($menu['route']) : '#' }}"
               class="w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-3 
                      {{ $isActive ? 'bg-pink-600 text-white font-semibold' : 'text-purple-200 hover:bg-purple-700 hover:text-white' }}">
                <span class="iconify w-5 h-5" data-icon="{{ $menu['icon'] }}"></span>
                {{ $menu['name'] }}
            </a>
        @endforeach
    </nav>

    {{-- Tombol Logout --}}
    <div class="p-4 border-t border-purple-900">
        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-3 text-purple-200 hover:bg-red-600 hover:text-white">
                <span class="iconify w-5 h-5" data-icon="solar:logout-3-bold"></span>
                Logout
            </button>
        </form>
    </div>
</aside>