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
            <h1 class="text-5xl md:text-7xl font-extrabold font-serif">Get Closer With Us</h1>
        </div>
    </section>

    {{-- Wrapper untuk konten dengan padding konsisten --}}
    <div class="container mx-auto px-6 md:px-20 py-20 space-y-20">
    
        {{-- 2. Latar Belakang Section --}}
        <section>
            <h2 class="text-4xl font-bold text-purple-700">Background</h2>
            <div class="flex items-center my-6"><div class="w-2 h-2 bg-purple-700 rounded-full"></div><div class="flex-grow h-0.5 bg-purple-700 w-full"></div><div class="w-2 h-2 bg-purple-700 rounded-full"></div></div>
            <div class="text-black leading-relaxed space-y-4 text-justify text-lg">
                <p>Color of Indonesia was born from the spirit of introducing the cultural diversity of the archipelago to the world stage. As an archipelagic nation, Indonesia possesses thousands of cultural heritages—ranging from performing arts, music, and dance to oral traditions. However, this vast potential has not yet been fully recognized on the international level.</p>
                <p>Through cultural festivals, artistic exchanges, and collaborations with global communities, Color of Indonesia is committed to presenting an image of Indonesia that is inclusive, creative, and vibrant. Its presence is not merely as a festival organizer, but as a cultural bridge that connects the global community with Indonesia through arts and culture.</p>
                <p>By positioning culture as a medium of diplomacy, Color of Indonesia supports efforts to strengthen national identity while placing Indonesia as an important part of the global cultural landscape.</p>
            </div>
        </section>

        {{-- 3. Visi & Misi Section --}}
        <section class="space-y-12">
            <div class="max-w-4xl mx-auto bg-purple-100/50 border border-purple-300 rounded-xl p-8">
                <h3 class="text-3xl font-bold text-purple-800 mb-4 text-center">Vision</h3>
                <p class="text-2xl text-black text-center italic">"To make Indonesian culture a color of the world through festivals, collaborations, and cultural diplomacy."</p>
            </div>
            <div class="max-w-4xl mx-auto bg-purple-100/50 border border-purple-300 rounded-xl p-8">
                <h3 class="text-3xl font-bold text-purple-800 mb-6 text-center">Mission</h3>
                <ul class="list-disc text-black space-y-3 text-lg">
                    <li>To introduce the richness of Indonesia's cultural diversity at both national and international levels through festivals and cultural exchange programs.</li>
                    <li>To promote Indonesia's cultural diplomacy as part of strengthening the nation's image on the global stage.</li>
                    <li>To build bridges between communities and empower younger generations to actively preserve and develop the nation's culture.</li>
                    <li>To serve as a hub for Indonesian artists, fostering cultural creativity on an international scale in line with the vision of a global city.</li>
                </ul>
            </div>
        </section>

        {{-- 4. Program Kami Section --}}
        <section>
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-purple-700">Our Programs</h2>
                <div class="flex items-center my-6  mx-auto"><div class="w-2 h-2 bg-purple-700 rounded-full"></div><div class="flex-grow h-0.5 bg-purple-700 w-full"></div><div class="w-2 h-2 bg-purple-700 rounded-full"></div></div>
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
            <h3 class="text-3xl font-bold italic text-purple-700">"Be part of our program and embark on your journey"</h3>
        </section>

    </div>
@endsection