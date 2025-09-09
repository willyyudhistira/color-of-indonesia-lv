{{-- resources/views/admin/testimonials/partials/form.blade.php --}}

<!-- @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif -->

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Kolom kiri untuk input teks --}}
    <div class="md:col-span-2 space-y-6">
        <div>
            <label for="author_name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="author_name" name="author_name" value="{{ old('author_name', $testimonial->author_name ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label for="role_title" class="block text-sm font-medium text-gray-700">Sebagai (Contoh: Peserta 2024)</label>
            <input type="text" id="role_title" name="role_title" value="{{ old('role_title', $testimonial->role_title ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label for="quote" class="block text-sm font-medium text-gray-700">Isi Testimoni</label>
            <textarea id="quote" name="quote" rows="5" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('quote', $testimonial->quote ?? '') }}</textarea>
        </div>
    </div>

    {{-- Kolom kanan untuk gambar dan pengaturan --}}
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Foto</label>
            
            {{-- Elemen untuk pratinjau gambar --}}
            <div id="image-preview-container" class="mt-2 w-32 h-32 flex items-center justify-center bg-gray-100 rounded-xl overflow-hidden {{ isset($testimonial) && $testimonial->avatar_url ? '' : 'hidden' }}">
                <img id="image-preview" src="{{ isset($testimonial) && $testimonial->avatar_url ? asset('storage/' . $testimonial->avatar_url) : '#' }}" alt="Image Preview" class="w-full h-full object-cover">
            </div>
            
            <input id="avatar_url" name="avatar_url" type="file" accept="image/*" 
                   {{-- Atribut 'required' hanya ditambahkan jika ini adalah form 'create' (bukan 'edit') --}}
                   {{ !isset($testimonial) ? 'required' : '' }}
                   class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
        </div>
        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700">Urutan</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div class="flex items-center gap-3">
            <input type="checkbox" id="is_published" name="is_published" class="h-4 w-4 rounded" @checked(old('is_published', $testimonial->is_published ?? true))>
            <label for="is_published">Publikasikan</label>
        </div>
    </div>
</div>