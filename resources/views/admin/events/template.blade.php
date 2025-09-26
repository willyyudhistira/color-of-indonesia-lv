@extends('layouts.admin')
@section('title', 'Edit Template Sertifikat: ' . $event->title)

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        <div class="mb-6 pb-4 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Pengaturan Template Sertifikat</h2>
            <p class="text-gray-500">Sesuaikan tampilan sertifikat untuk event: <strong class="text-purple-700">{{ $event->title }}</strong></p>
        </div>
        
        <form action="{{ route('admin.events.template.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            {{-- Background Image --}}
            <div>
                <label class="block text-lg font-medium text-gray-700">Gambar Latar Sertifikat</label>
                @if($event->certificate_background) 
                    <img src="{{ asset('storage/' . $event->certificate_background) }}" class="w-full h-auto object-contain rounded-md mt-2 border p-2"> 
                @endif
                <input type="file" name="certificate_background" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                <p class="text-xs text-gray-500 mt-1">Rekomendasi ukuran: A4 Landscape (sekitar 1123x794 pixel).</p>
            </div>

            {{-- Logos --}}
            <div>
                <label class="block text-lg font-medium text-gray-700">Logo Header</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
                    @for ($i = 1; $i <= 7; $i++)
                    <div>
                        <label class="block text-xs font-medium text-gray-500">Logo {{ $i }}</label>
                        @if($event->{'certificate_logo'.$i}) 
                            <img src="{{ asset('storage/' . $event->{'certificate_logo'.$i}) }}" class="h-12 object-contain my-1 border p-1 rounded"> 
                        @endif
                        <input type="file" name="certificate_logo{{$i}}" class="block w-full text-xs text-gray-500 file:mr-4 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs">
                    </div>
                    @endfor
                </div>
            </div>

            {{-- Signatures --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t">
                {{-- Signature 1 --}}
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-800">Tanda Tangan 1 (Kiri)</h3>
                    <div>
                        <label class="block text-sm">Nama</label>
                        <input type="text" name="certificate_signature1_name" value="{{ old('certificate_signature1_name', $event->certificate_signature1_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm">Jabatan</label>
                        <input type="text" name="certificate_signature1_title" value="{{ old('certificate_signature1_title', $event->certificate_signature1_title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm">Gambar Tanda Tangan</label>
                        @if($event->certificate_signature1_image) 
                            <img src="{{ asset('storage/' . $event->certificate_signature1_image) }}" class="h-16 object-contain my-1 border p-1 rounded"> 
                        @endif
                        <input type="file" name="certificate_signature1_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-1 file:px-2 file:rounded-full file:border-0">
                    </div>
                </div>
                {{-- Signature 2 --}}
                <div class="space-y-4">
                    <h3 class="font-semibold text-gray-800">Tanda Tangan 2 (Kanan)</h3>
                    <div>
                        <label class="block text-sm">Nama</label>
                        <input type="text" name="certificate_signature2_name" value="{{ old('certificate_signature2_name', $event->certificate_signature2_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                     <div>
                        <label class="block text-sm">Jabatan</label>
                        <input type="text" name="certificate_signature2_title" value="{{ old('certificate_signature2_title', $event->certificate_signature2_title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm">Gambar Tanda Tangan</label>
                        @if($event->certificate_signature2_image) 
                            <img src="{{ asset('storage/' . $event->certificate_signature2_image) }}" class="h-16 object-contain my-1 border p-1 rounded"> 
                        @endif
                        <input type="file" name="certificate_signature2_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-1 file:px-2 file:rounded-full file:border-0">
                    </div>
                </div>
            </div>
             <div>
                <label class="block text-lg font-medium text-gray-700">Logo Tengah (di antara tanda tangan)</label>
                @if($event->certificate_center_logo) 
                    <img src="{{ asset('storage/' . $event->certificate_center_logo) }}" class="h-16 object-contain my-1 border p-1 rounded"> 
                @endif
                <input type="file" name="certificate_center_logo" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0">
            </div>

            <div class="flex justify-end pt-6 border-t gap-4">
                <a href="{{ route('admin.events.index') }}" class="py-2 px-6 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Kembali</a>
                <button type="submit" class="py-2 px-8 bg-purple-700 text-white font-bold rounded-lg hover:bg-purple-800">
                    Simpan & Lihat Pratinjau
                </button>
            </div>
        </form>
    </div>
@endsection