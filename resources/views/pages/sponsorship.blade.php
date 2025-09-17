@extends('layouts.app')

@section('title', 'Sponsorship - Color of Indonesia')

@section('content')

{{-- 1. Hero Section --}}
<section class="relative h-96 flex items-center justify-center text-white text-center">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=1200" class="w-full h-full object-cover" alt="Event Audience">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
    </div>
    <div class="relative z-10 px-4">
        <h1 class="text-4xl md:text-6xl font-extrabold font-serif">Jadilah Bagian dari Perayaan Budaya Terbesar</h1>
        <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto">Jalin kerja sama dengan kami untuk menyemarakkan festival budaya lintas bangsa dan wujudkan komitmen Anda dalam menjaga serta merayakan keberagaman.</p>
    </div>
</section>

{{-- Wrapper untuk sisa konten --}}
<div>
    <div class="container mx-auto px-6 py-20 space-y-20">

        {{-- 2. "Mengapa Berpartner dengan Kami?" Section --}}
        <section class="text-center">
            <h2 class="text-4xl font-bold text-purple-700 mb-12">Mengapa Berpartner dengan Kami?</h2>
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                {{-- Poin 1: Jangkauan Luas --}}
                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 text-center">
                    <div class="inline-block bg-purple-100 p-5 rounded-full mb-4">
                        <span class="iconify w-10 h-10 text-purple-600" data-icon="solar:users-group-rounded-bold-duotone"></span>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Jangkauan Luas</h3>
                    <p class="text-gray-600">Terhubung dengan 20,000+ pengunjung, termasuk generasi muda, keluarga, turis, dan para pegiat seni.</p>
                </div>
                {{-- Poin 2: Visibilitas Brand --}}
                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 text-center">
                    <div class="inline-block bg-purple-100 p-5 rounded-full mb-4">
                        <span class="iconify w-10 h-10 text-purple-600" data-icon="solar:graph-up-bold-duotone"></span>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Visibilitas Brand</h3>
                    <p class="text-gray-600">Logo Anda akan ditampilkan secara masif di panggung, website, media sosial, dan seluruh materi promosi kami.</p>
                </div>
                {{-- Poin 3: Dampak Positif --}}
                <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100 text-center">
                    <div class="inline-block bg-purple-100 p-5 rounded-full mb-4">
                        <span class="iconify w-10 h-10 text-purple-600" data-icon="solar:heart-bold-duotone"></span>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Dampak Positif</h3>
                    <p class="text-gray-600">Tunjukkan dukungan Anda terhadap pelestarian budaya Indonesia dan pemberdayaan komunitas seni lokal.</p>
                </div>
            </div>
        </section>

        <!-- {{-- 3. Paket Sponsorship Section --}}
        <section class="text-center">
            <h2 class="text-4xl font-bold text-purple-700 mb-12">Paket Sponsorship</h2>
            <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch">
                @foreach ($packages as $package)
                    <div class="relative bg-white rounded-lg shadow-lg p-8 border-t-4 flex flex-col {{ $package['featured'] ? 'border-pink-500 transform scale-105' : 'border-purple-500' }}">
                        @if ($package['featured'])
                            <div class="absolute top-0 -translate-y-1/2 left-1/2 -translate-x-1/2 bg-pink-500 text-white text-sm font-bold px-4 py-1 rounded-full">Paling Populer</div>
                        @endif
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $package['title'] }}</h3>
                        <p class="text-4xl font-bold text-purple-700 mb-6">{{ $package['price'] }}</p>
                        <ul class="text-left space-y-3 text-gray-600 mb-8 flex-grow">
                            @foreach($package['benefits'] as $benefit)
                                <li class="flex items-start">
                                    <span class="iconify w-5 h-5 text-green-500 mr-2 flex-shrink-0 mt-0.5" data-icon="solar:check-circle-bold"></span>
                                    <span>{{ $benefit }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('contact.index') }}" class="w-full block bg-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-purple-700 transition-colors mt-auto">
                            Pilih Paket
                        </a>
                    </div>
                @endforeach
            </div>
        </section> -->

        {{-- ============================================= --}}
        {{-- ## 4. SECTION BARU: DOWNLOAD LEGALITAS ## --}}
        {{-- ============================================= --}}
        <section class="text-center">
            <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-10 border border-gray-100">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Dokumen & Legalitas</h2>
                <p class="text-gray-600 mb-6">Unduh proposal sponsorship dan dokumen legalitas kami untuk informasi lebih lanjut.</p>
                <a href="#" class="inline-block bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-10 rounded-full hover:opacity-90 transition-shadow shadow-lg flex items-center gap-3 mx-auto w-fit">
                    Download Legalitas
                </a>
            </div>
        </section>

        {{-- 5. Final Call to Action Section --}}
        <section class="text-center">
             <h2 class="text-3xl font-bold text-gray-800 max-w-3xl mx-auto mb-6">Siap Berkolaborasi dan Memberi Warna?</h2>
             <a href="{{ route('contact.index') }}"
                class="inline-block bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-8 rounded-full text-lg hover:bg-pink-600 transition-transform hover:scale-105">
                 Hubungi Tim Kami
             </a>
        </section>
    </div>
</div>
@endsection