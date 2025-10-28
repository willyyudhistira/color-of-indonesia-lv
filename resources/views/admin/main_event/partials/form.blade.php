{{-- resources/views/admin/main_event/partials/form.blade.php --}}
@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Event Title</label>
        <input type="text" id="title" name="title" value="{{ old('title', $mainEvent->title ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $mainEvent->subtitle ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>
<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea id="description" name="description" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $mainEvent->description ?? '') }}</textarea>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="location_name" class="block text-sm font-medium text-gray-700">Location Name</label>
        <input type="text" id="location_name" name="location_name" value="{{ old('location_name', $mainEvent->location_name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="link_url" class="block text-sm font-medium text-gray-700">URL Link</label>
        <input type="url" id="link_url" name="link_url" value="{{ old('link_url', $mainEvent->link_url ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>
<div>
    <label class="block text-sm font-medium text-gray-700">Hero Image</label>
    <div id="hero-preview-container" class="mt-2 w-full h-48 hidden items-center justify-center bg-gray-100 rounded-lg overflow-hidden border border-dashed">
        <img id="hero-preview" src="#" alt="Image Preview" class="h-full object-contain p-2">
    </div>
    @if(isset($mainEvent) && $mainEvent->hero_image_url)
    <div class="mt-2"><img src="{{ asset('storage/' . $mainEvent->hero_image_url) }}" alt="Current Image" class="w-full h-48 object-cover rounded-md"></div>
    @endif
    <input id="hero_image_url" name="hero_image_url" type="file" accept="image/*" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
</div>