@extends('layouts.app')

@section('title', 'Events - Color of Indonesia')

@section('content')

    {{-- 1. Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/about-hero.png') }}" class="w-full h-full object-cover" alt="Balinese Dancer">
            <div class="absolute inset-0 bg-purple-900 opacity-60"></div>
        </div>
        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold font-serif">Rayakan Keberagaman<br>Bersama Kami</h1>
        </div>
    </section>

    <div class="container mx-auto px-6 md:px-20 py-12">
        {{-- 2. Event Mendatang Section --}}
        <h2 class="text-4xl font-bold text-purple-700 mb-8 text-left">Event Mendatang</h2>
        <div class="flex items-center my-6">
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        </div>
        
        @if($upcomingEvent)
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden md:flex mb-20 group">
                <div class="md:w-1/2">
                    <img src="{{ asset('storage/' . $upcomingEvent->hero_image_url) }}" class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500" alt="{{ $upcomingEvent->title }}">
                </div>
                <div class="md:w-1/2 p-8 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $upcomingEvent->title }}</h3>
                    <div class="space-y-3 text-gray-600 mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" ...><path ... /></svg>
                            <span>{{ $upcomingEvent->location_name }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" ...><path ... /></svg>
                            {{-- Gunakan properti Carbon dari model --}}
                            <span>{{ $upcomingEvent->start_date->format('d F Y') }}</span>
                        </div>
                    </div>
                    {{-- Gunakan $upcomingEvent->slug --}}
                    <a href="{{ route('events.show', ['slug' => $upcomingEvent->slug]) }}" class="inline-block bg-purple-600 text-white font-bold py-2 px-6 rounded-full hover:bg-purple-700 transition-colors self-start">More Information</a>
                </div>
            </div>
        @else
            <p class="text-center text-gray-500 mb-20">Tidak ada event yang akan datang saat ini.</p>
        @endif

        {{-- 3. Semua Events Section (Event yang telah lewat) --}}
        <h2 class="text-4xl font-bold text-purple-700 mb-12 text-left">Semua Events</h2>
        <div class="flex items-center my-6">
            {{-- ... garis dekoratif ... --}}
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($events as $event)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group">
                    <img src="{{ asset('storage/' . $event->hero_image_url) }}" class="h-56 w-full object-cover transform group-hover:scale-105 transition-transform duration-500" alt="{{ $event->title }}">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3 h-14">{{ $event->title }}</h3>
                        <div class="space-y-2 text-gray-500 text-sm mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600 flex-shrink-0" ...><path ... /></svg>
                                <span>{{ $event->location_name }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600 flex-shrink-0" ...><path ... /></svg>
                                <span>{{ $event->start_date->format('d F Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('events.show', ['slug' => $event->slug]) }}" class="inline-block bg-purple-100 text-purple-700 font-bold py-2 px-5 rounded-full hover:bg-purple-200 transition-colors text-sm">More Information</a>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Tidak ada event yang dapat ditampilkan.</p>
            @endforelse
        </div>

        {{-- 4. Pagination Links --}}
        <div class="mt-12">
            {{ $events->links() }}
        </div>
    </div>
@endsection