@extends('layouts.app')

@section('title', $event->title)

@section('content')

    {{-- 1. Hero Section --}}
    <section class="relative h-96 flex items-end justify-center text-white pb-12">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/' . $event->hero_image_url) }}" class="w-full h-full object-cover" alt="{{ $event->title }}">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
        </div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-6xl font-extrabold font-serif">{{ $event->title }}</h1>
        </div>
    </section>

    <div class="container mx-auto px-6 md:px-20 py-12">
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">

            {{-- 2. Kolom Kiri: Deskripsi Event --}}
            <div class="lg:col-span-2">
                <h2 class="text-3xl font-bold text-purple-700 mb-6">Tentang Acara</h2>
                <div class="prose max-w-none text-gray-600 leading-relaxed">
                    {{-- Gunakan {!! !!} agar tag HTML seperti <p> bisa dirender --}}
                    {!! $event->description !!} 
                </div>
            </div>

            {{-- 3. Kolom Kanan: Info Penting --}}
            <div class="lg:col-span-1 mt-12 lg:mt-0">
                <div class="sticky top-28 bg-gray-50 rounded-xl shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Detail Event</h3>
                    <div class="space-y-4">
                        {{-- Info Tanggal --}}
                        <div class="flex items-start">
                            <svg class="w-6 h-6 mr-3 text-purple-600 flex-shrink-0 mt-1" ...><path ... /></svg>
                            <div>
                                <p class="font-semibold">Tanggal</p>
                                <p class="text-gray-600">{{ $event->start_date->format('d M Y') }} - {{ $event->end_date ? $event->end_date->format('d M Y') : 'Selesai' }}</p>
                            </div>
                        </div>
                        {{-- Info Lokasi --}}
                        <div class="flex items-start">
                            <svg class="w-6 h-6 mr-3 text-purple-600 flex-shrink-0 mt-1" ...><path ... /></svg>
                            <div>
                                <p class="font-semibold">{{ $event->location_name }}</p>
                                <p class="text-gray-600">{{ $event->address }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- 4. Tombol Aksi Kondisional --}}
                    <div class="mt-8">
                        @if ($event->start_date->isFuture())
                            {{-- Jika event akan datang, tampilkan tombol Registrasi --}}
                            <a href="{{ $event->form_url }}" target="_blank" class="w-full block text-center bg-pink-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-pink-600 transition-transform hover:scale-105">
                                Registrasi Sekarang
                            </a>
                        @else
                            {{-- Jika event sudah lewat, tampilkan tombol Galeri --}}
                            <a href="{{ route('gallery') }}" class="w-full block text-center bg-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-purple-700 transition-colors">
                                Lihat Galeri Acara
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection