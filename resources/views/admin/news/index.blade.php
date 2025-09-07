@extends('layouts.admin')
@section('title', 'News Management')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Berita Eksternal</h2>
        <a href="{{ route('admin.news.create') }}" class="bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            Tambah Berita Baru
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($newsItems as $article)
                <div class="flex items-start gap-4 p-4 rounded-md border">
                    <img src="{{ $article->image_url ? asset('storage/' . $article->image_url) : 'https://via.placeholder.com/100' }}" alt="{{ $article->title }}" class="w-24 h-24 object-cover rounded-md flex-shrink-0 bg-gray-200">
                    <div class="flex-grow">
                        <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full mb-1 {{ $article->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $article->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <h4 class="font-bold text-gray-800">{{ $article->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $article->excerpt }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $article->source_name }} - {{ $article->published_at->format('d F Y') }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('admin.news.edit', $article) }}" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit"><span class="iconify" data-icon="solar:pen-bold"></span></a>
                        <form action="{{ route('admin.news.destroy', $article) }}" method="POST" onsubmit="return confirm('Anda yakin?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-red-500 text-white rounded-md w-full" title="Hapus"><span class="iconify" data-icon="solar:trash-bin-trash-bold"></span></button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Belum ada berita yang ditambahkan.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $newsItems->links() }}</div>
    </div>
@endsection