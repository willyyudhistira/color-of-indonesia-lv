@extends('layouts.app')
@section('title', 'Video Gallery - Color of Indonesia')

@section('content')
    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white" style="background-image: url('{{ asset('assets/images/hero-gallery.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        <h1 class="relative z-10 text-5xl md:text-6xl font-serif font-extrabold text-center px-4 tracking-tight">
            Video Gallery
        </h1>
    </section>

    <div class="container mx-auto px-6 md:px-20 py-20">
        <div class="text-center md:text-left mb-12">
            <h2 class="text-4xl font-bold text-purple-800 mb-3">Video Collection</h2>
            <div class="inline-block w-24 h-1 bg-purple-600"></div>
        </div>

        {{-- Grid untuk Video --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($videos as $video)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                    {{-- Wrapper untuk membuat video responsif dengan rasio 16:9 --}}
                    <div class="aspect-video w-full">
                        {{-- {!! $video->embed_code !!} --}}
                        {{-- PERBAIKAN: Modifikasi embed_code agar responsif --}}
                        {!! \Illuminate\Support\Str::of($video->embed_code)->replace(['width=', 'height='], ['class="w-full h-full"', '']) !!}
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">{{ $video->title }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3 flex-grow">{{ $video->description }}</p>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 text-lg py-16">No videos have been published yet.</p>
            @endforelse
        </div>

        {{-- Link Paginasi --}}
        <div class="mt-16">
            {{ $videos->links() }}
        </div>
    </div>
@endsection