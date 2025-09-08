@extends('layouts.admin')
@section('title', 'Tambah Album Baru')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Buat Album Galeri Baru</h2>
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('admin.gallery.partials.form')
            <div class="flex justify-end gap-4 pt-4 border-t mt-6">
                <a href="{{ route('admin.gallery.index') }}" class="py-2 px-6 bg-gray-200 rounded-lg">Batal</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg">Simpan Album</button>
            </div>
        </form>
    </div>
@endsection