@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white" style="background-image: url('{{ asset('assets/images/contact-hero.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/50 to-black/40"></div>
        <h1 class="relative z-10 text-5xl md:text-6xl font-extrabold text-center px-4 tracking-tight">Get In Touch With Us</h1>
    </section>

    {{-- Contact Form Section --}}
    <section class="py-20">
        <div class="container mx-auto px-6">
            
            <div class="max-w-4xl mx-auto text-center mb-16">
                <h2 class="text-5xl font-bold text-purple-800 mb-3" style="font-family: serif;">Contact Us</h2>
                <div class="inline-block w-40 h-1 bg-purple-600"></div>
            </div>

            <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-12 items-start">
                
                {{-- Kolom Formulir --}}
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-8 bg-white rounded-l shadow-lg p-6 backdrop-blur-md">
                    @csrf 
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                            <p class="font-bold">Success</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="grid sm:grid-cols-2 gap-8">
                        <div>
                            <input type="text" name="name" placeholder="your name" value="{{ old('name') }}" required
                                   class="w-full bg-transparent px-2 py-2 border-b-2 @error('name') border-red-500 @else border-gray-300 @enderror focus:outline-none focus:border-purple-600 transition-colors text-lg">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <input type="email" name="email" placeholder="email address" value="{{ old('email') }}" required
                                   class="w-full bg-transparent px-2 py-2 border-b-2 @error('email') border-red-500 @else border-gray-300 @enderror focus:outline-none focus:border-purple-600 transition-colors text-lg">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <input type="text" name="subject" placeholder="subject" value="{{ old('subject') }}" required
                               class="w-full bg-transparent px-2 py-2 border-b-2 @error('subject') border-red-500 @else border-gray-300 @enderror focus:outline-none focus:border-purple-600 transition-colors text-lg">
                        @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <textarea name="message" placeholder="your message" rows="5" required
                                  class="w-full bg-transparent px-2 py-2 border-b-2 @error('message') border-red-500 @else border-gray-300 @enderror focus:outline-none focus:border-purple-600 transition-colors text-lg">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <button type="submit" class="bg-purple-700 text-white font-bold py-3 px-10 rounded-lg hover:bg-purple-800 transition-all duration-300 shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
                            Submit
                        </button>
                    </div>
                </form>

                {{-- Kolom Quick Contact --}}
                <div class="bg-white p-6 rounded-xl space-y-6 shadow-lg grid place-items-center gap-6">
                    <h3 class="text-3xl font-bold text-gray-800">Quick Contact</h3>
                    <div class="flex items-center space-x-4">
                        {{-- Ikon Telepon dari Iconify --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><path fill="currentColor" d="M28 6H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h24a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2m-2.2 2L16 14.78L6.2 8ZM4 24V8.91l11.43 7.91a1 1 0 0 0 1.14 0L28 8.91V24Z"/></svg>
                        <span class="text-gray-800 text-lg">+6281211603309</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        {{-- Ikon Email dari Iconify --}}
                        <span class="iconify w-7 h-7 text-gray-700" data-icon="solar:letter-bold"></span>
                        <span class="text-gray-800 text-lg">info@colorofindonesia.com</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection