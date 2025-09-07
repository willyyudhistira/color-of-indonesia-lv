@extends('layouts.app')

@section('title', 'Gallery - Color of Indonesia')

@section('content')

{{-- Hero Section (Tetap sama) --}}
<section class="relative h-96 flex items-center justify-center text-white">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=1200" class="w-full h-full object-cover" alt="Festival Crowd">
        <div class="absolute inset-0 bg-purple-900 opacity-60"></div>>
    </div>
    <div class="relative z-10 text-center px-4">
        <h1 class="text-5xl md:text-7xl font-extrabold font-serif">Abadikan Momen<br>Ciptakan Kenangan</h1>
    </div>
</section>

{{-- 
    Wrapper utama dengan Alpine.js untuk fitur FOKUS FOTO (MODAL)
    'focusedImage' akan menyimpan URL gambar yang sedang di-klik.
--}}
<div x-data="{ focusedImage: null }">
    <div class="relative z-10 container mx-auto px-20 py-12">
        
        {{-- Judul dan FILTER DROPDOWN --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <h2 class="text-4xl font-bold text-purple-700 mb-4 md:mb-0">Gallery</h2>
            
            {{-- Komponen Dropdown Filter dengan Alpine.js --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-2 px-6 py-2 rounded-full text-md font-semibold bg-purple-600 text-white shadow-md hover:bg-purple-700 transition-colors">
                    <span>{{ $selectedAlbum }}</span>
                    <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition
                     class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl z-20"
                     style="display: none;">
                    @foreach($albums as $album)
                        <a href="{{ route('gallery', ['album' => $album]) }}"
                           class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-700 {{ $selectedAlbum == $album ? 'font-bold text-purple-700' : '' }}">
                            {{ $album }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
          {{-- Garis ungu custom dengan bulatan di ujungnya --}}
        <div class="flex items-center my-6">
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        </div>

        {{-- GRID GALERI ALA INSTAGRAM --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-1 md:gap-2">
            @forelse ($photos as $photo)
                {{-- Setiap foto adalah tombol yang akan mengisi 'focusedImage' --}}
                <div @click="focusedImage = '{{ $photo['image'] }}'"
                     class="relative group aspect-square cursor-pointer overflow-hidden">
                    <img src="{{ $photo['image'] }}" alt="{{ $photo['album'] }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300"></div>
                </div>
            @empty
                <p class="md:col-span-3 text-center text-gray-500">Tidak ada foto di album ini.</p>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="mt-12">
            {{ $photos->appends(request()->query())->links() }}
        </div>
    </div>

    {{-- MODAL UNTUK FOKUS FOTO --}}
    <div x-show="focusedImage" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="focusedImage = null" {{-- Tutup modal saat klik background --}}
         @keydown.escape.window="focusedImage = null" {{-- Tutup modal saat tekan tombol Esc --}}
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80 backdrop-blur-sm p-4"
         style="display: none;">
        
        <img :src="focusedImage" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">

        {{-- Tombol Close di pojok kanan atas --}}
        <button @click="focusedImage = null" class="absolute top-4 right-4 text-white hover:text-gray-300">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
</div>
@endsection