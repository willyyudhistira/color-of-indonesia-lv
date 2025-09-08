@extends('layouts.app')

@section('title', 'About Us - Color of Indonesia')

@section('content')

{{-- 1. Hero Section --}}
<section class="relative h-96 flex items-center justify-center text-white">
    <div class="absolute inset-0 z-0">
        {{-- Mengubah sumber gambar ke aset lokal --}}
        <img src="{{ asset('assets/images/about-hero.png') }}" 
             class="w-full h-full object-cover" alt="Balinese Dancer">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
    </div>
    <div class="relative z-10 text-center">
        <h1 class="text-5xl md:text-7xl font-extrabold font-serif">Lebih Dekat Dengan Kami</h1>
    </div>
</section>

{{-- Wrapper untuk sisa konten dengan background putih --}}
<div class="px-20">
{{-- 2. Background Section --}}
<section class="container mx-auto px-6 py-20">
    {{-- Wrapper untuk membatasi lebar konten dan merapikan layout --}}
    <div>
        {{-- Judul di kiri --}}
        <h2 class="text-4xl font-bold text-purple-700">Latar</h2>

        {{-- Garis ungu custom dengan bulatan di ujungnya --}}
        <div class="flex items-center my-6">
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        </div>
        
        {{-- Deskripsi dengan format paragraf (justify) --}}
        <div class="text-black leading-relaxed space-y-4 text-justify">
            <p>
                Color of Indonesia lahir dari semangat untuk memperkenalkan keragaman budaya nusantara ke panggung dunia. Indonesia sebagai negara kepulauan memiliki ribuan warisan budaya, baik yang berwujud seni pertunjukan, musik, tari, maupun tradisi lisan. Namun, potensi besar ini belum sepenuhnya dikenal secara luas di tingkat internasional.
            </p>
            <p>
                Melalui festival budaya, pertukaran seni, serta kolaborasi dengan berbagai komunitas global, Color of Indonesia berkomitmen menghadirkan wajah Indonesia yang inklusif, kreatif, dan penuh warna. Kehadiran Color of Indonesia bukan hanya sebagai penyelenggara festival, tetapi juga sebagai cultural bridge yang menghubungkan masyarakat dunia dengan Indonesia melalui seni dan budaya.
            </p>
            <p>
                Dengan menjadikan budaya sebagai sarana diplomasi, Color of Indonesia mendukung upaya memperkuat identitas bangsa sekaligus menempatkan Indonesia sebagai bagian penting dalam percaturan budaya global.
            </p>
        </div>
    </div>
</section>

    {{-- 3. Visi & Misi Section --}}
    <section">
        <div class="container mx-auto px-6 space-y-12">
            <div class="max-w-4xl mx-auto bg-purple-300/50 border-2 border-purple-500 rounded-xl p-8">
                <h3 class="text-3xl font-bold text-purple-800 mb-4 text-center">VISI</h3>
                <p class="text-2xl text-black text-center italic">
                    “Menjadikan budaya Indonesia sebagai warna dunia melalui festival, kolaborasi, dan diplomasi budaya.”
                </p>
            </div>
            <div class="max-w-4xl mx-auto bg-purple-300/50 border-2 border-purple-500 rounded-xl p-8">
                <h3 class="text-3xl font-bold text-purple-800 mb-6 text-center">MISI</h3>
                <ul class="list-disc list-inside text-black space-y-3 text-lg">
                    <li>Memperkenalkan keberagaman budaya Indonesia ke tingkat nasional dan internasional melalui festival dan program pertukaran budaya.</li>
                    <li>Mendorong diplomasi budaya Indonesia sebagai bagian dari promosi citra bangsa di mata dunia.</li>
                    <li>Menciptakan jembatan antarkomunitas, dan generasi muda agar aktif melestarikan dan mengembangkan budaya bangsa.</li>
                    <li>Menjadi wadah para pegiat seni di Indonesia sebagai pusat kreativitas budaya internasional, sejalan dengan visi kota global.</li>
                </ul>
            </div>
        </div>
    </section>
</div>
{{-- 4. Program Kami Section --}}
<section class="container mx-auto px-20 py-20">
    <div class="text-left mb-16">
        <h2 class="text-4xl font-bold text-purple-700 text-center">Program Kami</h2>
        <div class="flex items-center my-6">
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
            <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        </div>
    </div>

    {{-- KONDISI: Cek jumlah program --}}
    @if ($programs->count() > 4)
        
        {{-- TAMPILAN SLIDER JIKA PROGRAM LEBIH DARI 4 --}}
        <div class="relative">
            <div class="swiper program-swiper">
                <div class="swiper-wrapper">
                    {{-- Loop untuk setiap program sebagai slide --}}
                    @foreach ($programs as $program)
                        <div class="swiper-slide">
                            <div class="relative group overflow-hidden shadow-lg">
                                <img src="{{ asset('storage/' . $program->icon_url) }}" class="w-full aspect-[9/16] object-cover transition-transform duration-500 transform group-hover:scale-110" alt="{{ $program->title }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6 transition-opacity duration-500 group-hover:opacity-0">
                                    <h3 class="text-white text-3xl font-bold font-serif">{{ $program->title }}</h3>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-purple-800 to-pink-500/80 p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-start">
                                    <h3 class="text-white text-2xl font-bold font-serif mb-2">{{ $program->title }}</h3>
                                    <p class="text-white/90 text-l">{{ $program->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- Tombol Navigasi Slider --}}
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

    @else

        {{-- TAMPILAN GRID STATIS JIKA PROGRAM 4 ATAU KURANG (KODE LAMA) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($programs as $program)
                <div class="relative group overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $program->icon_url) }}" class="w-full aspect-[9/16] object-cover transition-transform duration-500 transform group-hover:scale-110" alt="{{ $program->title }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6 transition-opacity duration-500 group-hover:opacity-0">
                        <h3 class="text-white text-3xl font-bold font-serif">{{ $program->title }}</h3>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-purple-800 to-pink-500/80 p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-start">
                        <h3 class="text-white text-2xl font-bold font-serif mb-2">{{ $program->title }}</h3>
                        <p class="text-white/90 text-l">{{ $program->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

{{-- Tambahkan style untuk tombol navigasi slider agar sesuai tema --}}
@push('styles')
<style>
    .program-swiper .swiper-button-next,
    .program-swiper .swiper-button-prev {
        color: #8949FF; /* Warna ungu-pink yang sesuai */
        background-color: rgba(255, 255, 255, 0.7);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        backdrop-filter: blur(4px);
        transition: all 0.3s;
    }
    .program-swiper .swiper-button-next:hover,
    .program-swiper .swiper-button-prev:hover {
        background-color: white;
    }
    .program-swiper .swiper-button-next::after,
    .program-swiper .swiper-button-prev::after {
        font-size: 20px;
        font-weight: bold;
    }
</style>
@endpush

    {{-- 5. Call to Action Section --}}
    <section>
        <div class="container mx-auto px-6 text-center pb-20">
            <h3 class="text-3xl font-bold italic text-purple-700">
                "Bergabunglah dengan program kami dan mulailah perjalanan Anda"
            </h3>
        </div>
    </section>

@endsection