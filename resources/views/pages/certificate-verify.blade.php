@extends('layouts.app')

@section('title', 'Certificate Verification')

@section('content')
    <div class="py-20 bg-gray-50 min-h-[70vh] flex items-center">
        <div class="container mx-auto px-6 text-center">
            
            @if ($participant)
                {{-- TAMPILAN JIKA SERTIFIKAT VALID --}}
                <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border-t-4 border-green-500">
                    <div class="flex flex-col items-center">
                        <span class="iconify w-16 h-16 text-green-500" data-icon="solar:verified-check-bold"></span>
                        <h1 class="text-3xl font-bold text-gray-800 mt-4">Certificate Verified</h1>
                        <p class="text-gray-600 mt-2">This certificate is valid and registered in our system.</p>
                        
                        <div class="text-left w-full mt-8 pt-6 border-t space-y-3">
                            <p><strong>Certificate Number:</strong> {{ $participant->certificate_number }}</p>
                            <p><strong>Awarded To:</strong> {{ $participant->name }}</p>
                            <p><strong>Group/Institution:</strong> {{ $participant->group ?: '-' }}</p>
                            <p><strong>For Participation in:</strong> {{ $participant->event->title }}</p>
                        </div>
                    </div>
                </div>
            @else
                {{-- TAMPILAN JIKA SERTIFIKAT TIDAK VALID --}}
                <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border-t-4 border-red-500">
                    <div class="flex flex-col items-center">
                        <span class="iconify w-16 h-16 text-red-500" data-icon="solar:close-circle-bold"></span>
                        <h1 class="text-3xl font-bold text-gray-800 mt-4">Certificate Not Found</h1>
                        <p class="text-gray-600 mt-2">The certificate number you entered is invalid or not registered in our system.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection