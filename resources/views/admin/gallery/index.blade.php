@extends('layouts.admin')
@section('title', 'Gallery Management')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Album Galeri</h2>
        <a href="{{ route('admin.gallery.create') }}" class="bg-purple-700 text-white font-bold py-2 px-4 rounded-lg ...">
            Tambah Album Baru
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($albums as $album)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('storage/' . $album->cover_url) }}" alt="{{ $album->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-bold">{{ $album->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $album->photos_count }} foto</p>
                    <div class="mt-4 flex justify-end gap-2">
                        <a href="{{ route('admin.gallery.show', $album) }}" class="text-sm bg-blue-500 text-white py-2 px-4 rounded-lg">Kelola Foto</a>
                        <a href="{{ route('admin.gallery.edit', $album) }}" class="text-sm bg-yellow-500 text-white py-2 px-4 rounded-lg">Edit</a>
                    </div>
                </div>
            </div>
        @empty
            <p>Belum ada album.</p>
        @endforelse
    </div>
@endsection