@extends('layouts.app')

@section('title', 'Latest News')

@section('content')

    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white"
        style="background-image: url('{{ asset('assets/images/hero-news.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        <h1 class="relative z-10 text-5xl md:text-6xl font-serif font-extrabold text-center px-4 tracking-tight">
            Update Budaya
        </h1>
    </section>

    {{-- News List Section --}}
    <section class="py-20">
        <div class="container mx-auto px-6 md:px-20">

            {{-- Judul dan Garis Dekoratif --}}
            <div class="max-w-4xl mx-auto text-left mb-16"> {{-- PERBAIKAN: Lebar maksimum menjadi max-w-3xl --}}
                <h2 class="text-4xl font-bold text-purple-800 mb-3">Latest News</h2>
                <div class="flex items-center my-6">
                    <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                    <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
                    <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                </div>
            </div>

            {{-- Daftar Berita --}}
            <div class="max-w-4xl mx-auto space-y-8"> {{-- PERBAIKAN: Lebar maksimum menjadi max-w-3xl --}}
                @forelse ($newsItems as $item)
                    <div
                        class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col md:flex-row overflow-hidden">
                        {{-- Gambar Berita --}}
                        <div class="md:w-1/2 lg:w-1/3 flex-shrink-0"> {{-- PERBAIKAN: Gambar mengambil 1/2 atau 1/3 lebar --}}
                            <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->title }}"
                                class="h-full w-full object-cover aspect-square"> {{-- PERBAIKAN: Rasio aspek square --}}
                        </div>
                        {{-- Konten Teks Berita --}}
                        <div class="md:w-1/2 lg:w-2/3 p-6 md:p-8 flex flex-col"> {{-- PERBAIKAN: Teks mengambil sisa lebar --}}
                            <h3 class="text-xl font-bold text-gray-800 mb-2 leading-tight line-clamp-2"> {{-- PERBAIKAN: Font
                                lebih kecil, leading, line-clamp --}}
                                {{ $item->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-3"> {{-- PERBAIKAN: Font lebih kecil,
                                line-clamp --}}
                                {{ $item->excerpt }}
                            </p>
                            <div class="flex justify-between items-center mt-auto"> {{-- PERBAIKAN: mt-auto untuk push ke bawah
                                --}}
                                <span class="text-xs text-gray-500">{{ $item->published_at->format('l, d F Y') }}</span> {{--
                                PERBAIKAN: Font lebih kecil --}}
                                <a href="{{ $item->source_url }}" target="_blank"
                                    class="bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-semibold text-sm py-2 px-6 rounded-full hover:opacity-90 transition-opacity">
                                    {{-- PERBAIKAN: Ukuran tombol lebih kecil --}}
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
            <div class="max-w-3xl mx-auto mt-16"> {{-- PERBAIKAN: Lebar maksimum menjadi max-w-3xl --}}
                {{ $newsItems->links() }}
            </div>
        </div>
    </section>

@endsection