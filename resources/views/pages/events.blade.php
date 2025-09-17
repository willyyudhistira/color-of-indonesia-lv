@extends('layouts.app')

@section('title', 'Events - Color of Indonesia')

@section('content')

    {{-- 1. Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/event-hero.png') }}" class="w-full h-full object-cover" alt="Balinese Dancer">
            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        </div>
        <div class="relative z-10 text-center px-4">
            {{-- Ukuran font dibuat responsif --}}
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold font-serif">Rayakan Keberagaman<br>Bersama Kami</h1>
        </div>
    </section>

    {{-- Container utama untuk sisa konten dengan padding responsif --}}
    <div class="container mx-auto px-6 md:px-20 py-16">

        {{-- 2. Event Mendatang Section --}}
        <h2 class="text-3xl md:text-4xl font-bold text-purple-700 mb-2 text-left">Event Mendatang</h2>
        <div class="flex items-center my-6">
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        </div>

        @if($upcomingEvents->isNotEmpty())
            <div class="max-w-5xl mx-auto mb-20">
                <swiper-container slides-per-view="1" navigation="true" autoplay-delay="5000"
                    loop="{{ $upcomingEvents->count() > 1 ? 'true' : 'false' }}" class="rounded-xl shadow-2xl">

                    @foreach($upcomingEvents as $event)
                        <swiper-slide>
                            <div class="bg-white overflow-hidden md:flex group rounded-xl">
                                <div class="md:w-1/2">
                                    <img src="{{ asset('storage/' . $event->hero_image_url) }}"
                                        class="aspect-[4/3] md:aspect-auto h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                        alt="{{ $event->title }}">
                                </div>
                                <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-center">
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">{{ $event->title }}</h3>
                                    <div class="space-y-3 text-gray-600 mb-6">
                                        <div class="flex items-center"><span class="iconify w-5 h-5 mr-2 text-purple-600"
                                                data-icon="solar:map-point-bold"></span><span>{{ $event->location_name }}</span>
                                        </div>
                                        <div class="flex items-center"><span class="iconify w-5 h-5 mr-2 text-purple-600"
                                                data-icon="solar:calendar-bold"></span><span>{{ $event->start_date->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('events.show', ['slug' => $event->slug]) }}"
                                        class="inline-block bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-2 px-6 rounded-full hover:opacity-90 transition-colors self-start">Selengkapnya</a>
                                </div>
                            </div>
                        </swiper-slide>
                    @endforeach
                </swiper-container>
            </div>
        @else
            <div
                class="max-w-4xl mx-auto bg-white rounded-xl shadow-xl mb-20 flex flex-col items-center justify-center text-center p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Acara Mendatang</h3>
                <p class="text-gray-600 max-w-md mx-auto mb-6">Nantikan informasi acara kami selanjutnya di sini!</p>
                <a href="{{ route('contact.index') }}"
                    class="bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-8 rounded-full transition-transform hover:scale-105">Hubungi
                    Kami</a>
            </div>
        @endif

        <!-- SECTION SEMUA EVENTS -->
        <div class="flex flex-col md:flex-row justify-between items-center mt-16 mb-6">
            <h2 class="text-3xl md:text-4xl font-bold text-purple-700 text-left">Semua Events</h2>
            <form id="month-filter-form" action="{{ route('events.index') }}" method="GET" class="relative mt-4 md:mt-0">
    {{-- Input utama untuk Flatpickr --}}
    <input 
        type="text" 
        id="monthpicker" 
        name="month" 
        placeholder="Cari Bulan & Tahun"
        value="{{ request('month') }}"
        class="w-64 cursor-pointer bg-white border border-purple-700 rounded-full py-2 pl-4 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
    >
    
    {{-- Wrapper untuk ikon-ikon di sebelah kanan --}}
    <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2">
        
        {{-- Tombol Clear Filter (hanya muncul jika ada filter) --}}
        @if(request('month'))
            <a href="{{ route('events.index') }}" class="text-gray-500 hover:text-red-600" title="Hapus Filter">
                <span class="iconify" data-icon="solar:close-circle-bold"></span>
            </a>
        @endif

        {{-- Ikon kalender (tetap ada) --}}
        <span class="text-purple-700 pointer-events-none">
            <span class="iconify" data-icon="solar:calendar-bold"></span>
        </span>
    </div>
</form>
        </div>
        <div class="flex items-center mb-8">
        </div>
        <div class="flex items-center my-6">
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($events as $event)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group">
                    <div class="overflow-hidden h-56">
                        <img src="{{ asset('storage/' . $event->hero_image_url) }}"
                            class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                            alt="{{ $event->title }}">
                    </div>
                    <div class="p-6 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-800 mb-3 h-14 overflow-hidden">{{ $event->title }}</h3>
                        <div class="space-y-2 text-gray-500 text-sm mb-4">
                            <div class="flex items-center"><span class="iconify w-5 h-5 mr-2 text-purple-600 flex-shrink-0"
                                    data-icon="solar:map-point-bold"></span><span>{{ $event->location_name }}</span></div>
                            <div class="flex items-center"><span class="iconify w-5 h-5 mr-2 text-purple-600 flex-shrink-0"
                                    data-icon="solar:calendar-bold"></span><span>{{ $event->start_date->format('d F Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('events.show', ['slug' => $event->slug]) }}"
                            class="inline-block bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-2 px-5 rounded-full hover:opacity-90 transition-colors text-sm mt-auto self-start">Selengkapnya</a>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Tidak ada event lampau yang dapat ditampilkan.</p>
            @endforelse
        </div>

        {{-- 4. Pagination Links --}}
        <div class="mt-12">
            {{ $events->links() }}
        </div>
    </div>
@endsection