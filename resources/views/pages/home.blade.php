@extends('layouts.app')

@section('title', 'Homepage')

@section('content')

{{-- 1. Hero Carousel --}}
@if ($homeData['carousel']->isNotEmpty())
<div class="relative font-serif">
    <swiper-container slides-per-view="1" navigation="true" pagination="true" loop="true" effect="fade" autoplay-delay="2700" class="h-96">
        @foreach ($homeData['carousel'] as $slide)
        <swiper-slide>
            {{-- Menggunakan path gambar dari storage dan akses objek --}}
            <div class="relative h-96 flex items-center justify-center text-white" style="background-image: url('{{ asset('storage/' . $slide->image_url) }}'); background-size: cover; background-position: center;">
                <div class="absolute inset-0 bg-black/50"></div>
                <div class="relative z-10 text-center px-4">
                    <h1 class="font-serif text-5xl md:text-7xl font-extrabold tracking-tight">{{ $slide->alt_text }}</h1>
                    <p class="mt-4 text-xl md:text-2xl font-light">{{ $slide->subtitle }}</p>
                </div>
            </div>
        </swiper-slide>
        @endforeach
    </swiper-container>
</div>
@endif

{{-- ## 2. Iklan Sponsor (Sekarang menjadi "Highlight" di bawah Hero) ## --}}
@if ($homeData['sponsorBanners']->isNotEmpty())
<section class="py-16 px-8 md:px-20"> {{-- -mt untuk sedikit tumpang tindih dengan hero --}}
    <div class="container mx-auto">
        <swiper-container 
            slides-per-view="1" 
            effect="fade"
            loop="true" 
            autoplay-delay="3000" 
            class="w-full mx-auto rounded-lg overflow-hidden shadow-xl border border-gray-100"> {{-- Tanpa max-w, height lebih kecil --}}
            @foreach ($homeData['sponsorBanners'] as $banner)
            <swiper-slide>
                <a href="{{ $banner->link_url }}" target="_blank">
                    <img src="{{ asset('storage/' . $banner->image_url) }}" alt="{{ $banner->name }}" class="w-full h-24 md:h-36 object-cover"> {{-- Ukuran lebih kecil --}}
                </a>
            </swiper-slide>
            @endforeach
        </swiper-container>
    </div>
</section>
@endif

{{-- 2. Tentang Kami (Bagian ini tetap menggunakan data statis) --}}
<section class="py-24 px-8 md:px-20">
    <div class="container mx-auto grid md:grid-cols-2 gap-12 items-start">
        {{-- Bagian Teks (Tidak Berubah) --}}
        <div class="text-center md:text-left">
            <h2 class="text-4xl font-bold text-purple-700 mb-6">Tentang Kami</h2>
            <p class="text-gray-600 mb-8 leading-relaxed text-3xl">
                Color of Indonesia bertujuan memperkenalkan keragaman budaya nusantara ke tingkat global melalui festival, pertukaran seni, dan kolaborasi internasional. Sebagai jembatan budaya, inisiatif ini menampilkan Indonesia yang inklusif, kreatif, dan berwarna.
            </p>
            <a href="#" class="inline-block bg-pink-600 text-white italic font-semibold py-3 px-8 rounded-full hover:bg-pink-700 transition-transform hover:scale-105">
                Baca Cerita Kami
            </a>
        </div>
        
        {{-- Grid Gambar Dinamis dari Database --}}
        @if($aboutImages->count() > 0)
            <div class="relative w-full max-w-[520px] h-[580px] mx-auto hidden md:block">
                {{-- Ambil 4 gambar pertama untuk tampilan awal --}}
                @foreach($aboutImages->take(4) as $image)
                    <img id="about-img-{{ $loop->index }}" {{-- Tambahkan ID unik --}}
                         src="{{ asset('storage/' . $image->image_url) }}" 
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

{{-- 4. Mulai Petualanganmu (Main Events) --}}
@if ($homeData['mainEvents']->isNotEmpty())
<section class="py-24 px-8 md:px-20 text-center">
    <div class="container mx-auto">
        <h2 class="text-4xl font-bold text-purple-700 mb-4">Mulai Petualanganmu</h2>
        <p class="text-gray-600 mb-12 max-w-2xl mx-auto">Kami membuka pintu bagi Anda untuk menjelajah, belajar, dan terhubung dengan komunitas global.</p>
        
        {{-- ## BAGIAN YANG DIPERBARUI DENGAN HOVER EFFECT ## --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($homeData['mainEvents'] as $event)
            <div class="relative group h-96 overflow-hidden shadow-lg rounded-lg">
                {{-- Gambar Latar --}}
                <img src="{{ asset('storage/' . $event->hero_image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 transform group-hover:scale-110" />
                
                {{-- Tampilan Default (sebelum hover) --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6 transition-opacity duration-500 group-hover:opacity-0">
                    <h3 class="text-white text-3xl font-bold font-serif">{{ last(explode(' ', $event->title)) }}</h3>
                </div>
                
                {{-- Tampilan Saat Hover --}}
                <div class="absolute inset-0 bg-gradient-to-t from-purple-800 to-pink-500/80 p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-start text-left">
                    <h3 class="text-white text-2xl font-bold font-serif mb-2">{{ $event->title }}</h3>
                    <p class="text-white/90 text-sm leading-relaxed">{{ Str::limit($event->description, 120) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        
        <a href="{{ route('events.index') }}" class="inline-block mt-16 bg-purple-600 text-white font-bold py-3 px-10 rounded-full hover:bg-purple-700 transition-transform hover:scale-105 shadow-lg">
            Selengkapnya
        </a>
    </div>
</section>
@endif

{{-- 5. Apa Kata Mereka (Testimonials) --}}
@if ($homeData['testimonials']->isNotEmpty())
<section class="py-24 px-8">
    <div class="container mx-auto">
        <h2 class="text-center text-4xl font-bold text-purple-700 mb-16">Apa Kata Mereka</h2>
        <swiper-container slides-per-view="1" loop="true" autoplay-delay="5000">
            @foreach ($homeData['testimonials'] as $testimonial)
            <swiper-slide>
                <div class="flex flex-col md:flex-row items-center justify-center gap-12 max-w-4xl mx-auto">
                    <img src="{{ asset('storage/' . $testimonial->avatar_url) }}" alt="{{ $testimonial->author_name }}" class="rounded-lg w-64 h-64 object-cover shadow-lg flex-shrink-0">
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
            <a href="{{ $sponsor->website_url }}" target="_blank" title="{{ $sponsor->name }}">
                <img src="{{ asset('storage/' . $sponsor->logo_url) }}" alt="{{ $sponsor->name }}" class="h-32 opacity-60 hover:opacity-100 transition" />
            </a>
            @endforeach
        </div>
         <a href="#" class="inline-block mt-16 bg-red-600 text-white font-bold py-3 px-10 rounded-full hover:bg-red-700 transition">
            Selengkapnya
        </a>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const allPhotos = @json($aboutImages->pluck('image_url')->all());
        
        // Keluar jika tidak ada cukup foto untuk ditampilkan
        if (!allPhotos || allPhotos.length < 1) return;

        const imageElements = [
            document.getElementById('about-img-0'),
            document.getElementById('about-img-1'),
            document.getElementById('about-img-2'),
            document.getElementById('about-img-3')
        ].filter(el => el !== null); // Filter elemen yang mungkin tidak ada

        if (imageElements.length < 4) return;

        // Fungsi yang disempurnakan untuk mengganti gambar
        function changeRandomImage() {
            // 1. Pilih slot gambar (0-3) secara acak untuk diubah
            const slotToChange = Math.floor(Math.random() * imageElements.length);
            const imageElementToChange = imageElements[slotToChange];

            // 2. Dapatkan daftar URL gambar yang TIDAK akan diubah
            const otherImageSources = imageElements
                .filter((_, index) => index !== slotToChange)
                .map(el => el.src);

            // 3. Buat daftar kandidat gambar baru
            //    Filter dari semua foto, buang yang sudah ditampilkan di 3 slot lainnya
            const candidatePhotos = allPhotos.filter(photoUrl => {
                const fullUrl = `{{ url('storage') }}/${photoUrl}`;
                return !otherImageSources.includes(fullUrl);
            });

            // 4. Pilih satu gambar baru secara acak dari daftar kandidat
            //    Jika daftar kandidat kosong (karena foto < 4), gunakan dari semua foto
            const sourcePool = candidatePhotos.length > 0 ? candidatePhotos : allPhotos;
            const newImageSrc = sourcePool[Math.floor(Math.random() * sourcePool.length)];
            const newImageUrl = `{{ asset('storage/') }}/${newImageSrc}`;

            // Jangan lakukan apa-apa jika gambar yang terpilih sama dengan yang akan diganti
            if (imageElementToChange.src === newImageUrl) return;

            // 5. Mulai animasi dan ganti gambar
            imageElementToChange.style.opacity = '0';
            setTimeout(() => {
                imageElementToChange.src = newImageUrl;
                imageElementToChange.style.opacity = '1';
            }, 1000);
        }

        // Jalankan fungsi ganti gambar setiap 2.7 detik
        if (allPhotos.length > 4) {
             setInterval(changeRandomImage, 2700);
        }
    });
</script>
@endpush

@endif

@endsection