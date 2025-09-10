@extends('layouts.admin')
@section('title', 'Video Gallery Management')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Video Galeri</h2>
        <a href="{{ route('admin.videos.create') }}" class="mt-4 sm:mt-0 bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            <span>Tambah Video Baru</span>
        </a>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($videos as $video)
                <div class="flex flex-col sm:flex-row items-start gap-4 p-4 rounded-md border">
                    {{-- Video Preview --}}
                    <div class="w-full sm:w-40 flex-shrink-0">
                        <div class="aspect-video bg-black rounded-md overflow-hidden">
                            {!! $video->embed_code !!}
                        </div>
                    </div>
                    
                    <div class="flex-grow">
                        <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full mb-1 {{ $video->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $video->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <h4 class="font-bold text-gray-800 break-words">{{ $video->title }}</h4>
                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $video->description }}</p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto mt-3 sm:mt-0 border-t sm:border-none pt-3 sm:pt-0">
                        <div class="flex items-center gap-2 ml-auto">
                            <a href="{{ route('admin.videos.edit', $video) }}" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit">
                                <span class="iconify" data-icon="solar:pen-bold"></span>
                            </a>
                            <form action="{{ route('admin.videos.destroy', $video) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" class="delete-confirm-button p-2 bg-red-500 text-white rounded-md" title="Hapus">
                                    <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <p>Belum ada video yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection