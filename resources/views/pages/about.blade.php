@extends('layouts.app')

@section('title', 'About Us - Color of Indonesia')

@section('content')

    {{-- 1. Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/about-hero.png') }}" class="w-full h-full object-cover" alt="Balinese Dancer">
            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        </div>
        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold font-serif">Lebih Dekat Dengan Kami</h1>
        </div>
    </section>

    {{-- Wrapper untuk konten dengan padding konsisten --}}
    <div class="container mx-auto px-6 md:px-20 py-20 space-y-20">
    
        {{-- 2. Latar Belakang Section --}}
        <section>
            <h2 class="text-4xl font-bold text-purple-700">Latar</h2>
            <div class="flex items-center my-6"><div class="w-2 h-2 bg-purple-700 rounded-full"></div><div class="flex-grow h-0.5 bg-purple-700 w-full"></div><div class="w-2 h-2 bg-purple-700 rounded-full"></div></div>
            <div class="text-black leading-relaxed space-y-4 text-justify text-lg">
                <p>Color of Indonesia lahir dari semangat untuk memperkenalkan keragaman budaya nusantara ke panggung dunia. Indonesia sebagai negara kepulauan memiliki ribuan warisan budaya, baik yang berwujud seni pertunjukan, musik, tari, maupun tradisi lisan. Namun, potensi besar ini belum sepenuhnya dikenal secara luas di tingkat internasional.</p>
                <p>Melalui festival budaya, pertukaran seni, serta kolaborasi dengan berbagai komunitas global, Color of Indonesia berkomitmen menghadirkan wajah Indonesia yang inklusif, kreatif, dan penuh warna. Kehadiran Color of Indonesia bukan hanya sebagai penyelenggara festival, tetapi juga sebagai cultural bridge yang menghubungkan masyarakat dunia dengan Indonesia melalui seni dan budaya.</p>
                <p>Dengan menjadikan budaya sebagai sarana diplomasi, Color of Indonesia mendukung upaya memperkuat identitas bangsa sekaligus menempatkan Indonesia sebagai bagian penting dalam percaturan budaya global.</p>
            </div>
        </section>

        {{-- 3. Visi & Misi Section --}}
        <section class="space-y-12">
            <div class="max-w-4xl mx-auto bg-purple-100/50 border border-purple-300 rounded-xl p-8">
                <h3 class="text-3xl font-bold text-purple-800 mb-4 text-center">VISI</h3>
                <p class="text-2xl text-black text-center italic">“Menjadikan budaya Indonesia sebagai warna dunia melalui festival, kolaborasi, dan diplomasi budaya.”</p>
            </div>
            <div class="max-w-4xl mx-auto bg-purple-100/50 border border-purple-300 rounded-xl p-8">
                <h3 class="text-3xl font-bold text-purple-800 mb-6 text-center">MISI</h3>
                <ul class="list-disc list-inside text-black space-y-3 text-lg">
                    <li>Memperkenalkan keberagaman budaya Indonesia ke tingkat nasional dan internasional melalui festival dan program pertukaran budaya.</li>
                    <li>Mendorong diplomasi budaya Indonesia sebagai bagian dari promosi citra bangsa di mata dunia.</li>
                    <li>Menciptakan jembatan antarkomunitas, dan generasi muda agar aktif melestarikan dan mengembangkan budaya bangsa.</li>
                    <li>Menjadi wadah para pegiat seni di Indonesia sebagai pusat kreativitas budaya internasional, sejalan dengan visi kota global.</li>
                </ul>
            </div>
        </section>

        {{-- 4. Program Kami Section --}}
        <section>
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-purple-700">Program Kami</h2>
                <div class="flex items-center my-6 max-w-lg mx-auto"><div class="w-2 h-2 bg-purple-700 rounded-full"></div><div class="flex-grow h-0.5 bg-purple-700 w-full"></div><div class="w-2 h-2 bg-purple-700 rounded-full"></div></div>
            </div>

            @if ($programs->isNotEmpty())
                {{-- Gunakan Swiper.js untuk menampilkan program --}}
                <div class="relative">
                    <swiper-container slides-per-view="1" space-between="30" loop="true" autoplay-delay="3000" navigation="true" 
                                      breakpoints='{"768": {"slidesPerView": 2}, "1024": {"slidesPerView": 3}, "1280": {"slidesPerView": 4}}'
                                      class="program-swiper">
                        @foreach ($programs as $program)
                        <swiper-slide>
                            <div class="relative group aspect-[9/16] overflow-hidden shadow-lg rounded-lg">
                                <img src="{{ asset('storage/' . $program->icon_url) }}" class="w-full h-full object-cover transition-transform duration-500 transform group-hover:scale-110" alt="{{ $program->title }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6 transition-opacity duration-500 group-hover:opacity-0">
                                    <h3 class="text-white text-3xl font-bold font-serif">{{ $program->title }}</h3>
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-purple-800 to-pink-500/80 p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-start text-left">
                                    <h3 class="text-white text-2xl font-bold font-serif mb-2">{{ $program->title }}</h3>
                                    <p class="text-white/90 text-sm">{{ $program->description }}</p>
                                </div>
                            </div>
                        </swiper-slide>
                        @endforeach
                    </swiper-container>
                </div>
            @endif
        </section>

        {{-- 5. Call to Action Section --}}
        <section class="text-center">
            <h3 class="text-3xl font-bold italic text-purple-700">"Bergabunglah dengan program kami dan mulailah perjalanan Anda"</h3>
        </section>

    </div>
@endsection