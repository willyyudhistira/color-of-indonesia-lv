@extends('layouts.app')

@section('title', 'Homepage')

@section('content')

{{-- 1. Hero Carousel --}}
@if (!empty($homeData['carousel']))
<div class="relative font-serif">
    <swiper-container slides-per-view="1" navigation="true" pagination="true" loop="true" effect="fade" autoplay-delay="4000" class="h-screen">
        @foreach ($homeData['carousel'] as $slide)
        <swiper-slide>
            <div class="relative h-full w-full flex items-center justify-center text-white" style="background-image: url('{{ asset($slide['image_url']) }}'); background-size: cover; background-position: center;">
                <div class="absolute inset-0 bg-black/50"></div>
                <div class="relative z-10 text-center px-4">
                    <h1 class="font-serif text-5xl md:text-7xl font-extrabold tracking-tight">{{ $slide['alt_text'] ?? '' }}</h1>
                    <p class="mt-4 text-xl md:text-2xl font-light">{{ $slide['subtitle'] ?? '' }}</p>
                </div>
            </div>
        </swiper-slide>
        @endforeach
    </swiper-container>
</div>
@endif

{{-- 2. Tentang Kami --}}
<section class="py-24 px-20">
    <div class="container mx-auto grid md:grid-cols-2 gap-8 md:gap-16 items-center">
        <div class="text-center md:text-left">
            <h2 class="text-4xl font-bold text-purple-700 mb-6">Tentang Kami</h2>
            <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                Color of Indonesia bertujuan memperkenalkan keragaman budaya nusantara ke tingkat global melalui festival, pertukaran seni, dan kolaborasi internasional. Sebagai jembatan budaya, inisiatif ini menampilkan Indonesia yang inklusif, kreatif, dan berwarna.
            </p>
            <a href="#" class="inline-block bg-pink-600 text-white italic font-semibold py-3 px-8 rounded-full hover:bg-pink-700 transition">
                Baca Cerita Kami
            </a>
        </div>
        <div class="grid grid-cols-2 grid-rows-2 gap-4 h-96">
            @foreach($aboutImages as $index => $image)
            <div class="{{ $index == 0 ? 'row-span-2' : '' }} {{ $index == 3 ? 'row-span-2' : '' }}">
                <img src="{{ asset($image['img']) }}" alt="Tentang Kami {{ $index + 1 }}" class="w-full h-full object-cover rounded-lg shadow-lg">
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 3. Iklan Sponsor --}}
@if (!empty($homeData['sponsorBanners']))
<section class="py-12 px-20">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-bold text-purple-700 mb-8">Highlight</h2>
        <swiper-container slides-per-view="1" navigation="true" loop="true" class="w-full max-w-5xl mx-auto rounded-lg overflow-hidden">
            @foreach ($homeData['sponsorBanners'] as $banner)
            <swiper-slide>
                <div class="bg-red-600 flex items-center justify-center h-64 md:h-80">
                    <span class="text-white text-3xl font-bold">IKLAN SPONSOR</span>
                </div>
            </swiper-slide>
            @endforeach
        </swiper-container>
    </div>
</section>
@endif

{{-- 4. Mulai Petualanganmu (Events) --}}
@if (!empty($homeData['mainEvents']))
<section class="py-24 px-20">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-bold text-purple-700 mb-4">Mulai Petualanganmu</h2>
        <p class="text-gray-600 mb-12 max-w-2xl mx-auto">Kami membuka pintu bagi Anda untuk menjelajah, belajar, dan terhubung dengan komunitas global.</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($homeData['mainEvents'] as $event)
            <div class="relative rounded-lg overflow-hidden shadow-lg group h-96">
                <img src="{{ asset($event['hero_image_url']) }}" alt="{{ $event['title'] }}" class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end justify-center p-6">
                    <h3 class="text-white text-4xl font-bold">{{ last(explode(' ', $event['title'])) }}</h3>
                </div>
            </div>
            @endforeach
        </div>
        <a href="#" class="inline-block mt-16 bg-purple-600 text-white font-bold py-3 px-10 rounded-full hover:bg-purple-700 transition">
            Selengkapnya
        </a>
    </div>
</section>
@endif

{{-- 5. Apa Kata Mereka (Testimonials) --}}
@if (!empty($homeData['testimonials']))
<section class="py-24 px-8">
    <div class="container mx-auto">
        <h2 class="text-center text-4xl font-bold text-purple-700 mb-16">Apa Kata Mereka</h2>
        @foreach ($homeData['testimonials'] as $testimonial)
        <div class="flex flex-col md:flex-row items-center justify-center gap-12 max-w-4xl mx-auto">
            <div class="bg-lime-400 rounded-lg w-64 h-64 flex-shrink-0 flex items-center justify-center text-center p-4">
                <span class="text-xl font-bold text-gray-800">foto mereka saat mengikuti event</span>
            </div>
            <div class="text-center md:text-left">
                <p class="text-2xl italic text-gray-700 leading-relaxed">"{{ $testimonial['quote'] }}"</p>
                <p class="mt-6 font-bold text-lg text-purple-700">- {{ $testimonial['author_name'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- 6. Logo Sponsor --}}
@if (!empty($homeData['sponsors']))
<section class="py-20">
    <div class="container mx-auto text-center">
        <h3 class="text-3xl font-bold text-purple-700 mb-12">SPONSORSHIP</h3>
        <div class="flex justify-center items-center gap-x-16 gap-y-8 flex-wrap">
            @foreach ($homeData['sponsors'] as $sponsor)
            <img src="{{ asset($sponsor['logo_url']) }}" alt="{{ $sponsor['name'] }}" class="h-12 opacity-60 hover:opacity-100 transition" />
            @endforeach
        </div>
         <a href="#" class="inline-block mt-16 bg-red-600 text-white font-bold py-3 px-10 rounded-full hover:bg-red-700 transition">
            Selengkapnya
        </a>
    </div>
</section>
@endif

@endsection