{{-- resources/views/admin/main_event/partials/form.blade.php --}}
@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Judul Event</label>
        <input type="text" id="title" name="title" value="{{ old('title', $mainEvent->title ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $mainEvent->subtitle ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>
<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Lengkap</label>
    <textarea id="description" name="description" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $mainEvent->description ?? '') }}</textarea>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="location_name" class="block text-sm font-medium text-gray-700">Nama Lokasi</label>
        <input type="text" id="location_name" name="location_name" value="{{ old('location_name', $mainEvent->location_name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
        <input type="text" id="address" name="address" value="{{ old('address', $mainEvent->address ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>
<div>
    <label class="block text-sm font-medium text-gray-700">Gambar Hero</label>
    
    {{-- Elemen untuk pratinjau gambar --}}
    <div id="hero-preview-container" class="mt-2 w-full h-48 flex items-center justify-center bg-gray-100 rounded-md overflow-hidden border border-dashed {{ isset($mainEvent) && $mainEvent->hero_image_url ? '' : 'hidden' }}">
        <img id="hero-preview" src="{{ isset($mainEvent) && $mainEvent->hero_image_url ? asset('storage/' . $mainEvent->hero_image_url) : '#' }}" alt="Image Preview" class="w-full h-full object-contain p-2">
    </div>
    
    {{-- Input file dengan ID yang sudah ada --}}
    <input id="hero_image_url" name="hero_image_url" type="file" accept="image/*" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
</div>