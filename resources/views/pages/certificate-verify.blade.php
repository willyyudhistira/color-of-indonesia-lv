@extends('layouts.app')

@section('title', 'Verifikasi Sertifikat')

@section('content')
    <div class="py-20 bg-gray-50 min-h-[70vh] flex items-center">
        <div class="container mx-auto px-6 text-center">
            
            @if ($participant)
                {{-- TAMPILAN JIKA SERTIFIKAT VALID --}}
                <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border-t-4 border-green-500">
                    <div class="flex flex-col items-center">
                        <span class="iconify w-16 h-16 text-green-500" data-icon="solar:verified-check-bold"></span>
                        <h1 class="text-3xl font-bold text-gray-800 mt-4">Sertifikat Terverifikasi</h1>
                        <p class="text-gray-600 mt-2">Sertifikat ini sah dan terdaftar dalam sistem kami.</p>
                        
                        <div class="text-left w-full mt-8 pt-6 border-t space-y-3">
                            <p><strong>Nomor Sertifikat:</strong> {{ $participant->certificate_number }}</p>
                            <p><strong>Diberikan Kepada:</strong> {{ $participant->name }}</p>
                            <p><strong>Grup/Instansi:</strong> {{ $participant->group ?: '-' }}</p>
                            <p><strong>Untuk Partisipasi dalam:</strong> {{ $participant->event->title }}</p>
                        </div>
                    </div>
                </div>
            @else
                {{-- TAMPILAN JIKA SERTIFIKAT TIDAK VALID --}}
                <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border-t-4 border-red-500">
                    <div class="flex flex-col items-center">
                        <span class="iconify w-16 h-16 text-red-500" data-icon="solar:close-circle-bold"></span>
                        <h1 class="text-3xl font-bold text-gray-800 mt-4">Sertifikat Tidak Ditemukan</h1>
                        <p class="text-gray-600 mt-2">Nomor sertifikat yang Anda pindai tidak valid atau tidak terdaftar dalam sistem kami.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection