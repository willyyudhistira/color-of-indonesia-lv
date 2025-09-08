@extends('layouts.app')

@section('title', 'Latest News')

@section('content')

    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white" style="background-image: url('{{ asset('assets/images/hero-news.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        <h1 class="relative z-10 text-5xl md:text-6xl font-serif font-extrabold text-center px-4 tracking-tight">
            Update Budaya
        </h1>
    </section>

   {{-- News List Section --}}
<section class="py-20">
    <div class="container mx-auto px-20">
        
        {{-- Judul dan Garis Dekoratif --}}
        {{-- PERBAIKAN: max-w-4xl dan mx-auto dihapus --}}
        <div class="text-left mb-16">
            <h2 class="text-4xl font-bold text-purple-800 mb-3">Latest News</h2>
            <div class="flex items-center my-6">
                <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
                <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            </div>
        </div>

        {{-- Daftar Berita --}}
        {{-- PERBAIKAN: max-w-4xl dan mx-auto dihapus --}}
        <div class="space-y-8">
            @forelse ($newsItems as $item)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col md:flex-row overflow-hidden">
                    {{-- Gambar Berita --}}
                    <div class="md:w-1/3">
                        <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
                    </div>
                    {{-- Konten Teks Berita --}}
                    <div class="md:w-2/3 p-6 md:p-8 flex flex-col">
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $item->title }}</h3>
                        <p class="text-gray-600 mb-4 flex-grow">{{ $item->excerpt }}</p>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-sm text-gray-500">{{ $item->published_at->format('l, d F Y') }}</span>
                            <a href="{{ $item->source_url }}" target="_blank" class="bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-semibold py-2 px-8 rounded-full hover:bg-purple-800 transition-colors duration-300">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                    <p class="text-gray-600">No news articles found.</p>
                </div>
            @endforelse
        </div>

        {{-- Link Paginasi --}}
        {{-- PERBAIKAN: max-w-4xl dan mx-auto dihapus --}}
        <div class="mt-16">
            {{ $newsItems->links() }}
        </div>

    </div>
</section>

@endsection