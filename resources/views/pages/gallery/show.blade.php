@extends('layouts.app')
@section('title', 'Album: ' . $album->title)

@section('content')
    <section class="relative h-96 flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0">
            <img src="{{ $album->cover_url ? asset('storage/' . $album->cover_url) : 'https://via.placeholder.com/1200x400' }}" class="w-full h-full object-cover" alt="{{ $album->title }}">
            <div class="absolute inset-0 bg-black/70"></div>
        </div>
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 text-center px-4">
            <p class="text-lg font-extrabold">Gallery Album</p>
            <h1 class="text-4xl md:text-6xl font-serif font-extrabold tracking-tight mt-2">{{ $album->title }}</h1>
        </div>
    </section>

    <div class="py-20 bg-gray-50">
        <div class="container mx-auto px-6 md:px-20">
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 mb-8">
                <span class="iconify w-5 h-5" data-icon="solar:arrow-left-bold"></span>
                Kembali ke Daftar Album
            </a>
            
            @if($album->description)
            <div class="max-w-3xl mx-auto text-center mb-12">
                <p class="text-lg text-gray-600">{{ $album->description }}</p>
            </div>
            @endif

            {{-- Grid Foto dengan atribut data-* untuk Plain JS --}}
            <div id="gallery-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse ($photos as $photo)
                    <div class="group cursor-pointer aspect-square rounded-lg overflow-hidden gallery-photo"
                         data-full-src="{{ asset('storage/' . $photo->image_url) }}"
                         data-caption="{{ $photo->caption ?: 'Tidak ada keterangan.' }}">
                        <img src="{{ asset('storage/' . $photo->image_url) }}" alt="{{ $photo->caption }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 text-lg py-16">Tidak ada foto di album ini.</p>
                @endforelse
            </div>

            <div class="mt-16">{{ $photos->links() }}</div>
        </div>

        {{-- Modal Lightbox (menggunakan ID untuk Plain JS) --}}
        <div id="lightbox" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div id="lightbox-backdrop" class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>
            <div class="relative w-full max-w-4xl max-h-[90vh] bg-gray-900 rounded-lg shadow-xl flex flex-col md:flex-row">
                <button id="lightbox-close" class="absolute -top-4 -right-4 md:top-2 md:right-2 z-10 bg-white/20 text-white rounded-full p-1 hover:bg-white/40">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <div class="w-full md:w-2/3 bg-black flex items-center justify-center">
                    <img id="lightbox-img" src="" alt="Focused view" class="max-w-full max-h-[60vh] md:max-h-[90vh] object-contain">
                </div>
                <div class="w-full md:w-1/3 p-6 flex flex-col text-white">
                    <h3 class="font-bold text-lg mb-4 border-b border-gray-700 pb-2">Detail Foto</h3>
                    <p id="lightbox-caption" class="text-gray-300 text-sm flex-grow"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- Script Anda ditempatkan di sini --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- LOGIKA UNTUK LIGHTBOX (ZOOM GAMBAR) ---
        const galleryGrid = document.getElementById('gallery-grid');
        const lightbox = document.getElementById('lightbox');
        const lightboxBackdrop = document.getElementById('lightbox-backdrop');
        const lightboxClose = document.getElementById('lightbox-close');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxCaption = document.getElementById('lightbox-caption');

        if (galleryGrid && lightbox) {
            galleryGrid.addEventListener('click', function (event) {
                const photoDiv = event.target.closest('.gallery-photo');
                if (photoDiv) {
                    const fullSrc = photoDiv.dataset.fullSrc;
                    const caption = photoDiv.dataset.caption;
                    
                    lightboxImg.src = fullSrc;
                    lightboxCaption.textContent = caption;
                    lightbox.classList.remove('hidden');
                }
            });

            function closeLightbox() {
                lightbox.classList.add('hidden');
                lightboxImg.src = '';
            }

            lightboxClose.addEventListener('click', closeLightbox);
            lightboxBackdrop.addEventListener('click', closeLightbox);
            window.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !lightbox.classList.contains('hidden')) {
                    closeLightbox();
                }
            });
        }
    });
</script>
@endpush