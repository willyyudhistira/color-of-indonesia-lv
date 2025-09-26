@extends('layouts.admin')
@section('title', 'News Management')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">External News List</h2>
        <a href="{{ route('admin.news.create') }}" class="mt-4 sm:mt-0 bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            <span>Add New News</span>
        </a>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($newsItems as $article)
                <div class="flex flex-col sm:flex-row items-start gap-4 p-4 rounded-md border">
                    <img src="{{ $article->image_url ? asset('storage/' . $article->image_url) : 'https://via.placeholder.com/100' }}" alt="{{ $article->title }}" class="w-full sm:w-24 h-48 sm:h-24 object-cover rounded-md flex-shrink-0 bg-gray-200">
                    
                    <div class="flex-grow">
                        <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full mb-1 {{ $article->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $article->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <h4 class="font-bold text-gray-800">{{ $article->title }}</h4>
                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $article->excerpt }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $article->source_name }} - {{ $article->published_at->format('d F Y') }}</p>
                    </div>

                    {{-- Tombol Aksi, dibuat responsif --}}
                    <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto mt-3 sm:mt-0 border-t sm:border-none pt-3 sm:pt-0">
                        <div class="flex items-center gap-2 ml-auto">
                            <a href="{{ route('admin.news.edit', $article) }}" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit">
                                <span class="iconify" data-icon="solar:pen-bold"></span>
                            </a>
                            {{-- Menggunakan SweetAlert2 untuk konfirmasi hapus --}}
                            <form action="{{ route('admin.news.destroy', $article) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" class="delete-confirm-button p-2 bg-red-500 text-white rounded-md" title="Delete">
                                    <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <p>No news has been added yet.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $newsItems->links() }}
        </div>
    </div>
@endsection