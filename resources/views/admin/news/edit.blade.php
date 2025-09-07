{{-- resources/views/admin/news/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Edit Berita')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Berita</h2>
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            @include('admin.news.partials.form', ['news' => $news])
            <div class="flex justify-end gap-4 pt-4 border-t">
                <a href="{{ route('admin.news.index') }}" class="py-2 px-6 bg-gray-200 rounded-lg">Batal</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg">Update Berita</button>
            </div>
        </form>
    </div>
@endsection