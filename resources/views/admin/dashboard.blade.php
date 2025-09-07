@extends('layouts.admin')

{{-- Mengisi judul halaman (akan tampil di top-bar) --}}
@section('title', 'Home Page Management')

@section('content')
    {{-- Konten spesifik untuk halaman ini --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}!</h2>
        <p class="text-gray-600">
            Ini adalah halaman dashboard utama Anda. Silakan pilih menu di sebelah kiri untuk mulai mengelola konten website.
        </p>
    </div>

    {{-- Nanti di sini akan ada form-form untuk mengelola Carousel, Testimonial, dll. --}}
@endsection