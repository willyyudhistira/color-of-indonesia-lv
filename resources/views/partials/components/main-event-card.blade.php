<div class="relative group aspect-[9/16] overflow-hidden shadow-lg rounded-lg">
    {{-- Gambar Latar --}}
    <img src="{{ asset('storage/' . $event->hero_image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 transform group-hover:scale-110" />
    
    {{-- Tampilan Default (sebelum hover) --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6 transition-opacity duration-500 group-hover:opacity-0">
        <h3 class="text-white text-3xl font-bold font-serif">{{ $event->title }}</h3>
    </div>
    
    {{-- Tampilan Saat Hover --}}
    <div class="absolute inset-0 bg-gradient-to-t from-purple-800 to-pink-500/80 p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-start text-left">
        <div class="flex-grow">
            <h3 class="text-white text-2xl font-bold font-serif mb-2">{{ $event->title }}</h3>
            <p class="text-white/90 text-sm leading-relaxed">{{ Str::limit($event->description, 100) }}</p>
            @if($event->link_url)
            <a href="{{ $event->link_url }}" target="_blank" rel="noopener noreferrer" class="mt-4 inline-block self-start bg-white/30 text-white font-semibold text-xs py-2 px-4 rounded-full hover:bg-white hover:text-purple-800 transition-colors">
                More
            </a>
            @endif
        </div>
        
        {{-- ## TOMBOL BARU DITAMBAHKAN DI SINI ## --}}
    </div>
</div>