@extends('layouts.admin')

@section('title', 'Edit Video')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Video: {{ $video->title }}</h2>
        
        <form action="{{ route('admin.videos.update', $video) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            {{-- Memanggil form partial yang sama, tetapi mengirimkan data $video --}}
            @include('admin.videos.partials.form', ['video' => $video])

            <div class="flex justify-end gap-4 pt-4 border-t mt-6">
                <a href="{{ route('admin.videos.index') }}" class="py-2 px-6 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">Cancel</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg hover:bg-purple-800 transition-colors">
                    Update Video
                </button>
            </div>
        </form>
    </div>
@endsection
