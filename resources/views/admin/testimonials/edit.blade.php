{{-- resources/views/admin/testimonials/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Edit Testimoni')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Testimoni</h2>
        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            @include('admin.testimonials.partials.form', ['testimonial' => $testimonial])
            <div class="flex justify-end gap-4 pt-4 border-t mt-6">
                <a href="{{ route('admin.testimonials.index') }}" class="py-2 px-6 bg-gray-200 rounded-lg">Batal</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg">Update</button>
            </div>
        </form>
    </div>
@endsection