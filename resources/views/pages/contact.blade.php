@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white" style="background-image: url('{{ asset('assets/images/contact-hero.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        <h1 class="relative z-10 text-5xl md:text-7xl font-extrabold font-serif">Tetap Terhubung</h1>
    </section>

   {{-- Contact Form Section --}}
<section class="py-20">
    {{-- PERBAIKAN: px-20 dipindahkan ke container untuk kontrol yang lebih baik --}}
    <div class="container mx-auto px-20">
        
        {{-- Judul dan Garis Dekoratif --}}
        {{-- PERBAIKAN: max-w-* dan mx-auto dihapus agar lebar mengikuti container --}}
        <div class="text-left mb-16">
            <h2 class="text-4xl font-bold text-purple-800 mb-4">Hubungi Kami</h2>
            <div class="flex items-center my-6">
                <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
                <div class="flex-grow h-0.5 bg-purple-700 w-full"></div>
                <div class="w-2 h-2 bg-purple-700 rounded-full"></div>
            </div>
        </div>

        {{-- PERBAIKAN: max-w-* dan mx-auto dihapus --}}
        <div class="grid md:grid-cols-2 gap-12 items-start">
            
            {{-- Kolom Formulir (Tidak ada perubahan di sini) --}}
            <form action="#" method="POST" class="space-y-6 bg-white rounded-xl shadow-2xl p-8 md:p-12">
                @csrf 
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                {{-- ... isi form Anda ... --}}
                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Anda</label>
                        <input type="text" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required
                               class="w-full bg-gray-100 px-4 py-3 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" id="email" name="email" placeholder="anda@email.com" value="{{ old('email') }}" required
                               class="w-full bg-gray-100 px-4 py-3 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1">Subjek</label>
                    <input type="text" id="subject" name="subject" placeholder="Tujuan pesan Anda" value="{{ old('subject') }}" required
                           class="w-full bg-gray-100 px-4 py-3 border @error('subject') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                    @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-1">Pesan</label>
                    <textarea id="message" name="message" placeholder="Tuliskan pesan Anda di sini..." rows="5" required
                              class="w-full bg-gray-100 px-4 py-3 border @error('message') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition resize-none">{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <button type="submit" class="w-full bg-gradient-to-r from-[#CD75FF] to-[#8949FF] text-white font-bold py-3 px-10 rounded-lg hover:bg-purple-800 transition-all duration-300 shadow-lg">
                        Kirim Pesan
                    </button>
                </div>
            </form>

            {{-- Kolom Quick Contact --}}
            {{-- PERBAIKAN: overflow-hidden dihapus agar konten tidak terpotong --}}
            <div class="relative bg-purple-300/50 text-gray-800 p-8 md:p-12 rounded-xl shadow-2xl">
                <div class="relative z-10">
                    <h2 class="text-4xl font-bold font-serif text-center mb-10">Quick Contact</h2>
                    <div class="grid md:grid-cols-2 gap-x-8 gap-y-10">
                        {{-- ... isi card quick contact Anda (tidak ada perubahan di sini) ... --}}
                         {{-- 1. Call Us --}}
                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
            <path fill="currentColor" d="M24 13h-2a3.003 3.003 0 0 0-3-3V8a5.006 5.006 0 0 1 5 5"/>
            <path fill="currentColor" d="M28 13h-2a7.01 7.01 0 0 0-7-7V4a9.01 9.01 0 0 1 9 9m-7.667 8.482l2.24-2.24a2.17 2.17 0 0 1 2.337-.48l2.728 1.092A2.17 2.17 0 0 1 29 21.866v4.961a2.167 2.167 0 0 1-2.284 2.169C7.594 27.806 3.732 11.61 3.015 5.408A2.162 2.162 0 0 1 5.169 3h4.873a2.17 2.17 0 0 1 2.012 1.362l1.091 2.728a2.17 2.17 0 0 1-.48 2.337l-2.24 2.24s1.242 8.732 9.908 9.815"/>
        </svg>        
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-1">Call Us</h4>
                                <p class="font-numeric">+6281211603309 (Head Office)</p>
                                <p class="font-numeric">+6281211603309 (Sulawesi)</p>
                                <p class="font-numeric">+6281211603309 (Bali)</p>
                            </div>
                        </div>

                        {{-- 2. Email Us --}}
                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M13.39 12.145v26.39H7.06a2.56 2.56 0 0 1-2.56-2.54v-19.18m30.11-4.67v26.39h6.33a2.56 2.56 0 0 0 2.56-2.54v-19.18" stroke-width="1"/>
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m24 31.445l19.5-14.45v-3.6a3.94 3.94 0 0 0-6.28-3.16L24 20.055l-13.22-9.82a3.94 3.94 0 0 0-6.28 3.16v3.6z" stroke-width="1"/>
        </svg>                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-1">Email Us</h4>
                                <p>info@colorofindonesia.com</p>
                                <p>info@colorofindonesia.com</p>
                                <p>info@colorofindonesia.com</p>
                            </div>
                        </div>

                        {{-- 3. Visit Us --}}
                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Visit Us</h4>
                                <ul class="space-y-2">
                                    <li>Graha Fadilah, Jl. Raya BSD Bintaro 5, Pondok Aren, Tangerang Selatan</li>
                                    <li>Jl. M. Husni Thamrin No. 49A, Kec. Watang Sawitti, Pinrang, Sulawesi Selatan</li>
                                    <li>Taman Sri Wedari, BR Cepaka, Munggu Bali</li>
                                </ul>
                            </div>
                        </div>

                        {{-- 4. Follow Us --}}
                        <div class="flex items-start space-x-4">
                            <div class="bg-purple-100 p-3 rounded-full flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <g fill="currentColor">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7a3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0a3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4a2 2 0 0 0 0 4"/>
                <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
            </g>
        </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Follow Us</h4>
                                <div class="flex space-x-4 text-black">
                                     <a href="#" class="hover:opacity-75 transition-opacity" title="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4zm9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3"/></svg></a>
                                     <a href="#" class="hover:opacity-75 transition-opacity" title="Facebook"><svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg></a>
                                     <a href="#" class="hover:opacity-75 transition-opacity" title="X"><svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" /></svg></a>
                                     <a href="#" class="hover:opacity-75 transition-opacity" title="TikTok"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="M16.6 5.82s.51.5 0 0A4.28 4.28 0 0 1 15.54 3h-3.09v12.4a2.59 2.59 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6c0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64c0 3.33 2.76 5.7 5.69 5.7c3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.24-1.48"/></svg></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection