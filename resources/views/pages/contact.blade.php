@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

    {{-- 1. Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/contact-hero.png') }}" class="w-full h-full object-cover" alt="Contact Hero Image">
            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        </div>
        <div class="relative z-10 text-center px-4">
            {{-- Ukuran font dibuat responsif --}}
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold font-serif">Tetap Terhubung</h1>
        </div>
    </section>

    {{-- 2. Contact Form Section --}}
    <section class="py-20">
        {{-- Container utama dengan padding responsif --}}
        <div class="container mx-auto px-6 md:px-20">
            
            {{-- Judul dan Garis Dekoratif --}}
            <div class="text-left mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-purple-800 mb-4">Hubungi Kami</h2>
                <div class="flex items-center my-6">
                    <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                    <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
                    <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                </div>
            </div>

            {{-- Grid utama: 1 kolom di mobile, 2 kolom di desktop --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                
                {{-- Kolom Formulir --}}
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6 bg-white rounded-xl shadow-2xl p-6 md:p-10">
                    @csrf 
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Anda</label>
                            <input type="text" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required
                                   class="w-full bg-gray-100 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="anda@email.com" value="{{ old('email') }}" required
                                   class="w-full bg-gray-100 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1">Subjek</label>
                        <input type="text" id="subject" name="subject" placeholder="Tujuan pesan Anda" value="{{ old('subject') }}" required
                               class="w-full bg-gray-100 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-1">Pesan</label>
                        <textarea id="message" name="message" placeholder="Tuliskan pesan Anda di sini..." rows="5" required
                                  class="w-full bg-gray-100 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition resize-none">{{ old('message') }}</textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-10 rounded-lg hover:opacity-90 transition-opacity shadow-lg">
                            Kirim Pesan
                        </button>
                    </div>
                </form>

                {{-- Kolom Quick Contact --}}
                <div class="relative bg-purple-100/50 text-gray-800 p-8 rounded-xl shadow-xl">
                    <h2 class="text-3xl md:text-4xl font-bold font-serif text-center mb-10">Quick Contact</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-10">
                        {{-- 1. Call Us --}}
                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full flex-shrink-0"><span class="iconify w-6 h-6 text-purple-700" data-icon="solar:phone-bold-duotone"></span></div>
                            <div>
                                <h4 class="text-xl font-bold mb-1">Call Us</h4>
                                <p class="text-sm">+6281211603309 (Head Office)</p>
                            </div>
                        </div>
                        {{-- 2. Email Us --}}
                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full flex-shrink-0"><span class="iconify w-6 h-6 text-purple-700" data-icon="solar:letter-bold-duotone"></span></div>
                            <div>
                                <h4 class="text-xl font-bold mb-1">Email Us</h4>
                                <p class="text-sm">info@colorofindonesia.com</p>
                            </div>
                        </div>
                        {{-- 3. Visit Us --}}
                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full flex-shrink-0"><span class="iconify w-6 h-6 text-purple-700" data-icon="solar:map-point-bold-duotone"></span></div>
                            <div>
                                <h4 class="text-xl font-bold mb-1">Visit Us</h4>
                                <p class="text-sm">Graha Fadillah, Jl. Raya BSD Bintaro 5, Pondok Aren, Tangerang Selatan</p>
                            </div>
                        </div>
                        {{-- 4. Follow Us --}}
                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full flex-shrink-0"><span class="iconify w-6 h-6 text-purple-700" data-icon="solar:users-group-rounded-bold-duotone"></span></div>
                            <div>
                                <h4 class="text-xl font-bold mb-1">Follow Us</h4>
                                <div class="flex space-x-3 text-gray-600">
                                    <a href="#" title="Instagram"><span class="iconify w-6 h-6 hover:text-purple-700"></span></a>
                                    <a href="#" title="Facebook"><span class="iconify w-6 h-6 hover:text-purple-700"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection