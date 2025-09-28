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
                <h2 class="text-3xl font-bold text-purple-700 mb-6">Event Overview</h2>
                <div class="prose max-w-none text-gray-600 leading-relaxed">
                    {!! $event->description !!}
                </div>
            </div>

            {{-- 3. Kolom Kanan: Info Penting --}}
            <div class="lg:col-span-1 mt-12 lg:mt-0">
                <div class="sticky top-28 bg-gray-50 rounded-xl shadow-lg p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Event Information</h3>
                    <div class="space-y-4">
                        {{-- Info Tanggal --}}
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-purple-600 flex-shrink-0 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
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
                            <div>
                                <p class="font-semibold">Date</p>
                                <p class="text-gray-600">{{ $event->start_date->format('d M Y') }} - {{ $event->end_date ? $event->end_date->format('d M Y') : 'Done' }}</p>
                            </div>
                        </div>
                        {{-- Info Lokasi --}}
                        <div class="flex items-start">
                            {{-- PERBAIKAN: Ukuran ikon disamakan menjadi w-5 h-5 agar sejajar --}}
                            <svg class="w-5 h-5 mr-2 text-purple-600 flex-shrink-0 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                            </svg>
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
                            <a href="{{ $event->form_url }}" target="_blank" class="w-full block text-center bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-6 rounded-lg transition-transform hover:scale-105">
                                Register Now
                            </a>
                        @else
                            {{-- Jika event sudah lewat, tampilkan tombol Galeri --}}
                            {{-- PERBAIKAN: Typo 'rounded-l' dan kutip yang hilang (") diperbaiki --}}
                            <a href="{{ route('gallery.index') }}" class="w-full block text-center bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-6 rounded-lg transition-transform hover:scale-105">
                                View Event Gallery
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
