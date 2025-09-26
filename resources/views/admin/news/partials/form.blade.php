{{-- resources/views/admin/news/partials/form.blade.php --}}
<!-- @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif -->

<div>
    <label for="title" class="block text-sm font-medium text-gray-700">News Title</label>
    <input type="text" id="title" name="title" value="{{ old('title', $news->title ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
</div>
<div>
    <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
    <textarea id="excerpt" name="excerpt" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="source_name" class="block text-sm font-medium text-gray-700">Source Name</label>
        <input type="text" id="source_name" name="source_name" value="{{ old('source_name', $news->source_name ?? '') }}" placeholder="Example: Kompas.com" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="source_url" class="block text-sm font-medium text-gray-700">Source URL</label>
        <input type="url" id="source_url" name="source_url" value="{{ old('source_url', $news->source_url ?? '') }}" required placeholder="https://" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700">News Images</label>
        
        {{-- Elemen untuk pratinjau gambar --}}
        <div id="news-image-preview-container" class="mt-2 w-full h-32 flex items-center justify-center bg-gray-100 rounded-md overflow-hidden border border-dashed {{ isset($news) && $news->image_url ? '' : 'hidden' }}">
            <img id="news-image-preview" src="{{ isset($news) && $news->image_url ? asset('storage/' . $news->image_url) : '#' }}" alt="Image Preview" class="w-full h-full object-contain p-2">
        </div>
        
        <input id="news_image_url" name="image_url" type="file" accept="image/*" 
               class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
    </div>
    <div>
        <label for="published_at" class="block text-sm font-medium text-gray-700">Publication Date</label>
        <input type="date" id="published_at" name="published_at" value="{{ old('published_at', isset($news) ? $news->published_at->format('Y-m-d') : '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>
<div class="flex items-center gap-3">
    <input type="checkbox" id="is_published" name="is_published" class="h-4 w-4 rounded" @checked(old('is_published', $news->is_published ?? true))>
    <label for="is_published" class="text-sm font-medium">Publish</label>
</div>