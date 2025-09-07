@extends('layouts.admin')

@section('title', 'Tambah Album Baru')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Buat Album Galeri Baru</h2>
        
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            {{-- Memanggil form partial --}}
            @include('admin.gallery.partials.form')

            <div class="flex justify-end gap-4 pt-4 border-t mt-6">
                <a href="{{ route('admin.gallery.index') }}" class="py-2 px-6 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">Batal</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg hover:bg-purple-800 transition-colors">
                    Simpan Album
                </button>
            </div>
        </form>
    </div>
@endsection