{{-- Menampilkan semua error validasi di bagian atas --}}
@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

{{-- Judul Album --}}
<div>
    <label for="title" class="block text-sm font-medium text-gray-700">Judul Album</label>
    <input type="text" id="title" name="title" value="{{ old('title', $album->title ?? '') }}" required class="mt-1 block w-full ...">
</div>

{{-- Deskripsi Album --}}
<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
    <textarea id="description" name="description" rows="4"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">{{ old('description', $album->description ?? '') }}</textarea>
</div>

{{-- Gambar Sampul (Cover) --}}
<div>
    <label class="block text-sm font-medium text-gray-700">Gambar Sampul (Cover)</label>
    
    {{-- Elemen untuk pratinjau gambar --}}
    <div id="cover-preview-container" class="mt-2 w-48 h-32 flex items-center justify-center bg-gray-100 rounded-md overflow-hidden border border-dashed {{ isset($album) && $album->cover_url ? '' : 'hidden' }}">
        <img id="cover-preview" src="{{ isset($album) && $album->cover_url ? asset('storage/' . $album->cover_url) : '#' }}" alt="Image Preview" class="w-full h-full object-cover">
    </div>
    
    {{-- ID unik ditambahkan ke input file --}}
    <input id="cover_url_input" name="cover_url" type="file" accept="image/*" class="mt-2 block w-full text-sm ...">
</div>

{{-- Pengaturan Urutan dan Publikasi --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700">Urutan Tampil</label>
        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $album->sort_order ?? 0) }}" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
    </div>
    <div class="flex items-end">
        <div class="flex items-center gap-3">
            <input type="checkbox" id="is_published" name="is_published" class="h-4 w-4 rounded text-purple-600 focus:ring-purple-500"
                   @checked(old('is_published', $album->is_published ?? true))>
            <label for="is_published" class="text-sm font-medium text-gray-700">Publikasikan Album</label>
        </div>
    </div>
</div>