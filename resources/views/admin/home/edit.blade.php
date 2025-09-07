@extends('layouts.admin')

@section('title', 'Edit Carousel Item')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-700 mb-6">Edit Konten Hero Carousel</h3>
        
        <form action="{{ route('admin.home.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Ganti Gambar (Opsional)</label>
                
                {{-- Elemen Pratinjau Gambar --}}
                <div id="carousel-edit-preview-container" class="mt-2 w-48 h-32 flex items-center justify-center bg-gray-100 rounded-md overflow-hidden border border-dashed">
                    <img id="carousel-edit-preview" src="{{ asset('storage/' . $item->image_url) }}" alt="Image Preview" class="w-full h-full object-cover">
                </div>

                {{-- ID unik ditambahkan ke input file --}}
                <input type="file" id="image_url_edit" name="image_url" accept="image/*" class="mt-2 block w-full text-sm ...">
                @error('image_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="alt_text" class="block text-sm font-medium text-gray-700">Teks Alternatif (Alt Text)</label>
                <input type="text" id="alt_text" name="alt_text" value="{{ old('alt_text', $item->alt_text) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div>
                <label for="link_url" class="block text-sm font-medium text-gray-700">Link URL (Opsional)</label>
                <input type="url" id="link_url" name="link_url" value="{{ old('link_url', $item->link_url) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
            </div>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700">Urutan</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" min="1" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                </div>
                <div>
                    <label for="is_published" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="is_published" name="is_published" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                        <option value="1" {{ $item->is_published ? 'selected' : '' }}>Published</option>
                        <option value="0" {{ !$item->is_published ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="bg-purple-700 text-white font-bold py-2 px-6 rounded-lg hover:bg-purple-800 transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.home.index') }}" class="text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
@endsection