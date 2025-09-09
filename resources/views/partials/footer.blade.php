<footer class="px-20 relative bg-gradient-to-r from-[#2546bd] via-[#A200FF] to-pink-400 text-white overflow-hidden">
    <!-- Layer 1: Motif Batik sebagai Latar Belakang -->
    <div class="absolute inset-0 z-0 flex justify-end">
        <img src="{{ asset('assets/images/patternfooter2.png') }}" class="h-full w-1/2 object-cover opacity-40" alt="Batik Pattern">
    </div>

    <!-- Layer 2: Konten Utama -->
    <div class="relative container mx-auto px-8 pt-16 z-10">
        
        {{-- Grid Utama dengan 4 kolom --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 mb-12">
            
            <!-- Kolom 1: Logo & Social Media -->
            <div class="lg:col-span-4" >
                <img src="{{ asset('assets/images/logo_coi.png') }}" class="h-32 mb-6" alt="Color of Indonesia Logo">
                <div class="flex space-x-4">
        {{-- Ikon Instagram --}}
        <a href="#" class="hover:opacity-75 transition-opacity" title="Instagram">
           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4zm9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3"/></svg>
        </a>

        {{-- Ikon Facebook (DITAMBAHKAN) --}}
        <a href="#" class="hover:opacity-75 transition-opacity" title="Facebook">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
        </a>

        {{-- Ikon X (Twitter) --}}
        <a href="#" class="hover:opacity-75 transition-opacity" title="X">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" /></svg>
        </a>

        {{-- Ikon TikTok (DITAMBAHKAN) --}}
        <a href="#" class="hover:opacity-75 transition-opacity" title="TikTok">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="currentColor" d="M16.6 5.82s.51.5 0 0A4.28 4.28 0 0 1 15.54 3h-3.09v12.4a2.59 2.59 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6c0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64c0 3.33 2.76 5.7 5.69 5.7c3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.24-1.48"/></svg>
        </a>
    </div>
            </div>

            <!-- Kolom 2: Tautan -->
            <div class="lg:col-span-2">
                <h3 class="font-bold text-lg mb-4">Tautan</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:underline">Contact Us</a></li>
                    <li><a href="#" class="hover:underline">Sponsorship</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kantor -->
            <div class="lg:col-span-3">
                <h3 class="font-bold text-lg mb-4">Kantor</h3>
                <div class="flex items-start space-x-2">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
  <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
</svg>


                    <p class="text-sm">Graha Fadillah, Jl. Raya BSD Bintaro 5, Paringi, Pondok Aren, Tangerang Selatan</p>
                </div>
            </div>

            <!-- Kolom 4: Subscribe & Visitor Counter -->
            <div class="lg:col-span-3">
                <h3 class="font-bold text-lg mb-4">Subscribe Newsletter</h3>
                <div class="flex items-center mb-6">
                    <input type="email" placeholder="Your Email" class="w-full px-4 py-2 text-gray-800 rounded-l-full border-1 border-purple-500 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    <button type="submit" class="bg-white text-purple-700 font-bold px-4 py-2 rounded-r-full hover:bg-purple-700 hover:text-white transition-colors">Subscribe</button>
                </div>
                <div class="inline-block bg-white bg-opacity-30 backdrop-blur-sm rounded-full px-6 py-2">
    <p class="font-numeric font-bold text-xl text-center">{{ $visitorCount ?? '0' }}</p>
    <p class="text-sm">visitor</p>
</div>
            </div>

        </div>

        <div class="border-t border-white mt-12 pt-6 text-center text-sm text-gray-200">
            <p>COI Management © 2025</p>
        </div>
    </div>
</footer>