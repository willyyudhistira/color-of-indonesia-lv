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
                <swiper-container 
                    slides-per-view="1" 
                    navigation="true" 
                    autoplay-delay="5000" 
                    loop="{{ $upcomingEvents->count() > 1 ? 'true' : 'false' }}"
                    class="rounded-xl shadow-2xl">

                    @foreach($upcomingEvents as $event)
                    <swiper-slide>
                        <div class="bg-white overflow-hidden md:flex group rounded-xl">
                            <div class="md:w-1/2">
                                <img src="{{ asset('storage/' . $event->hero_image_url) }}" class="aspect-[4/3] md:aspect-auto h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500" alt="{{ $event->title }}">
                            </div>
                            <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-center">
                                <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">{{ $event->title }}</h3>
                                <div class="space-y-3 text-gray-600 mb-6">
                                    <div class="flex items-center"><span class="iconify w-5 h-5 mr-2 text-purple-600" data-icon="solar:map-point-bold"></span><span>{{ $event->location_name }}</span></div>
                                    <div class="flex items-center"><span class="iconify w-5 h-5 mr-2 text-purple-600" data-icon="solar:calendar-bold"></span><span>{{ $event->start_date->format('d F Y') }}</span></div>
                                </div>
                                <a href="{{ route('events.show', ['slug' => $event->slug]) }}" class="inline-block bg-purple-600 text-white font-bold py-2 px-6 rounded-full hover:bg-purple-700 transition-colors self-start">More Information</a>
                            </div>
                        </div>
                    </swiper-slide>
                    @endforeach
                </swiper-container>
            </div>
        @else
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-xl mb-20 flex flex-col items-center justify-center text-center p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Acara Mendatang</h3>
                <p class="text-gray-600 max-w-md mx-auto mb-6">Nantikan informasi acara kami selanjutnya di sini!</p>
                <a href="{{ route('contact.index') }}" class="bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-8 rounded-full transition-transform hover:scale-105">Hubungi Kami</a>
            </div>
        @endif

        {{-- 3. Semua Events Section --}}
        <h2 class="text-3xl md:text-4xl font-bold text-purple-700 mb-12 text-left">Semua Events</h2>
        <div class="flex items-center my-6">
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($events as $event)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group">
                    <div class="overflow-hidden h-56">
                        <img src="{{ asset('storage/' . $event->hero_image_url) }}" class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500" alt="{{ $event->title }}">
                    </div>
                    <div class="p-6 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-800 mb-3 h-14 overflow-hidden">{{ $event->title }}</h3>
                        <div class="space-y-2 text-gray-500 text-sm mb-4">
                            <div class="flex items-center"><span class="iconify w-5 h-5 mr-2 text-purple-600 flex-shrink-0" data-icon="solar:map-point-bold"></span><span>{{ $event->location_name }}</span></div>
                            <div class="flex items-center"><span class="iconify w-5 h-5 mr-2 text-purple-600 flex-shrink-0" data-icon="solar:calendar-bold"></span><span>{{ $event->start_date->format('d F Y') }}</span></div>
                        </div>
                        <a href="{{ route('events.show', ['slug' => $event->slug]) }}" class="inline-block bg-purple-100 text-purple-700 font-bold py-2 px-5 rounded-full hover:bg-purple-200 transition-colors text-sm mt-auto self-start">More Information</a>
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