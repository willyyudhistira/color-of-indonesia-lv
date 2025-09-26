@extends('layouts.app')
@section('title', 'E-Certificate Verification')

@section('content')
    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/contact-hero.png') }}" class="w-full h-full object-cover" alt="Hero Image">
            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        </div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-6xl font-extrabold font-serif">E-Certificate Verification</h1>
            <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto">Enter your unique number to download your participation certificate.</p>
        </div>
    </section>

    {{-- Verification Form Section --}}
    <section class="py-20">
        <div class="container mx-auto px-6 text-center">
            @if(session('error'))
                <div class="max-w-md mx-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('e-certificate.generate') }}" method="POST" class="max-w-md mx-auto">
                @csrf
                <label for="certificate_number" class="block text-lg font-semibold text-gray-700 mb-2">Enter Your Certificate Number</label>
                <input type="text" id="certificate_number" name="certificate_number" placeholder="Contoh: COI-1-ABCDE123" required
                       class="w-full px-4 py-3 text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                <button type="submit" class="mt-4 w-full bg-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-purple-700 transition-colors">
                    Search & Download Certificate
                </button>
            </form>
        </div>
    </section>
@endsection