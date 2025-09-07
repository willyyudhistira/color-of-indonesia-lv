@extends('layouts.app')

@section('title', 'Sponsorship - Color of Indonesia')

@section('content')

{{-- 1. Hero Section --}}
<section class="relative h-96 flex items-center justify-center text-white text-center">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=1200" class="w-full h-full object-cover" alt="Event Audience">
        <div class="absolute inset-0 bg-purple-900 opacity-60"></div>
    </div>
    <div class="relative z-10 px-4">
        <h1 class="text-4xl md:text-6xl font-extrabold font-serif">Jadilah Bagian dari Perayaan Budaya Terbesar</h1>
        <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto">Berpartner dengan kami untuk menjangkau ribuan audiens yang antusias dan tunjukkan komitmen Anda pada pelestarian budaya Indonesia.</p>
        <a href="#" {{-- NANTI ARAHKAN KE FORM --}}
           class="mt-8 inline-block bg-pink-500 text-white font-bold py-3 px-8 rounded-full text-lg hover:bg-pink-600 transition-transform hover:scale-105">
            Ajukan Sponsorship
        </a>
    </div>
</section>

{{-- Wrapper untuk sisa konten --}}
<div>

    {{-- 2. "Mengapa Berpartner dengan Kami?" Section --}}
    <section class="container mx-auto px-6 py-20 text-center">
        <h2 class="text-4xl font-bold text-purple-700 mb-12">Mengapa Berpartner dengan Kami?</h2>
        <div class="grid md:grid-cols-3 gap-12 max-w-6xl mx-auto">
            {{-- Poin 1: Jangkauan Luas --}}
            <div class="flex flex-col items-center">
                <div class="bg-purple-100 p-5 rounded-full mb-4">
                    <svg class="w-10 h-10 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.084-1.298-.25-1.921M12 4a4 4 0 110 8 4 4 0 010-8zM3 20h4v-2a3 3 0 00-5.356-1.857M3 20H7" /></svg>
                </div>
                <h3 class="text-2xl font-bold mb-2">Jangkauan Luas</h3>
                <p class="text-gray-600">Terhubung dengan 20,000+ pengunjung, termasuk generasi muda, keluarga, turis, dan para pegiat seni.</p>
            </div>
            {{-- Poin 2: Visibilitas Brand --}}
            <div class="flex flex-col items-center">
                <div class="bg-purple-100 p-5 rounded-full mb-4">
                    <svg class="w-10 h-10 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                </div>
                <h3 class="text-2xl font-bold mb-2">Visibilitas Brand</h3>
                <p class="text-gray-600">Logo Anda akan ditampilkan secara masif di panggung, website, media sosial, dan seluruh materi promosi kami.</p>
            </div>
            {{-- Poin 3: Dampak Positif --}}
            <div class="flex flex-col items-center">
                <div class="bg-purple-100 p-5 rounded-full mb-4">
                    <svg class="w-10 h-10 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                </div>
                <h3 class="text-2xl font-bold mb-2">Dampak Positif</h3>
                <p class="text-gray-600">Tunjukkan dukungan Anda terhadap pelestarian budaya Indonesia dan pemberdayaan komunitas seni lokal.</p>
            </div>
        </div>
    </section>

    {{-- 3. Paket Sponsorship Section --}}
    <section class="bg-purple-50 py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-purple-700 mb-12">Paket Sponsorship</h2>
            <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @foreach ($packages as $package)
                    <div class="relative bg-white rounded-lg shadow-lg p-8 border-t-4 {{ $package['featured'] ? 'border-pink-500' : 'border-purple-500' }}">
                        @if ($package['featured'])
                            <div class="absolute top-0 -translate-y-1/2 left-1/2 -translate-x-1/2 bg-pink-500 text-white text-sm font-bold px-4 py-1 rounded-full">Paling Populer</div>
                        @endif
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $package['title'] }}</h3>
                        <p class="text-4xl font-bold text-purple-700 mb-6">{{ $package['price'] }}</p>
                        <ul class="text-left space-y-3 text-gray-600 mb-8">
                            @foreach($package['benefits'] as $benefit)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    <span>{{ $benefit }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="#" class="w-full block bg-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-purple-700 transition-colors">
                            Pilih Paket
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. Final Call to Action Section --}}
    <section class="container mx-auto px-6 py-20 text-center">
         <h2 class="text-3xl font-bold text-gray-800 max-w-3xl mx-auto mb-6">Siap Berkolaborasi dan Memberi Warna bagi Indonesia?</h2>
         <a href="#" {{-- NANTI ARAHKAN KE FORM --}}
            class="inline-block bg-pink-500 text-white font-bold py-3 px-8 rounded-full text-lg hover:bg-pink-600 transition-transform hover:scale-105">
            Hubungi Tim Kami
        </a>
    </section>

</div>
@endsection