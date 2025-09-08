@extends('layouts.admin')
@section('title', 'Gallery Management')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Album Galeri</h2>
        <a href="{{ route('admin.gallery.create') }}" class="bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            Tambah Album Baru
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($albums as $album)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ $album->cover_url ? asset('storage/' . $album->cover_url) : 'https://via.placeholder.com/400x300' }}" alt="{{ $album->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-bold">{{ $album->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $album->photos_count }} foto</p>
                    <div class="mt-4 flex justify-end gap-2">
                        <a href="{{ route('admin.gallery.show', $album) }}" class="text-sm bg-blue-500 text-white py-2 px-4 rounded-lg">Kelola Foto</a>
                        <a href="{{ route('admin.gallery.edit', $album) }}" class="text-sm bg-yellow-500 text-white py-2 px-4 rounded-lg">Edit</a>
                        <form action="{{ route('admin.gallery.destroy', $album) }}" method="POST" onsubmit="return confirm('Hapus album ini akan menghapus SEMUA fotonya. Anda yakin?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-sm bg-red-500 text-white py-2 px-4 rounded-lg">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">Belum ada album. Silakan buat album baru.</p>
        @endforelse
    </div>
@endsection