@extends('layouts.app')

@section('title', 'Events - Color of Indonesia')

@section('content')

    {{-- 1. Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/event-hero.png') }}" class="w-full h-full object-cover" alt="Balinese Dancer">
            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        </div>
        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold font-serif">Rayakan Keberagaman<br>Bersama Kami</h1>
        </div>
    </section>

<div class="relative px-20 py-20">  {{-- 2. Event Mendatang Section --}}
<h2 class="text-4xl font-bold text-purple-700 mb-2 text-left">Event Mendatang</h2>
<div class="flex items-center my-6">
    <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
    <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
    <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
</div>

{{-- PERUBAHAN: Kondisi diubah dan struktur slider ditambahkan --}}
@if($upcomingEvents->isNotEmpty())
    <div class="relative max-w-4xl mx-auto mb-20">
        <div class="swiper upcoming-events-swiper">
            <div class="swiper-wrapper">
                
                @foreach($upcomingEvents as $event)
                <div class="swiper-slide">
                    {{-- Card event yang akan di-loop --}}
                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden md:flex group">
                        <div class="md:w-1/2">
                            <img src="{{ asset('storage/' . $event->hero_image_url) }}" class="aspect-square w-full object-cover transform group-hover:scale-105 transition-transform duration-500" alt="{{ $event->title }}">
                        </div>
                        <div class="md:w-1/2 p-8 flex flex-col justify-center">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $event->title }}</h3>
                            <div class="space-y-3 text-gray-600 mb-6">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
    </svg>
                                    <span>{{ $event->location_name }}</span>
                                </div>
                                <div class="flex items-center">
                                     <svg class="w-4 h-4 mr-2 text-purple-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <g fill="none">
            <rect width="18" height="15" x="3" y="6" stroke="currentColor" stroke-width="2" rx="2"/>
            <path fill="currentColor" d="M3 10c0-1.886 0-2.828.586-3.414S5.114 6 7 6h10c1.886 0 2.828 0 3.414.586S21 8.114 21 10z"/>
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M7 3v3m10-3v3"/>
            <rect width="4" height="2" x="7" y="12" fill="currentColor" rx=".5"/>
            <rect width="4" height="2" x="7" y="16" fill="currentColor" rx=".5"/>
            <rect width="4" height="2" x="13" y="12" fill="currentColor" rx=".5"/>
            <rect width="4" height="2" x="13" y="16" fill="currentColor" rx=".5"/>
        </g>
    </svg>
                                    <span>{{ $event->start_date->format('d F Y') }}</span>
                                </div>
                            </div>
                            <a href="{{ route('events.show', $event->slug) }}" class="inline-block bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white text-center font-bold py-2 px-6 rounded-full transition-transform hover:scale-105">Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        {{-- Tombol Navigasi Slider --}}
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
@else
    {{-- Placeholder jika tidak ada event mendatang (TIDAK BERUBAH) --}}
    <div class="max-w-4xl h-56 mx-auto bg-white rounded-xl shadow-2xl mb-20 flex flex-col items-center justify-center text-center p-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Belum Ada Acara Mendatang</h3>
        <p class="text-gray-600 max-w-md mx-auto mb-6">Ingin tetap mendapatkan informasi terbaru? Berlangganan buletin kami untuk menjadi yang pertama tahu tentang acara mendatang!</p>
        <a href="{{ route('contact') }}" class="bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white text-center font-bold py-3 px-8 rounded-full transition-transform hover:scale-105">Berlangganan Sekarang</a>
    </div>
@endif

{{-- Tambahkan style untuk tombol navigasi slider ini juga --}}
@push('styles')
<style>
    .upcoming-events-swiper .swiper-button-next,
    .upcoming-events-swiper .swiper-button-prev {
        color: #8949FF;
    }
</style>
@endpush

        {{-- 3. Semua Events Section (Event yang telah lewat) --}}
        <h2 class="text-4xl font-bold text-purple-700 mb-12 text-left">Semua Events</h2>
            <div class="flex items-center my-6">
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($events as $event)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group">
                    <img src="{{ asset('storage/' . $event->hero_image_url) }}" class="h-56 w-full object-cover transform group-hover:scale-105 transition-transform duration-500" alt="{{ $event->title }}">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3 h-14">{{ $event->title }}</h3>
                        <div class="space-y-2 text-gray-500 text-sm mb-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
    </svg>
                                <span>{{ $event->location_name }}</span>
                            </div>
                            <div class="flex items-center">
                                 <svg class="w-4 h-4 mr-2 text-purple-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <g fill="none">
            <rect width="18" height="15" x="3" y="6" stroke="currentColor" stroke-width="2" rx="2"/>
            <path fill="currentColor" d="M3 10c0-1.886 0-2.828.586-3.414S5.114 6 7 6h10c1.886 0 2.828 0 3.414.586S21 8.114 21 10z"/>
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M7 3v3m10-3v3"/>
            <rect width="4" height="2" x="7" y="12" fill="currentColor" rx=".5"/>
            <rect width="4" height="2" x="7" y="16" fill="currentColor" rx=".5"/>
            <rect width="4" height="2" x="13" y="12" fill="currentColor" rx=".5"/>
            <rect width="4" height="2" x="13" y="16" fill="currentColor" rx=".5"/>
        </g>
    </svg>
                                <span>{{ $event->start_date->format('d F Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('events.show', ['slug' => $event->slug]) }}" class="inline-block bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white text-center font-bold py-2 px-6 rounded-full transition-transform hover:scale-105">Selengkapnya</a>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Tidak ada event yang dapat ditampilkan.</p>
            @endforelse
        </div>
        </div> 

        {{-- 4. Pagination Links --}}
        <div class="mt-12">
            {{ $events->links() }}
        </div>
    </div>
@endsection