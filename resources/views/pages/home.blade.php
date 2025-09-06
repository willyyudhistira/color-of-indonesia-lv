@extends('layouts.app')

@section('title', 'Homepage')

@section('content')

{{-- Bagian Hero Carousel (Swiper) --}}
{{-- Pengecekan 'isset' untuk memastikan data dari API ada --}}
@if (isset($homeData['carousel']) && !empty($homeData['carousel']))
<div class="relative font-serif">
    <swiper-container slides-per-view="1" navigation="true" pagination="true" loop="true" effect="fade" autoplay-delay="4000" class="h-screen">
        @foreach ($homeData['carousel'] as $slide)
        <swiper-slide key="{{ $slide['id'] }}">
            {{-- Menggunakan url() untuk mengakses file dari storage publik --}}
            <div class="relative h-full w-full flex items-center justify-center text-white" style="background-image: url('{{ url('storage/' . $slide['image_url']) }}'); background-size: cover; background-position: center;">
                <div class="absolute inset-0 bg-purple-950/70"></div>
                <div class="relative z-10 text-center px-4">
                    <h1 class="font-serif text-5xl md:text-7xl font-extrabold tracking-tight">{{ $slide['alt_text'] ?? 'Color Of Indonesia' }}</h1>
                    <p class="mt-4 text-xl md:text-2xl font-light">{{ $slide['subtitle'] ?? 'Through the culture, We become One' }}</p>
                </div>
            </div>
        </swiper-slide>
        @endforeach
    </swiper-container>
</div>
@endif

{{-- Bagian Tentang Kami (Tetap sama, menggunakan Alpine.js) --}}
<section class="py-24 px-8 relative mx-auto max-w-7xl">
    <div class="relative container mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-4xl font-bold text-purple-700 mb-6">Tentang Kami</h2>
            <p class="text-gray-600 mb-8 leading-relaxed text-2xl">
                Color of Indonesia bertujuan memperkenalkan keragaman budaya nusantara ke tingkat global melalui festival, pertukaran seni, dan kolaborasi internasional.
            </p>
            <a href="#" class="inline-block bg-pink-600 text-white italic font-semibold py-3 px-8 rounded-full hover:bg-pink-700 transition-transform hover:scale-105">
                Baca Cerita Kami
            </a>
        </div>

        <div x-data="{
                images: {{ json_encode($aboutImages) }},
                currentIndex: 0,
                get largeImages() { return this.images.filter(i => i.type === 'large') },
                get smallImages() { return this.images.filter(i => i.type === 'small') },
                get displayedImages() {
                    const largeIndex1 = (this.currentIndex * 2) % this.largeImages.length;
                    const largeIndex2 = (largeIndex1 + 1) % this.largeImages.length;
                    const smallIndex1 = (this.currentIndex * 2) % this.smallImages.length;
                    const smallIndex2 = (smallIndex1 + 1) % this.smallImages.length;
                    return [ this.largeImages[largeIndex1], this.smallImages[smallIndex1], this.smallImages[smallIndex2], this.largeImages[largeIndex2] ];
                }
            }" x-init="setInterval(() => { currentIndex++ }, 5000)" class="relative w-[520px] h-[620px] mx-auto hidden md:block">
            <template x-for="(image, index) in displayedImages" :key="image.id">
                <div x-show="true" x-transition:enter="transition ease-out duration-1000" x-transition:enter-start="opacity-0" x-transition:leave="transition ease-in duration-1000" x-transition:leave-end="opacity-0" :class="{
                        'absolute top-0 left-0 w-[248px] h-[310px]': index === 0,
                        'absolute top-0 left-[260px] w-[248px] h-[248px]': index === 1,
                        'absolute top-[320px] left-0 w-[248px] h-[248px]': index === 2,
                        'absolute top-[260px] left-[260px] w-[248px] h-[310px]': index === 3
                    }">
                    <img :src="'{{ asset('') }}' + image.img" alt="Culture" class="w-full h-full object-cover rounded-lg shadow-xl">
                </div>
            </template>
        </div>
    </div>
</section>

{{-- SEMUA BAGIAN LAIN DI BAWAH INI MENGGUNAKAN LOGIKA YANG SAMA --}}
{{-- Cukup ganti src="{{ asset(...) }}" menjadi src="{{ url('storage/' . ...) }}" --}}

{{-- Contoh untuk Sponsor Banners --}}
@if (isset($homeData['sponsorBanners']) && !empty($homeData['sponsorBanners']))
<section class="py-12 mx-auto max-w-7xl px-8">
     <swiper-container slides-per-view="1" navigation="true" loop="true" effect="fade" autoplay-delay="3000" class="w-full h-[300px] mx-auto rounded-lg overflow-hidden">
        @foreach ($homeData['sponsorBanners'] as $banner)
        <swiper-slide key="{{ $banner['id'] }}">
            <img src="{{ url('storage/' . $banner['image_url']) }}" alt="Sponsor Banner" class="w-full h-full object-cover" />
        </swiper-slide>
        @endforeach
    </swiper-container>
</section>
@endif

{{-- Main Events --}}
@if (isset($homeData['mainEvents']) && !empty($homeData['mainEvents']))
<section class="py-12 text-center mx-auto max-w-7xl px-8">
    <h2 class="text-4xl font-bold text-purple-700 mb-4">Mulai Petualanganmu</h2>
    <p class="text-gray-600 mb-12 max-w-2xl mx-auto">Kami membuka pintu bagi Anda untuk menjelajah, belajar, dan terhubung.</p>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($homeData['mainEvents'] as $event)
        <div key="{{ $event['id'] }}" class="relative rounded-lg overflow-hidden shadow-2xl group cursor-pointer h-96">
            <img src="{{ url('storage/' . $event['hero_image_url']) }}" alt="{{ $event['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6 transition-opacity duration-500 group-hover:opacity-0">
                <h3 class="text-white text-3xl font-bold">{{ last(explode(' ', $event['title'])) }}</h3>
            </div>
            <div class="absolute inset-0 bg-purple-800/60 p-6 flex flex-col justify-start text-left text-white transition-opacity duration-500 opacity-0 group-hover:opacity-100">
                <h3 class="text-4xl font-extrabold">{{ last(explode(' ', $event['title'])) }}</h3>
                @if ($event['subtitle']) <p class="text-lg font-medium">{{ $event['subtitle'] }}</p> @endif
                <p class="text-sm mt-3 font-light leading-relaxed">{{ $event['description'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <a href="#" class="inline-block mt-16 bg-purple-700 text-white font-bold py-3 px-10 rounded-full hover:bg-purple-800 transition-transform hover:scale-105 shadow-lg">
        Selengkapnya
    </a>
</section>
@endif

{{-- Dan seterusnya untuk Testimonials dan Sponsors... --}}

@endsection