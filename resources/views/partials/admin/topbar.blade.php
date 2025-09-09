<header class="bg-white shadow-sm p-4 border-b border-gray-200">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-4">
            {{-- Tombol Hamburger (hanya muncul di layar kecil) --}}
            <button id="sidebar-open-button" class="lg:hidden text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            {{-- Judul halaman diambil dari section 'title' --}}
            <h1 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
        </div>
        
        <div class="flex items-center gap-3">
            @auth
                <span class="hidden sm:inline text-sm font-semibold text-gray-600">{{ Auth::user()->name ?? Auth::user()->email }}</span>
            @endauth
        </div>
    </div>
</header>