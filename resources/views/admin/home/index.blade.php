@extends('layouts.admin')

@section('title', 'Home Page Management')

@section('content')
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">Error!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Info Box --}}
    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg mb-8 flex items-start gap-4">
        <span class="iconify w-6 h-6 text-blue-500 mt-1 flex-shrink-0" data-icon="solar:info-circle-bold"></span>
        <div>
            <p class="font-bold">Informasi Penting</p>
            <ul class="list-disc list-inside text-sm mt-2">
                <li>Upload Foto dengan dimensi ideal **1200x800 pixel**.</li>
                <li>Konten carousel maksimal berjumlah **{{ $maxItems }} buah**.</li>
            </ul>
        </div>
    </div>

    {{-- Daftar Konten --}}
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-xl font-bold text-gray-700 mb-4">Daftar Konten Hero Carousel</h3>
        <div class="space-y-4">
            @forelse ($carouselItems as $item)
                <div
                    class="grid grid-cols-1 md:grid-cols-5 items-center gap-4 p-3 rounded-md {{ $loop->even ? 'bg-gray-50' : '' }}">
                    <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->alt_text }}"
                        class="w-28 h-16 object-cover rounded-md bg-gray-200">
                    <span
                        class="font-semibold text-gray-600 col-span-2">{{ $item->alt_text ?: "Carousel Item #{$item->id}" }}</span>
                    <span>
                        <span
                            class="px-3 py-1 text-xs font-bold rounded-full {{ $item->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                            {{ $item->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </span>
                    <div class="flex items-center justify-end gap-2">
                        <span class="text-sm text-gray-500">Urutan: {{ $item->sort_order }}</span>
                        <a href="{{ route('admin.home.edit', $item->id) }}"
                            class="p-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors" title="Edit">
                            <span class="iconify" data-icon="solar:pen-bold"></span>
                        </a>
                        <form action="{{ route('admin.home.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Anda yakin ingin menghapus item ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors" title="Hapus">
                                <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Belum ada konten carousel.</p>
            @endforelse
        </div>
    </div>

    {{-- Bagian Upload --}}
    @if($carouselItems->count() < $maxItems)
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-gray-700 mb-4">Upload Foto Baru</h3>
            <form action="{{ route('admin.home.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Elemen Pratinjau Gambar --}}
                <div id="carousel-upload-preview-container"
                    class="w-full h-48 hidden items-center justify-center bg-gray-100 rounded-lg overflow-hidden border border-dashed">
                    <img id="carousel-upload-preview" src="#" alt="Image Preview" class="w-full h-full object-contain p-2">
                </div>

                <div>
                    <label for="image_url_upload" class="block text-sm font-medium text-gray-700 mb-1">File Gambar</label>
                    {{-- ID unik ditambahkan ke input file --}}
                    <input type="file" id="image_url_upload" name="image_url" accept="image/*" required
                        class="block w-full ...">
                    @error('image_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="alt_text" class="block text-sm font-medium text-gray-700">Teks Alternatif (Alt Text)</label>
                    <input type="text" id="alt_text" name="alt_text"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Deskripsi singkat gambar">
                </div>
                <div>
                    <label for="link_url" class="block text-sm font-medium text-gray-700">Link URL (Opsional)</label>
                    <input type="url" id="link_url" name="link_url"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="https://example.com">
                </div>
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-purple-700 text-white font-bold ...">
                    <span class="iconify" data-icon="solar:upload-bold"></span>
                    <span>Upload Konten</span>
                </button>
            </form>
        </div>
    @endif
@endsection