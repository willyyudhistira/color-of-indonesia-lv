@extends('layouts.admin')
@section('title', 'Edit Album')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Album: {{ $album->title }}</h2>
        <form action="{{ route('admin.gallery.update', $album) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            @include('admin.gallery.partials.form', ['album' => $album])
            <div class="flex justify-end gap-4 pt-4 border-t mt-6">
                <a href="{{ route('admin.gallery.index') }}" class="py-2 px-6 bg-gray-200 rounded-lg">Cancel</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg">Update Album</button>
            </div>
        </form>
    </div>
@endsection