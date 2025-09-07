@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white" style="background-image: url('{{ asset('assets/images/hero-gallery.jpg') }}'); background-size: cover; background-position: center 70%;">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        <h1 class="relative z-10 text-5xl md:text-6xl font-extrabold text-center px-4 tracking-tight">
            Capturing Moments<br>Creating Memories
        </h1>
    </section>
    
    {{-- Wrapper utama dengan Alpine.js untuk fitur FOKUS FOTO (MODAL) --}}
    <div x-data="{ focusedImage: null }" class="py-20 bg-gray-50">
        <div class="relative z-10 container mx-auto px-6">

            {{-- Judul dan FILTER DROPDOWN --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                <div class="text-center md:text-left">
                    <h2 class="text-5xl font-bold text-purple-800 mb-3" style="font-family: 'Playfair Display', serif;">Gallery</h2>
                    <div class="inline-block w-24 h-1 bg-purple-600"></div>
                </div>

                {{-- Komponen Dropdown Filter dengan Alpine.js --}}
                <div x-data="{ open: false }" class="relative mt-8 md:mt-0">
                    <button @click="open = !open" class="flex items-center space-x-2 px-6 py-2 rounded-full text-md font-semibold bg-purple-600 text-white shadow-md hover:bg-purple-700 transition-colors">
                        {{-- Menggunakan variabel $selectedAlbumName --}}
                        <span>{{ $selectedAlbumName }}</span>
                        <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl z-20" style="display: none;">
                        {{-- Link untuk menampilkan semua album --}}
                        <a href="{{ route('gallery') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50">Semua Album</a>
                        {{-- Loop melalui $albums (semua album) --}}
                        @foreach($albums as $album)
                            <a href="{{ route('gallery', ['album' => $album->slug]) }}"
                               class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-700 {{ $selectedAlbumName == $album->title ? 'font-bold text-purple-700' : '' }}">
                                {{ $album->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Grid untuk FOTO --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Loop melalui $photos --}}
                @forelse ($photos as $photo)
                    <div @click="focusedImage = '{{ asset('storage/' . $photo->image_url) }}'"
                         class="cursor-pointer group block bg-white rounded-lg shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden">
                        <img src="{{ asset('storage/' . $photo->image_url) }}" alt="{{ $photo->caption }}" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
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

        {{-- Modal untuk FOKUS FOTO --}}
        <div x-show="focusedImage" @click.away="focusedImage = null" @keydown.escape.window="focusedImage = null"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50" style="display: none;">
             <img :src="focusedImage" alt="Focused view" class="max-w-full max-h-full rounded-lg shadow-xl">
        </div>
    </div>
@endsection