@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p class="font-bold">Oops! Ada beberapa kesalahan:</p>
        <ul class="list-disc list-inside mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <label for="title" class="block text-sm font-medium text-gray-700">Judul Video</label>
    <input type="text" id="title" name="title" value="{{ old('title', $video->title ?? '') }}" required
           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
</div>

<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
    <textarea id="description" name="description" rows="3"
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">{{ old('description', $video->description ?? '') }}</textarea>
</div>

<div>
    <label for="embed_code" class="block text-sm font-medium text-gray-700">Kode Semat (Embed Code) YouTube</label>
    <textarea id="embed_code" name="embed_code" rows="5" required
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm font-mono text-sm" 
              placeholder='Contoh: <iframe width="560" height="315" src="..." ...></iframe>'>{{ old('embed_code', $video->embed_code ?? '') }}</textarea>
    <p class="text-xs text-gray-500 mt-1">Salin kode semat langsung dari halaman video YouTube.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700">Urutan Tampil</label>
        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $video->sort_order ?? 0) }}" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
    </div>
    <div class="flex items-end">
        <div class="flex items-center gap-3">
            <input type="checkbox" id="is_published" name="is_published" class="h-4 w-4 rounded text-purple-600 focus:ring-purple-500"
                   @checked(old('is_published', $video->is_published ?? true))>
            <label for="is_published" class="text-sm font-medium text-gray-700">Publikasikan Video</label>
        </div>
    </div>
</div>
