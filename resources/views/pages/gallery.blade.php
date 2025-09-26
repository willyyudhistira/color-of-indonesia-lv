@extends('layouts.app')

@section('title', 'Gallery - Color of Indonesia')

@section('content')
    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white"
        style="background-image: url('{{ asset('assets/images/hero-gallery.png') }}'); background-size: cover; background-position: center 70%;">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        <h1 class="relative z-10 text-5xl md:text-6xl font-serif font-extrabold text-center px-4 tracking-tight">
            Capture the Moment<br>Create Memories
        </h1>
    </section>

    <div class="py-20">
        <div class="relative z-10 container mx-auto px-6 md:px-20">

            {{-- Judul dan Filter Dropdown --}}
            <div>
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-center md:text-left">
                        <h2 class="text-4xl font-bold text-purple-800">Gallery</h2>
                    </div>

                    {{-- Dropdown Filter --}}
                    <div class="relative mt-8 md:mt-0">
                        <button id="album-filter-button"
                            class="flex items-center space-x-2 px-6 py-2 rounded-full text-md font-semibold bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white shadow-md hover:opacity-90 transition-opacity">
                            <span>{{ $selectedAlbumName }}</span>
                            <svg id="album-filter-arrow" class="w-4 h-4 transform transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="album-filter-menu"
                            class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl z-20">
                            <a href="{{ route('gallery') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50">Browse All Albums</a>
                            @foreach($albums as $album)
                                <a href="{{ route('gallery', ['album' => $album->slug]) }}"
                                    class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-700 {{ $selectedAlbumName == $album->title ? 'font-bold text-purple-700' : '' }}">
                                    {{ $album->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- KODE BARU ANDA DITEMPATKAN DI SINI --}}
                <div class="flex items-center my-6">
                    <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                    <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
                    <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                </div>
            </div>

            {{-- Grid Foto --}}
            <div id="gallery-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-1">
                @forelse ($photos as $photo)
                    {{-- ## KODE BARU DENGAN ATRIBUT data-* ## --}}
                    <div class="group cursor-pointer aspect-square overflow-hidden gallery-photo"
                        data-full-src="{{ asset('storage/' . $photo->image_url) }}"
                        data-caption="{{ $photo->caption ?: 'Tidak ada keterangan.' }}">
                        <img src="{{ asset('storage/' . $photo->image_url) }}" alt="{{ $photo->caption }}"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 text-lg py-16">No photos available in this album.</p>
                @endforelse
            </div>

            {{-- Link Paginasi --}}
            <div class="mt-16">
                {{ $photos->links() }}
            </div>
        </div>

        {{-- Modal Lightbox untuk Zoom Foto --}}
        <div id="lightbox" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            {{-- Backdrop Gelap --}}
            <div id="lightbox-backdrop" class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>
            {{-- Konten Modal --}}
            <div class="relative w-full max-w-4xl max-h-[90vh] bg-gray-900 rounded-lg shadow-xl flex flex-col md:flex-row">
                <button id="lightbox-close"
                    class="absolute -top-4 -right-4 md:top-2 md:right-2 z-10 bg-white/20 text-white rounded-full p-1 hover:bg-white/40">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="w-full md:w-2/3 bg-black flex items-center justify-center">
                    <img id="lightbox-img" src="" alt="Focused view"
                        class="max-w-full max-h-[60vh] md:max-h-[90vh] object-contain">
                </div>
                <div class="w-full md:w-1/3 p-6 flex flex-col text-white">
                    <h3 class="font-bold text-lg mb-4 border-b border-gray-700 pb-2">Photo Details</h3>
                    <p id="lightbox-caption" class="text-gray-300 text-sm flex-grow"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // --- LOGIKA UNTUK DROPDOWN FILTER GALERI ---
            const filterButton = document.getElementById('album-filter-button');
            const filterMenu = document.getElementById('album-filter-menu');
            const filterArrow = document.getElementById('album-filter-arrow');

            if (filterButton && filterMenu && filterArrow) {
                filterButton.addEventListener('click', function (event) {
                    event.stopPropagation();
                    filterMenu.classList.toggle('hidden');
                    filterArrow.classList.toggle('rotate-180');
                });

                window.addEventListener('click', function (event) {
                    if (!filterMenu.classList.contains('hidden') && !filterButton.contains(event.target)) {
                        filterMenu.classList.add('hidden');
                        filterArrow.classList.remove('rotate-180');
                    }
                });
            }

            // --- LOGIKA UNTUK LIGHTBOX (ZOOM GAMBAR) ---
            const galleryGrid = document.getElementById('gallery-grid');
            const lightbox = document.getElementById('lightbox');
            const lightboxBackdrop = document.getElementById('lightbox-backdrop');
            const lightboxClose = document.getElementById('lightbox-close');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxCaption = document.getElementById('lightbox-caption');

            if (galleryGrid && lightbox) {
                // Tambah event listener ke setiap gambar di galeri
                galleryGrid.addEventListener('click', function (event) {
                    const photoDiv = event.target.closest('.gallery-photo');
                    if (photoDiv) {
                        // Ambil data dari atribut data-*
                        const fullSrc = photoDiv.dataset.fullSrc;
                        const caption = photoDiv.dataset.caption;

                        // Isi modal dengan data dan tampilkan
                        lightboxImg.src = fullSrc;
                        lightboxCaption.textContent = caption;
                        lightbox.classList.remove('hidden');
                    }
                });

                // Fungsi untuk menutup lightbox
                function closeLightbox() {
                    lightbox.classList.add('hidden');
                    lightboxImg.src = ''; // Kosongkan src untuk menghentikan loading
                }

                // Event listener untuk tombol close dan backdrop
                lightboxClose.addEventListener('click', closeLightbox);
                lightboxBackdrop.addEventListener('click', closeLightbox);

                // Event listener untuk tombol Escape
                window.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' && !lightbox.classList.contains('hidden')) {
                        closeLightbox();
                    }
                });
            }
        });
    </script>
@endpush