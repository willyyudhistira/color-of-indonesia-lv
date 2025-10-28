@extends('layouts.admin')
@section('title', 'Kelola Album: ' . $album->title)

@section('content')
    <div class="space-y-8">
        {{-- Note Box --}}
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 ...">
            <p class="font-bold">Gallery Photo Upload Guide</p>
            <ul class="list-disc list-inside text-sm mt-2">
                <li>Upload photos with a ratio of **1:1** (square) or **4:5** (portrait).</li>
                <li>Use high resolution photos (HD - 4K) for best results.</li>
            </ul>
        </div>

        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Total Foto --}}
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Photos</p>
                    <p class="text-3xl font-bold text-purple-500">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full"><span class="iconify text-purple-500 w-6 h-6" data-icon="solar:gallery-wide-bold"></span></div>
            </div>
            {{-- Statistik lainnya bisa ditambahkan di sini --}}
        </div>

        {{-- Bagian Upload --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-gray-700 mb-4">Upload New Photos to Album "{{ $album->title }}"</h3>
            <form action="{{ route('admin.gallery.photos.upload', $album) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid md:grid-cols-2 gap-6 items-center">
                    <div id="photo-preview-container" class="w-full h-48 border-2 border-dashed rounded-lg flex items-center justify-center bg-gray-50 hidden">
                        <img id="photo-preview" src="#" class="w-full h-full object-contain p-2">
                    </div>
                    <div class="space-y-4">
                        <input id="photo-upload-input" name="photo" type="file" accept="image/*" required class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                        <input name="caption" type="text" placeholder="Photo caption (optional)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <button type="submit" class="flex items-center gap-2 bg-purple-700 text-white font-bold py-2 px-6 rounded-lg hover:bg-purple-800">
                            <span class="iconify" data-icon="solar:upload-bold"></span>
                            <span>Upload Foto</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        {{-- Daftar Foto yang Sudah Ada --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-bold text-gray-700 mb-4">Daftar Foto</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @forelse($album->photos as $photo)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $photo->image_url) }}" class="w-full h-40 object-cover rounded-lg">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                            <form action="{{ route('admin.gallery.photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Hapus foto ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="delete-confirm-button p-2 bg-red-500 text-white rounded-full"><span class="iconify" data-icon="solar:trash-bin-trash-bold"></span></button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Belum ada foto di album ini.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection