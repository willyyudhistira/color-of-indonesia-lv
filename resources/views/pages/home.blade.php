@php
    /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Photo> $aboutImages */
    /** @var array $homeData */
@endphp

@extends('layouts.app')

@section('title', 'Homepage')

@section('content')

    {{-- 1. Hero Carousel --}}
    @if ($homeData['carousel']->isNotEmpty())
        <div class="relative font-serif">
            <swiper-container slides-per-view="1" navigation="true" pagination="true" loop="true" effect="fade"
                autoplay-delay="4000" class="h-96">
                @foreach ($homeData['carousel'] as $slide)
                    <swiper-slide>
                        @php
                            // Logika path gambar dipindahkan ke sini agar lebih bersih
                            $imageUrl = isset($slide->is_default)
                                ? asset($slide->image_url)
                                : asset('storage/' . $slide->image_url);
                        @endphp
                        <div class="relative h-full w-full flex items-center justify-center text-white"
                            style="background-image: url('{{ $imageUrl }}'); background-size: cover; background-position: center;">
                            <div class="absolute inset-0 bg-black/60"></div>
                            <div class="relative z-10 text-center px-4">
                                <h1 class="font-serif text-5xl md:text-7xl font-extrabold tracking-tight">{!! $slide->alt_text !!}
                                </h1>
                                @if(!empty($slide->subtitle))
                                    <p class="mt-4 text-xl md:text-2xl font-light">{{ $slide->subtitle }}</p>
                                @endif
                            </div>
                        </div>
                    </swiper-slide>
                @endforeach
            </swiper-container>
        </div>
    @endif

    {{-- 2. Iklan Sponsor (Highlight) --}}
    @if ($homeData['sponsorBanners']->isNotEmpty())
        <section class="py-16 px-8 md:px-20">
            <div class="container mx-auto">
                <swiper-container slides-per-view="1" effect="fade" loop="true" autoplay-delay="3000"
                    class="w-full max-w-5xl mx-auto rounded-lg overflow-hidden shadow-xl">
                    @foreach ($homeData['sponsorBanners'] as $banner)
                        <swiper-slide>
                            <a href="{{ $banner->link_url }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset('storage/' . $banner->image_url) }}" alt="{{ $banner->name }}"
                                    class="w-full h-24 md:h-36 object-cover">
                            </a>
                        </swiper-slide>
                    @endforeach
                </swiper-container>
            </div>
        </section>
    @endif

    {{-- 3. Tentang Kami --}}
    <section class="py-24 px-8 md:px-20">
        <div class="container mx-auto grid md:grid-cols-2 gap-12 items-start">
            <div class="text-center md:text-left">
                <h2 class="text-4xl font-bold text-purple-700 mb-6">Tentang Kami</h2>
                <p class="text-gray-600 mb-8 leading-relaxed text-lg lg:text-2xl">
                    Color of Indonesia bertujuan memperkenalkan keragaman budaya nusantara ke tingkat global melalui
                    festival, pertukaran seni, dan kolaborasi internasional. Sebagai jembatan budaya, inisiatif ini
                    menampilkan Indonesia yang inklusif, kreatif, dan berwarna.
                </p>
                <a href="{{ route('about') }}"
                    class="inline-block bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-semibold py-3 px-8 rounded-full hover:opacity-90 transition-opacity">
                    Baca Cerita Kami
                </a>
            </div>

            @if($aboutImages->isNotEmpty())
                <div class="relative w-full max-w-[520px] h-[580px] mx-auto hidden md:block">
                    @php
                        // Logika ini memastikan 4 gambar ditampilkan, meskipun total foto kurang dari 4
                        $initialImages = $aboutImages->count() >= 4
                            ? $aboutImages->random(4)
                            : collect()->times(4, fn() => $aboutImages->random());
                    @endphp

                    @foreach($initialImages as $image)
                        <img id="about-img-{{ $loop->index }}" src="{{ asset('storage/' . $image->image_url) }}"
                            alt="{{ $image->caption ?? 'Tentang Kami' }}"
                            class="absolute rounded-lg shadow-xl object-cover transition-opacity duration-1000
                                                                                                                                                            @if($loop->index == 0) top-0 left-0 w-[248px] h-[310px] @endif
                                                                                                                                                            @if($loop->index == 1) top-0 left-[260px] w-[248px] h-[248px] @endif
                                                                                                                                                            @if($loop->index == 2) top-[320px] left-0 w-[248px] h-[248px] @endif
                                                                                                                                                            @if($loop->index == 3) top-[260px] left-[260px] w-[248px] h-[310px] @endif">
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <div class="flex items-center px-20">
        <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
        <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
    </div>

    {{-- 4. Spesial Untuk Anda (Main Events) --}}
    @if ($homeData['mainEvents']->isNotEmpty())
        <section class="py-24 px-8 md:px-20 text-center">
            <div class="container mx-auto">
                <h2 class="text-4xl font-bold text-purple-700 mb-4">Spesial Untuk Anda</h2>
                <p class="text-gray-600 mb-12 max-w-2xl mx-auto">“Setiap event membawa Anda lebih dekat ke impian Anda untuk
                    menjelajah, belajar, dan terhubung dengan komunitas global.”</p>

                @if ($homeData['mainEvents']->count() > 4)

                    {{-- Tampilan Slider --}}
                    <div class="relative">
                        <swiper-container slides-per-view="1" space-between="30" loop="true" autoplay-delay="3000" navigation="true"
                            breakpoints='{"768": {"slidesPerView": 2}, "1024": {"slidesPerView": 3}, "1280": {"slidesPerView": 4}}'>
                            @foreach ($homeData['mainEvents'] as $event)
                                <swiper-slide class="pb-8">
                                    {{-- Memanggil partial card --}}
                                    @include('partials.components.main-event-card', ['event' => $event])
                                </swiper-slide>
                            @endforeach
                        </swiper-container>
                    </div>

                @else

                    {{-- Tampilan Grid Statis --}}
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach ($homeData['mainEvents'] as $event)
                            {{-- Memanggil partial card --}}
                            @include('partials.components.main-event-card', ['event' => $event])
                        @endforeach
                    </div>

                @endif

                <a href="{{ route('events.index') }}"
                    class="inline-block mt-16 bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-10 rounded-full hover:opacity-90 transition-shadow shadow-lg">
                    Selengkapnya
                </a>
            </div>
        </section>
    @endif

    <div class="flex items-center px-20">
        <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
        <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
        <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
    </div>

    {{-- 5. Apa Kata Mereka (Testimonials) --}}
    @if ($homeData['testimonials']->isNotEmpty())
        <section class="py-24 px-8">
            <div class="container mx-auto">
                <h2 class="text-center text-4xl font-bold text-purple-700 mb-16">Apa Kata Mereka</h2>
                <swiper-container slides-per-view="1" loop="true" autoplay-delay="5000" effect="fade">
                    @foreach ($homeData['testimonials'] as $testimonial)
                        <swiper-slide>
                            <div class="flex flex-col md:flex-row items-center justify-center gap-12 max-w-4xl mx-auto">
                                <img src="{{ asset('storage/' . $testimonial->avatar_url) }}" alt="{{ $testimonial->author_name }}"
                                    class="rounded-lg w-64 h-64 object-cover shadow-lg flex-shrink-0">
                                <div class="text-center md:text-left">
                                    <p class="text-2xl italic text-gray-700 leading-relaxed">"{{ $testimonial->quote }}"</p>
                                    <p class="mt-6 font-bold text-lg text-purple-700">- {{ $testimonial->author_name }}</p>
                                </div>
                            </div>
                        </swiper-slide>
                    @endforeach
                </swiper-container>
            </div>
        </section>
    @endif

    {{-- 6. Logo Sponsor --}}
    @if ($homeData['sponsors']->isNotEmpty())
        <section class="py-20 bg-white">
            <div class="container mx-auto text-center">
                <h3 class="text-3xl font-bold text-purple-700 mb-12">DIDUKUNG OLEH</h3>
                <div class="flex justify-center items-center gap-x-16 gap-y-8 flex-wrap">
                    @foreach ($homeData['sponsors'] as $sponsor)
                        <a href="{{ $sponsor->website_url }}" target="_blank" rel="noopener noreferrer"
                            title="{{ $sponsor->name }}">
                            <img src="{{ asset('storage/' . $sponsor->logo_url) }}" alt="{{ $sponsor->name }}"
                                class="h-24 opacity-60 hover:opacity-100 transition" />
                        </a>
                    @endforeach
                </div>
                <a href="{{ route('sponsorship') }}"
                    class="inline-block mt-16 bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-10 rounded-full hover:opacity-90 transition-shadow shadow-lg">
                    Selengkapnya
                </a>
            </div>
        </section>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const allPhotosUrls = @json($aboutImages->pluck('image_url')->all());

                // Hentikan jika tidak ada cukup foto unik untuk dirotasi
                if (!allPhotosUrls || new Set(allPhotosUrls).size <= 4) {
                    return;
                }

                const imageElements = [
                    document.getElementById('about-img-0'), document.getElementById('about-img-1'),
                    document.getElementById('about-img-2'), document.getElementById('about-img-3')
                ].filter(el => el !== null);

                if (imageElements.length < 4) return;

                let displayedPaths = imageElements.map(el => new URL(el.src).pathname.replace('/storage/', ''));
                let pool = allPhotosUrls.filter(url => !displayedPaths.includes(url));
                let slotToChangeIndex = 0;

                function changeImage() {
                    if (pool.length === 0) {
                        // Isi ulang pool jika sudah habis
                        pool = allPhotosUrls.filter(url => !displayedPaths.includes(url));
                    }
                    if (pool.length === 0) return; // Tidak ada gambar baru untuk ditampilkan

                    const imageElementToChange = imageElements[slotToChangeIndex];
                    const oldPath = new URL(imageElementToChange.src).pathname.replace('/storage/', '');

                    const newPath = pool.shift(); // Ambil gambar pertama dari pool
                    const newImageUrl = `{{ asset('storage/') }}/${newPath}`;

                    imageElementToChange.style.opacity = '0';
                    setTimeout(() => {
                        imageElementToChange.src = newImageUrl;
                        imageElementToChange.style.opacity = '1';
                    }, 500);

                    // Perbarui daftar yang ditampilkan
                    displayedPaths[slotToChangeIndex] = newPath;
                    // Kembalikan gambar lama ke akhir pool
                    pool.push(oldPath);
                    // Pindah ke slot berikutnya
                    slotToChangeIndex = (slotToChangeIndex + 1) % imageElements.length;
                }

                setInterval(changeImage, 2700);
            });
        </script>
    @endpush

@endsection