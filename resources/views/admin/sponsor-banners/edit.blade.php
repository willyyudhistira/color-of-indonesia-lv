{{-- resources/views/admin/sponsor-banners/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Edit Banner Sponsor')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Sponsor (Banner)</h2>
        <form action="{{ route('admin.sponsor-banners.update', $sponsorBanner) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium">Banner Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $sponsorBanner->name) }}" required class="w-full mt-1 border-gray-300 rounded-lg p-2 shadow-sm">
            </div>
            <div>
                <label for="link_url" class="block text-sm font-medium">Banner Link (URL)</label>
                <input type="url" name="link_url" id="link_url" value="{{ old('link_url', $sponsorBanner->link_url) }}" class="w-full mt-1 p-2 border-gray-300 rounded-lg shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium">Banner Image</label>
                {{-- KONTANIER PREVIEW UNTUK EDIT --}}
                <div id="edit-banner-preview-container" class="mt-2 w-full h-32 flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden border border-dashed {{ $sponsorBanner->image_url ? '' : 'hidden' }}">
                    <img id="edit-banner-preview" src="{{ $sponsorBanner->image_url ? asset('storage/' . $sponsorBanner->image_url) : '#' }}" alt="Banner Preview" class="h-full object-contain p-2">
                </div>
                {{-- PASTIKAN ID UNIK --}}
                <input id="edit_banner_image_input" type="file" name="image_url" accept="image/*" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0">
                <p class="text-xs text-gray-500 mt-1">Upload a new image to replace the banner.</p>
            </div>
            
            <div class="flex justify-end gap-4 pt-4 border-t mt-6">
                <a href="{{ route('admin.sponsors.index') }}" class="py-2 px-6 bg-gray-200 rounded-lg">Cancel</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg">Update</button>
            </div>
        </form>
    </div>
@endsection