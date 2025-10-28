{{-- resources/views/admin/sponsors/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Edit Sponsor')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Sponsor (Logo)</h2>
        <form action="{{ route('admin.sponsors.update', $sponsor) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium">Sponsor Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $sponsor->name) }}" required class="w-full mt-1 border-gray-300 rounded-lg p-2 shadow-sm">
            </div>
            <div>
                <label for="website_url" class="block text-sm font-medium">Sponsor Link (URL)</label>
                <input type="url" name="website_url" id="website_url" value="{{ old('website_url', $sponsor->website_url) }}" class="w-full mt-1 p-2 border-gray-300 rounded-lg shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium">Sponsor Logo</label>
                {{-- KONTANIER PREVIEW UNTUK EDIT --}}
                <div id="edit-logo-preview-container" class="mt-2 w-32 h-32 flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden border border-dashed {{ $sponsor->logo_url ? '' : 'hidden' }}">
                    <img id="edit-logo-preview" src="{{ $sponsor->logo_url ? asset('storage/' . $sponsor->logo_url) : '#' }}" alt="Logo Preview" class="h-full object-contain p-2">
                </div>
                {{-- PASTIKAN ID UNIK --}}
                <input id="edit_logo_url_input" type="file" name="logo_url" accept="image/*" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                <p class="text-xs text-gray-500 mt-1">Upload a new image to replace the logo.</p>
            </div>
            
            <div class="flex justify-end gap-4 pt-4 border-t mt-6">
                <a href="{{ route('admin.sponsors.index') }}" class="py-2 px-6 bg-gray-200 rounded-lg">Cancel</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg">Update</button>
            </div>
        </form>
    </div>
@endsection