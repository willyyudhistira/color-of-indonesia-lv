@extends('layouts.app')

@section('title', 'Gallery - Color of Indonesia')

@section('content')
    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white" style="background-image: url('{{ asset('assets/images/hero-gallery.png') }}'); background-size: cover; background-position: center 70%;">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        <h1 class="relative z-10 text-5xl md:text-6xl font-serif font-extrabold text-center px-4 tracking-tight">
            Abadikan Momen<br>Ciptakan Kenangan
        </h1>
    </section>
    
    {{-- Wrapper utama dengan Alpine.js untuk fitur FOKUS FOTO (MODAL) --}}
    <div x-data="{ focusedPhoto: null }" class="py-20">
        <div class="relative z-10 container mx-auto px-20">

            {{-- Judul dan Filter Dropdown --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                <div class="text-center md:text-left">
                    <h2 class="text-4xl font-bold text-purple-800 mb-3">Gallery</h2>
                </div>
                <div x-data="{ open: false }" class="relative mt-8 md:mt-0">
                    <button @click="open = !open" class="flex items-center space-x-2 px-6 py-2 rounded-full text-md font-semibold bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white shadow-md hover:bg-purple-700 transition-colors">
                        <span>{{ $selectedAlbumName }}</span>
                        <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl z-20" style="display: none;">
                        <a href="{{ route('gallery') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50">Semua Album</a>
                        @foreach($albums as $album)
                            <a href="{{ route('gallery', ['album' => $album->slug]) }}"
                               class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-700 {{ $selectedAlbumName == $album->title ? 'font-bold text-purple-700' : '' }}">
                                {{ $album->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex items-center my-6">
                <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
                <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            </div>

            {{-- ====================================================== --}}
            {{-- == PERUBAHAN UTAMA: GRID FOTO 1:1 == --}}
            {{-- ====================================================== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-1">
                @forelse ($photos as $photo)
                    <div @click="focusedPhoto = {{ Illuminate\Support\Js::from($photo) }}"
                         class="relative group aspect-square cursor-pointer overflow-hidden">
                        <img src="{{ asset('storage/' . $photo->image_url) }}" alt="{{ $photo->caption }}" 
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300"></div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 text-lg py-16">Tidak ada foto di album ini.</p>
                @endforelse
            </div>

            {{-- Link Paginasi --}}
            <div class="mt-16">
                {{ $photos->links() }}
            </div>
        </div>

        {{-- ================================================== --}}
{{-- == MODAL BARU UNTUK FOKUS FOTO & AKSI == --}}
{{-- ================================================== --}}
<div x-show="focusedPhoto" 
     @keydown.escape.window="focusedPhoto = null"
     x-cloak
     class="fixed inset-0 z-50">

    {{-- Backdrop Gelap --}}
    <div x-show="focusedPhoto" 
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
         x-transition:leave="ease-in duration-200" x-transition:leave-end="opacity-0"
         @click="focusedPhoto = null" 
         class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

    {{-- Konten Modal (Responsif) --}}
    <div x-show="focusedPhoto"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 md:opacity-0 md:scale-95"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-end="opacity-0 md:opacity-0 md:scale-95"
         class="relative w-full h-full flex items-center justify-center p-4">

        {{-- Tampilan Desktop (Centered) --}}
        <div class="hidden md:flex max-w-4xl max-h-[90vh] bg-gray-900 rounded-lg overflow-hidden">
            <img :src="focusedPhoto ? '/storage/' + focusedPhoto.image_url : ''" alt="" class="w-2/3 object-contain bg-black">
            <div class="w-1/3 p-6 flex flex-col text-white">
                <h3 class="font-bold text-lg mb-4">Detail Foto</h3>
                <p class="text-gray-300 text-sm flex-grow" x-text="focusedPhoto ? focusedPhoto.caption : ''"></p>
                {{-- Anda bisa tambahkan aksi lain di sini jika perlu untuk desktop --}}
                <button @click="focusedPhoto = null" class="mt-4 w-full bg-purple-600 hover:bg-purple-700 rounded-md py-2 transition-colors">Tutup</button>
            </div>
        </div>

        {{-- Tampilan Mobile (Bottom Sheet) --}}
        <div class="md:hidden fixed bottom-0 left-0 right-0 bg-gray-800 text-white rounded-t-2xl p-4 transform transition-transform duration-300"
             :class="{ 'translate-y-0': focusedPhoto, 'translate-y-full': !focusedPhoto }">
            <div class="mx-auto w-12 h-1.5 bg-gray-600 rounded-full mb-4"></div>
            
            {{-- Caption --}}
            <p class="text-gray-300 text-center mb-4 px-4" x-text="focusedPhoto ? focusedPhoto.caption : ''"></p>
            
            {{-- Daftar Aksi --}}
            <ul class="w-full bg-gray-900 rounded-lg">
                <li class="border-b border-gray-700"><a href="#" class="flex items-center space-x-4 p-4 hover:bg-gray-700"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg><span>Like</span></a></li>
                <li class="border-b border-gray-700"><a href="#" class="flex items-center space-x-4 p-4 hover:bg-gray-700"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12s-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" /></svg><span>Share</span></a></li>
                <li><a href="#" class="flex items-center space-x-4 p-4 text-red-500 hover:bg-gray-700"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg><span>Report</span></a></li>
            </ul>
            <button @click="focusedPhoto = null" class="mt-4 w-full bg-gray-700 hover:bg-gray-600 rounded-lg py-3 transition-colors">Cancel</button>
        </div>
    </div>
</div>
    </div>
@endsection