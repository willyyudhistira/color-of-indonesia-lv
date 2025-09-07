@extends('layouts.app')

@section('title', $event['title'])

@section('content')

{{-- 1. Hero Section --}}
<section class="relative h-96 flex items-end justify-center text-white pb-12">
    <div class="absolute inset-0 z-0">
        <img src="{{ $event['hero_image_url'] }}" class="w-full h-full object-cover" alt="{{ $event['title'] }}">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
    </div>
    <div class="relative z-10 text-center px-4">
        <h1 class="text-4xl md:text-6xl font-extrabold font-serif">{{ $event['title'] }}</h1>
    </div>
</section>

{{-- Wrapper utama dengan background pattern --}}
<div>
    <div class="relative z-10 container mx-auto px-20 py-12">
        <div class="lg:grid lg:grid-cols-3 lg:gap-12">

            {{-- 2. Kolom Kiri: Deskripsi Event --}}
            <div class="lg:col-span-2">
                <h2 class="text-3xl font-bold text-purple-700 mb-6">Tentang Acara</h2>
                <div class="prose max-w-none text-gray-600 leading-relaxed">
                    {!! $event['description'] !!} 
                    {{-- Menggunakan {!! !!} agar tag HTML seperti <p> bisa dirender --}}
                </div>
            </div>

            {{-- 3. Kolom Kanan: Info Penting --}}
            <div class="lg:col-span-1 mt-12 lg:mt-0">
                <div class="sticky top-28 bg-gray-50 rounded-xl shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Detail Event</h3>
                    <div class="space-y-4">
                        {{-- Info Tanggal --}}
                        <div class="flex items-start">
                            <svg class="w-6 h-6 mr-3 text-purple-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.75 3a.75.75 0 01.75.75v.5h7V3.75a.75.75 0 011.5 0v.5h.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5-2.5H4.25a2.5 2.5 0 01-2.5-2.5V6.75a2.5 2.5 0 012.5-2.5h.5v-.5a.75.75 0 01.75-.75zM4.25 6.25c-.414 0-.75.336-.75.75v10c0 .414.336.75.75.75h11.5c.414 0 .75-.336.75-.75V7a.75.75 0 00-.75-.75H4.25z" clip-rule="evenodd" /></svg>
                            <div>
                                <p class="font-semibold">Tanggal</p>
                                <p class="text-gray-600">{{ \Carbon\Carbon::parse($event['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($event['end_date'])->format('d M Y') }}</p>
                            </div>
                        </div>
                        {{-- Info Lokasi --}}
                        <div class="flex items-start">
                            <svg class="w-6 h-6 mr-3 text-purple-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.1.4-.223.654-.369.395-.226.86-.52 1.358-.863.5-.344 1.011-.728 1.488-1.14.478-.413.92-.878 1.282-1.382.362-.504.64-1.05.81-1.627.17-.577.25-1.18.25-1.782 0-2.485-2.015-4.5-4.5-4.5S5.5 7.515 5.5 10c0 .602.08 1.205.25 1.782.17.577.448 1.123.81 1.627.362.504.804.97 1.282 1.382.477.412.988.796 1.488 1.14.498.343.963.637 1.358.863.254.146.468.27.654.369a5.745 5.745 0 00.28.14l.018.008.006.003zM10 11.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd" /></svg>
                            <div>
                                <p class="font-semibold">{{ $event['location_name'] }}</p>
                                <p class="text-gray-600">{{ $event['address'] }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- 4. Tombol Aksi Kondisional --}}
                    <div class="mt-8">
                        @if (\Carbon\Carbon::parse($event['start_date'])->isFuture())
                            {{-- Jika event akan datang, tampilkan tombol Registrasi --}}
                            <a href="{{ $event['form_url'] }}" class="w-full block text-center bg-pink-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-pink-600 transition-transform hover:scale-105">
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
</div>

@endsection