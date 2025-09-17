@extends('layouts.app')

@section('title', 'Latest News')

@section('content')

    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white" style="background-image: url('{{ asset('assets/images/hero-news.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        <h1 class="relative z-10 text-4xl md:text-6xl font-serif font-extrabold text-center px-4 tracking-tight">
            Update Budaya
        </h1>
    </section>

    {{-- News List Section --}}
    <section class="py-20">
        <div class="container mx-auto px-6 md:px-20">
            
            <div class="text-left mb-16">
                <h2 class="text-4xl font-bold text-purple-800 mb-3">Latest News</h2>
                <div class="flex items-center my-6">
                    <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                    <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
                    <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                </div>
            </div>

            {{-- Mengubah menjadi GRId untuk konsistensi tinggi kartu di desktop --}}
            {{-- Tambahkan col-span-1 di mobile untuk memastikan setiap kartu tetap mengambil satu kolom penuh --}}
            <div class="max-w-3xl mx-auto grid gap-8 grid-cols-1"> 
                @forelse ($newsItems as $item)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col md:flex-row overflow-hidden">
                        {{-- Gambar Berita --}}
                        {{-- Tinggi gambar di mobile fixed h-48, di desktop h-full --}}
                        <div class="md:w-1/3 flex-shrink-0">
                            <img src="{{ $item->image_url ? asset('storage/' . $item->image_url) : 'https://via.placeholder.com/400x300' }}" 
                                 alt="{{ $item->title }}" class="h-48 md:h-full w-full object-cover aspect-video">
                        </div>
                        
                        {{-- Konten Teks Berita --}}
                        <div class="w-full md:w-2/3 p-6 flex flex-col justify-between"> {{-- justify-between untuk push Read More ke bawah --}}
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2 leading-tight line-clamp-2">{{ $item->title }}</h3>
                                
                                {{-- Menggunakan Str::limit untuk pemotongan yang terjamin --}}
                                {{-- Dan line-clamp-2 untuk desktop, line-clamp-1 untuk mobile --}}
                                <p class="text-gray-600 text-sm mb-4 line-clamp-1">
                                    {{ Str::limit($item->excerpt, 120, '...') }} {{-- Sesuaikan angka 120 sesuai kebutuhan --}}
                                </p>
                            </div>

                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-auto pt-4 border-t border-gray-100 gap-4">
                                <p class="text-xs text-gray-500 mt-1">
                                    @if($item->source_name)
                                        {{ $item->source_name }} - 
                                    @endif
                                    {{ $item->published_at->format('d F Y') }}
                                </p>
                                <a href="{{ $item->source_url }}" target="_blank" rel="noopener noreferrer"
                                   class="bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-semibold text-sm py-2 px-6 rounded-full hover:opacity-90 transition-opacity self-start sm:self-center">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-12 text-center max-w-3xl mx-auto col-span-full">
                        <div class="flex flex-col items-center">
                            <svg class="w-16 h-16 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-700">Belum Ada Berita Terbaru</h3>
                            <p class="text-gray-500 mt-2 max-w-sm">
                                Saat ini belum ada artikel berita yang dipublikasikan. Silakan periksa kembali nanti untuk
                                pembaruan terbaru dari kami.
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="max-w-3xl mx-auto mt-16">
                {{ $newsItems->links() }}
            </div>
        </div>
    </section>

@endsection