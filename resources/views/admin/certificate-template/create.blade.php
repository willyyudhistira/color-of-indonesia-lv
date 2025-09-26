@extends('layouts.admin')
@section('title', 'Buat Template Baru')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create a New Certificate Template</h2>
        <form action="{{ route('admin.certificate-templates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @include('admin.certificate-template.partials.form')
            <div class="flex justify-end gap-4 pt-6 border-t">
                <a href="{{ route('admin.certificate-templates.index') }}" class="py-2 px-6 bg-gray-200 rounded-lg">Cancel</a>
                <button type="submit" class="py-2 px-8 bg-purple-700 text-white font-bold rounded-lg">Save Template</button>
            </div>
        </form>
    </div>
@endsection 