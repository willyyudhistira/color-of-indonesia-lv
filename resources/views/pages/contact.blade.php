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
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items">
                
                {{-- Kolom Formulir --}}
                <form action="{{ route('contact.store') }}" method="POST" class="flex flex-col space-y-6 bg-white rounded-xl shadow-2xl p-8 h-full">
                    @csrf 
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Anda</label>
                            <input type="text" id="name" name="name" placeholder="Masukkan Nama Lengkap Anda" value="{{ old('name') }}" required
                                   class="w-full bg-gray-100 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="anda@email.com" value="{{ old('email') }}" required
                                   class="w-full bg-gray-100 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1">Subjek</label>
                        <input type="text" id="subject" name="subject" placeholder="Tujuan pesan Anda" value="{{ old('subject') }}" required
                               class="w-full bg-gray-100 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="flex-grow">
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-1">Pesan</label>
                        <textarea id="message" name="message" placeholder="Tuliskan pesan Anda di sini..." rows="5" required
                                  class="w-full h-full bg-gray-100 px-4 py-3 mb-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 resize-none">{{ old('message') }}</textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-10 mt-12 rounded-lg hover:opacity-90 transition-opacity shadow-lg">
                            Kirim Pesan
                        </button>
                    </div>
                </form>

                {{-- Kolom Quick Contact --}}
                <div class="relative bg-purple-100/60 text-gray-800 p-8 rounded-xl shadow-xl flex flex-col justify-between backdrop-blur-sm">
                    <div> {{-- Konten atas: Quick Contact info --}}
                        <h2 class="text-3xl md:text-4xl font-bold font-serif text-center mb-10">Quick Contact</h2>
                        <div class="space-y-8">
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
                                    <ul class="lg:ml-6 list-disc">
                                        <li class="text-sm">Graha Fadillah, Jl. Raya BSD Bintaro 5, Pondok Aren, Tangerang Selatan</li>
                                        <li class="text-sm">Jl. M. Husni Thamrin No. 49A, Kec. Watang Sawitti, Pinrang, Sulawesi Selatan</li>
                                        <li class="text-sm">Taman Sri Wedari, BR Cepaka, Munggu Bali</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- PETA --}}
                    <div class="mt-10 pt-6 border-t border-purple-200">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Lokasi Kami (Head Office)</h3>
                        <div class="overflow-hidden rounded-lg shadow-lg">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3169.8737064965358!2d106.6914078385558!3d-6.2816019945318535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fbc886388563%3A0x168df6b07524424c!2sGraha%20Fadilah!5e1!3m2!1sid!2sid!4v1758120615120!5m2!1sid!2sid" 
                                width="600" 
                                height="300" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection