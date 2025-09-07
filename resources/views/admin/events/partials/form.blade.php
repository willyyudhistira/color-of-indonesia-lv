{{-- resources/views/admin/events/partials/form.blade.php --}}
@if ($errors->any())
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Judul Event</label>
        <input type="text" id="title" name="title" value="{{ old('title', $event->title ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug (URL)</label>
        <input type="text" id="slug" name="slug" value="{{ old('slug', $event->slug ?? '') }}" {{ isset($event) ? '' : 'disabled' }} placeholder="Dibuat otomatis saat menyimpan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100">
    </div>
</div>
<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
    <textarea id="description" name="description" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $event->description ?? '') }}</textarea>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', isset($event) ? $event->start_date->format('Y-m-d') : '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai (Opsional)</label>
        <input type="date" id="end_date" name="end_date" value="{{ old('end_date', isset($event) && $event->end_date ? $event->end_date->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="location_name" class="block text-sm font-medium text-gray-700">Nama Lokasi</label>
        <input type="text" id="location_name" name="location_name" value="{{ old('location_name', $event->location_name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
        <input type="text" id="address" name="address" value="{{ old('address', $event->address ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>
<div>
    <label for="form_url" class="block text-sm font-medium text-gray-700">URL Form Pendaftaran</label>
    <input type="url" id="form_url" name="form_url" value="{{ old('form_url', $event->form_url ?? '') }}" required placeholder="https://" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
</div>
<div>
    <label class="block text-sm font-medium text-gray-700">Gambar Hero</label>
    
    {{-- Elemen untuk pratinjau gambar --}}
    <div id="hero-preview-container" class="mt-2 w-full h-48 flex items-center justify-center bg-gray-100 rounded-md overflow-hidden border border-dashed {{ isset($event) && $event->hero_image_url ? '' : 'hidden' }}">
        <img id="hero-preview" src="{{ isset($event) && $event->hero_image_url ? asset('storage/' . $event->hero_image_url) : '#' }}" alt="Image Preview" class="w-full h-full object-contain p-2">
    </div>
    
    {{-- Input file tetap sama, ID-nya 'hero_image_url' --}}
    <input id="hero_image_url" name="hero_image_url" type="file" accept="image/*" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
</div>
<div class="flex gap-10 pt-2">
    <div class="flex items-center gap-3">
        <input type="checkbox" id="is_published" name="is_published" class="h-4 w-4 rounded" @checked(old('is_published', $event->is_published ?? true))>
        <label for="is_published">Publikasikan</label>
    </div>
    <div class="flex items-center gap-3">
        <input type="checkbox" id="is_featured" name="is_featured" class="h-4 w-4 rounded" @checked(old('is_featured', $event->is_featured ?? false))>
        <label for="is_featured">Jadikan Featured</label>
    </div>
</div>