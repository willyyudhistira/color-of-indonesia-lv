{{-- resources/views/admin/programs/partials/form.blade.php --}}
<!-- @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif -->

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Program Title</label>
        <input type="text" id="title" name="title" value="{{ old('title', $program->title ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle (Opsional)</label>
        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $program->subtitle ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>
<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea id="description" name="description" rows="4" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $program->description ?? '') }}</textarea>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
    <div>
        <label class="block text-sm font-medium text-gray-700">Program Icon</label>
        
        {{-- Elemen untuk pratinjau gambar --}}
        <div id="icon-preview-container" class="mt-2 w-24 h-24 flex items-center justify-center bg-gray-100 rounded-md overflow-hidden border border-dashed {{ isset($program) && $program->icon_url ? '' : 'hidden' }}">
            <img id="icon-preview" src="{{ isset($program) && $program->icon_url ? asset('storage/' . $program->icon_url) : '#' }}" alt="Icon Preview" class="w-full h-full object-contain p-2">
        </div>
        
        <input id="icon_url" name="icon_url" type="file" accept="image/*,.svg" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
    </div>
    <div class="space-y-4">
        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700">Order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $program->sort_order ?? 0) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div class="flex items-center gap-3">
            <input type="checkbox" id="is_published" name="is_published" class="h-4 w-4 rounded text-purple-600 focus:ring-purple-500" @checked(old('is_published', $program->is_published ?? true))>
            <label for="is_published" class="text-sm font-medium">Publish</label>
        </div>
    </div>
</div>