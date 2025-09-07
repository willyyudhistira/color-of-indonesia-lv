@extends('layouts.app')

@section('title', 'About Us - Color of Indonesia')

@section('content')

{{-- 1. Hero Section --}}
<section class="relative h-96 flex items-center justify-center text-white">
    <div class="absolute inset-0 z-0">
        {{-- Mengubah sumber gambar ke aset lokal --}}
        <img src="{{ asset('assets/images/about-hero.png') }}" 
             class="w-full h-full object-cover" alt="Balinese Dancer">
        <div class="absolute inset-0 bg-purple-900 opacity-60"></div>
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
        <div class="text-gray-600 leading-relaxed space-y-4 text-justify">
            <p>
                Color Of Indonesia lahir dari semangat untuk memperkenalkan keragaman budaya nusantara ke panggung dunia sebagai negara kepulauan memiliki ribuan warisan budaya, baik yang berwujud seni pertunjukan, busana, tari, maupun tradisi lisan. Melalui festival budaya, pertukaran seni, serta kolaborasi dengan berbagai komunitas global.
            </p>
            <p>
                Color of Indonesia tidak hanya sebagai penyelenggara festival, tetapi juga sebagai cultural bridge yang menghubungkan Indonesia dengan negara-negara lain melalui seni dan budaya. Dengan menjadikan budaya sebagai sarana diplomasi, Color of Indonesia mendukung upaya memperkuat identitas bangsa sekaligus menempatkan Indonesia sebagai bagian penting dalam konstelasi budaya global.
            </p>
        </div>
    </div>
</section>

    {{-- 3. Visi & Misi Section --}}
    <section class="bg-purple-50 py-20">
        <div class="container mx-auto px-6 space-y-12">
            <div class="max-w-4xl mx-auto bg-purple-100/50 border-l-4 border-purple-500 rounded-r-lg p-8">
                <h3 class="text-3xl font-bold text-purple-800 mb-4 text-center">VISI</h3>
                <p class="text-2xl text-purple-700 text-center italic">
                    “Menjadikan budaya Indonesia sebagai warna dunia melalui festival, kolaborasi, dan diplomasi budaya.”
                </p>
            </div>
            <div class="max-w-4xl mx-auto bg-purple-100/50 border-l-4 border-purple-500 rounded-r-lg p-8">
                <h3 class="text-3xl font-bold text-purple-800 mb-6 text-center">MISI</h3>
                <ul class="list-disc list-inside text-purple-700 space-y-3 text-lg">
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
    <section class="container mx-auto px-6 py-20 text-center">
        <h2 class="text-4xl font-bold text-purple-700 mb-12">Program Kami</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($programs as $program)
                <div class="relative group overflow-hidden">
                    <img src="{{ $program['image'] }}" class="w-full h-80 object-cover transform group-hover:scale-110 transition-transform duration-500" alt="{{ $program['title'] }}">
                    <div class="absolute inset-0 bg-black bg-opacity-60 group-hover:bg-opacity-40 transition-all duration-500 flex items-center justify-center">
                        <h3 class="text-white text-2xl font-bold text-center px-4">{{ $program['title'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- 5. Call to Action Section --}}
    <section>
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-3xl font-bold text-gray-800">
                "Bergabunglah dengan program kami dan mulailah perjalanan Anda"
            </h3>
        </div>
    </section>

@endsection