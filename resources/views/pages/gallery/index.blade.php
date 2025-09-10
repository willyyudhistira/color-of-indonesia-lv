@extends('layouts.app')
@section('title', 'Gallery - Color of Indonesia')

@section('content')
    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white" style="background-image: url('{{ asset('assets/images/hero-gallery.png') }}'); background-size: cover; background-position: center 70%;">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        <h1 class="relative z-10 text-5xl md:text-6xl font-serif font-extrabold text-center px-4 tracking-tight">Abadikan Momen<br>Ciptakan Kenangan</h1>
    </section>

    <div class="container mx-auto px-6 md:px-20 py-20">
        <div class="text-center md:text-left mb-12">
            <h2 class="text-4xl font-bold text-purple-800 mb-3">Gallery Album</h2>
            <div class="inline-block w-24 h-1 bg-purple-600"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($albums as $album)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group">
                    <div class="overflow-hidden aspect-video">
                        <img src="{{ $album->cover_url ? asset('storage/' . $album->cover_url) : 'https://via.placeholder.com/400x300' }}" alt="{{ $album->title }}" class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-1">{{ $album->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-3">{{ $album->description }}</p>
                        <div class="flex justify-between items-center mt-auto pt-4 border-t">
                            <span class="text-sm text-gray-500">{{ $album->photos_count }} Foto</span>
                            <a href="{{ route('gallery.show', $album->slug) }}" class="inline-block bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-semibold py-2 px-5 rounded-full hover:opacity-90 text-sm">Lihat Album</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 text-lg py-16">Belum ada album yang dipublikasikan.</p>
            @endforelse
        </div>

        <div class="mt-16">{{ $albums->links() }}</div>
    </div>
@endsection