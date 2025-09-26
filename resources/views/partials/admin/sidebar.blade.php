@php
    $adminMenus = [
        ['name' => 'Home Page', 'route' => 'admin.dashboard', 'icon' => 'solar:home-2-bold'],
        ['name' => 'Programs', 'route' => 'admin.programs.index', 'icon' => 'solar:clipboard-list-bold'],
        ['name' => 'Main Event', 'route' => 'admin.main-events.index', 'icon' => 'solar:confetti-bold'],
        [
            'name' => 'Events',
            'route_group' => 'admin.events.*', // Nama grup rute untuk pengecekan
            'main_route' => 'admin.events.index', // Rute utama saat diklik
            'icon' => 'solar:calendar-bold',
            'active_routes' => ['admin.events.*', 'admin.certificate-templates.*', 'admin.participants.*'],
            'submenu' => [
                ['name' => 'Certificate Template', 'route' => 'admin.certificate-templates.index', 'icon' => 'solar:document-add-bold-duotone'], // Ikon diperbarui
                ['name' => 'E-Certificate', 'route' => 'admin.participants.index', 'icon' => 'solar:medal-star-bold'],
            ]
        ],
        ['name' => 'Photo Gallery', 'route' => 'admin.gallery.index', 'icon' => 'solar:gallery-wide-bold'],
        ['name' => 'Video Gallery', 'route' => 'admin.videos.index', 'icon' => 'solar:video-library-bold'],
        ['name' => 'Sponsor', 'route' => 'admin.sponsors.index', 'icon' => 'solar:star-bold'],
        ['name' => 'News', 'route' => 'admin.news.index', 'icon' => 'solar:document-text-bold'],
        ['name' => 'Testimonials', 'route' => 'admin.testimonials.index', 'icon' => 'solar:chat-round-like-bold'],
    ];
@endphp

<aside id="admin-sidebar" class="w-64 bg-purple-800 text-white flex-col flex-shrink-0
    fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    {{-- Logo --}}
    <div class="flex justify-between items-center h-20 px-4 border-b border-purple-900">
        {{-- Logo --}}
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <img src="{{ asset('assets/images/logo_coi.png') }}" alt="Logo" class="h-10" />
            <span class="text-xl font-bold">Admin Panel</span>
        </a>
        {{-- Tombol Close (hanya muncul di layar kecil) --}}
        <button id="sidebar-close-button" class="lg:hidden text-purple-300 hover:text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Navigasi Menu --}}
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <h2 class="px-4 mb-2 text-xs font-bold uppercase text-purple-300">
            Content Management
        </h2>
        @foreach ($adminMenus as $menu)
            @if (isset($menu['submenu']))
                {{-- TAMPILAN UNTUK MENU DENGAN DROPDOWN (EVENTS) --}}
                @php 
                    // Gunakan 'active_routes' untuk pengecekan, atau buat pola default jika tidak ada
                    $patterns = $menu['active_routes'] ?? [$menu['main_route'] . '*'];
                    $isActive = request()->routeIs($patterns); 
                @endphp
                <div>
                    <a href="{{ route($menu['main_route']) }}"
                        class="w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-3 {{ $isActive ? 'bg-pink-600 text-white font-semibold' : 'text-purple-200 hover:bg-purple-700 hover:text-white' }}">
                        <span class="iconify w-5 h-5" data-icon="{{ $menu['icon'] }}"></span>
                        <span>{{ $menu['name'] }}</span>
                        {{-- Panah akan berputar jika menu aktif --}}
                        <span class="ml-auto">
                            <svg class="w-4 h-4 transition-transform duration-300 {{ $isActive ? 'rotate-180' : '' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </span>
                    </a>
                    {{-- Submenu akan tampil jika menu aktif --}}
                    <div class="mt-2 space-y-2 pl-7 {{ $isActive ? '' : 'hidden' }}">
                        @foreach ($menu['submenu'] as $submenuItem)
                            <a href="{{ route($submenuItem['route']) }}" class="w-full text-left px-4 py-2 rounded-lg transition-colors text-xs flex items-center gap-3 {{ request()->routeIs($submenuItem['route'].'*') ? 'bg-pink-700 text-white' : 'text-purple-300 hover:text-white' }}">
                                <span class="iconify w-4 h-4" data-icon="{{ $submenuItem['icon'] }}"></span>
                                {{ $submenuItem['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                {{-- TAMPILAN UNTUK MENU BIASA --}}
                @php $isActive = request()->routeIs($menu['route'] . '*'); @endphp
                <a href="{{ route($menu['route']) }}"
                    class="w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-3 {{ $isActive ? 'bg-pink-600 text-white font-semibold' : 'text-purple-200 hover:bg-purple-700 hover:text-white' }}">
                    <span class="iconify w-5 h-5" data-icon="{{ $menu['icon'] }}"></span>
                    {{ $menu['name'] }}
                </a>
            @endif
        @endforeach
    </nav>

    {{-- Tombol Logout --}}
    <div class="p-4 border-t border-purple-900">
        {{-- PERBAIKAN: Menggunakan SweetAlert2 untuk konfirmasi logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="button"
                class="logout-confirm-button w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-3 text-purple-200 hover:bg-red-600 hover:text-white">
                <span class="iconify w-5 h-5" data-icon="solar:logout-3-bold"></span>
                Logout
            </button>
        </form>
    </div>
</aside>