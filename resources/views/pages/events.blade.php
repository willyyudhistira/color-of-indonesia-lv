@extends('layouts.app')

@section('title', 'Events - Color of Indonesia')

@section('content')

{{-- 1. Hero Section --}}
<section class="relative h-96 flex items-center justify-center text-white">
    <div class="absolute inset-0 z-0">
        {{-- Mengubah sumber gambar ke aset lokal --}}
        <img src="{{ asset('assets/images/about-hero.png') }}" 
             class="w-full h-full object-cover" alt="Balinese Dancer">
        <div class="absolute inset-0 bg-purple-900 opacity-60"></div>
    </div>
    <div class="relative z-10 text-center">
        <h1 class="text-5xl md:text-7xl font-extrabold font-serif">Rayakan Keberagaman<br>Bersama Kami</h1>
    </div>
</section>



    <div class="relative z-10 container mx-auto px-20 py-12">

        {{-- 2. Event Mendatang Section --}}
        <h2 class="text-4xl font-bold text-purple-700 mb-8 text-left">Event Mendatang</h2>
         {{-- Garis ungu custom dengan bulatan di ujungnya --}}
        <div class="flex items-center my-6">
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        </div>
        @if($upcomingEvent)
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden md:flex mb-20 group">
            <div class="md:w-1/2">
                <img src="{{ $upcomingEvent['image'] }}" class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500" alt="{{ $upcomingEvent['title'] }}">
            </div>
            <div class="md:w-1/2 p-8 flex flex-col justify-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $upcomingEvent['title'] }}</h3>
                <div class="space-y-3 text-gray-600 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.1.4-.223.654-.369.395-.226.86-.52 1.358-.863.5-.344 1.011-.728 1.488-1.14.478-.413.92-.878 1.282-1.382.362-.504.64-1.05.81-1.627.17-.577.25-1.18.25-1.782 0-2.485-2.015-4.5-4.5-4.5S5.5 7.515 5.5 10c0 .602.08 1.205.25 1.782.17.577.448 1.123.81 1.627.362.504.804.97 1.282 1.382.477.412.988.796 1.488 1.14.498.343.963.637 1.358.863.254.146.468.27.654.369a5.745 5.745 0 00.28.14l.018.008.006.003zM10 11.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd" /></svg>
                        <span>{{ $upcomingEvent['location'] }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.75 3a.75.75 0 01.75.75v.5h7V3.75a.75.75 0 011.5 0v.5h.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5H4.25a2.5 2.5 0 01-2.5-2.5V6.75a2.5 2.5 0 012.5-2.5h.5v-.5a.75.75 0 01.75-.75zM4.25 6.25c-.414 0-.75.336-.75.75v10c0 .414.336.75.75.75h11.5c.414 0 .75-.336.75-.75V7a.75.75 0 00-.75-.75H4.25z" clip-rule="evenodd" /></svg>
                        <span>{{ \Carbon\Carbon::parse($upcomingEvent['date'])->format('F d, Y') }}</span>
                    </div>
                </div>
                <a href="{{ route('events.show', ['event' => $upcomingEvent['slug']]) }}" class="inline-block bg-purple-600 text-white font-bold py-2 px-6 rounded-full hover:bg-purple-700 transition-colors self-start">More Information</a>
            </div>
        </div>
        @endif

        {{-- 3. Semua Events Section --}}
        <h2 class="text-4xl font-bold text-purple-700 mb-12 text-left">Semua Events</h2>
         {{-- Garis ungu custom dengan bulatan di ujungnya --}}
        <div class="flex items-center my-6">
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($events as $event)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group">
                    <img src="{{ $event['image'] }}" class="h-56 w-full object-cover transform group-hover:scale-105 transition-transform duration-500" alt="{{ $event['title'] }}">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3 h-14">{{ $event['title'] }}</h3>
                        <div class="space-y-2 text-gray-500 text-sm mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.1.4-.223.654-.369.395-.226.86-.52 1.358-.863.5-.344 1.011-.728 1.488-1.14.478-.413.92-.878 1.282-1.382.362-.504.64-1.05.81-1.627.17-.577.25-1.18.25-1.782 0-2.485-2.015-4.5-4.5-4.5S5.5 7.515 5.5 10c0 .602.08 1.205.25 1.782.17.577.448 1.123.81 1.627.362.504.804.97 1.282 1.382.477.412.988.796 1.488 1.14.498.343.963.637 1.358.863.254.146.468.27.654.369a5.745 5.745 0 00.28.14l.018.008.006.003zM10 11.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd" /></svg>
                                <span>{{ $event['location'] }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.75 3a.75.75 0 01.75.75v.5h7V3.75a.75.75 0 011.5 0v.5h.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5-2.5H4.25a2.5 2.5 0 01-2.5-2.5V6.75a2.5 2.5 0 012.5-2.5h.5v-.5a.75.75 0 01.75-.75zM4.25 6.25c-.414 0-.75.336-.75.75v10c0 .414.336.75.75.75h11.5c.414 0 .75-.336.75-.75V7a.75.75 0 00-.75-.75H4.25z" clip-rule="evenodd" /></svg>
                                <span>{{ \Carbon\Carbon::parse($event['date'])->format('F d, Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('events.show', ['event' => $event['slug']]) }}" class="inline-block bg-purple-100 text-purple-700 font-bold py-2 px-5 rounded-full hover:bg-purple-200 transition-colors text-sm">More Information</a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 4. Pagination Links --}}
        <div class="mt-12">
            {{ $events->links() }}
        </div>

    </div>
</div>

@endsection