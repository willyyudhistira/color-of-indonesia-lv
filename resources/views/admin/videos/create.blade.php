@extends('layouts.admin')

@section('title', 'Tambah Video Baru')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Video Baru</h2>
        
        <form action="{{ route('admin.videos.store') }}" method="POST" class="space-y-6">
            @csrf
            
            {{-- Memanggil form partial --}}
            @include('admin.videos.partials.form')

            <div class="flex justify-end gap-4 pt-4 border-t mt-6">
                <a href="{{ route('admin.videos.index') }}" class="py-2 px-6 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">Batal</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg hover:bg-purple-800 transition-colors">
                    Simpan Video
                </button>
            </div>
        </form>
    </div>
@endsection
