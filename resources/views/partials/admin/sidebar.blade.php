@php
    $adminMenus = [
        ['name' => 'Home Page', 'route' => 'admin.dashboard', 'icon' => 'solar:home-2-bold'],
        ['name' => 'Programs', 'route' => 'admin.programs.index', 'icon' => 'solar:clipboard-list-bold'],
        ['name' => 'Main Event', 'route' => 'admin.main-events.index', 'icon' => 'solar:confetti-bold'],
        ['name' => 'Events', 'route' => 'admin.events.index', 'icon' => 'solar:calendar-bold'],
        ['name' => 'Gallery', 'route' => 'admin.gallery.index', 'icon' => 'solar:gallery-wide-bold'],
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
    <nav class="flex-1 px-4 py-6 space-y-2">
        <h2 class="px-4 mb-2 text-xs font-bold uppercase text-purple-300">
            Content Management
        </h2>
        @foreach ($adminMenus as $menu)
            {{-- PERBAIKAN: Gunakan wildcard '*' agar link tetap aktif di sub-halaman --}}
            @php $isActive = request()->routeIs(str_replace('.index', '.*', $menu['route'])); @endphp
            <a href="{{ route($menu['route']) }}"
                class="w-full text-left px-4 py-2.5 rounded-lg transition-colors text-sm flex items-center gap-3 
                          {{ $isActive ? 'bg-pink-600 text-white font-semibold' : 'text-purple-200 hover:bg-purple-700 hover:text-white' }}">
                <span class="iconify w-5 h-5" data-icon="{{ $menu['icon'] }}"></span>
                {{ $menu['name'] }}
            </a>
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