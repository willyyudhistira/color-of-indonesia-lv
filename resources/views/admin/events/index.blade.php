@extends('layouts.admin')

@section('title', 'Events Management')

@section('content')
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Event</h2>
        <a href="{{ route('admin.events.create') }}" class="bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            Tambah Event Baru
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($events as $event)
                <div class="flex items-start gap-4 p-4 rounded-md border">
                    <img src="{{ $event->hero_image_url ? asset('storage/' . $event->hero_image_url) : 'https://via.placeholder.com/128x80' }}" alt="{{ $event->title }}" class="w-32 h-20 object-cover rounded-md flex-shrink-0 bg-gray-200">
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-1">
                            @if($event->is_published)
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-0.5 rounded-full">Published</span>
                            @else
                                <span class="bg-gray-200 text-gray-700 text-xs font-semibold px-2 py-0.5 rounded-full">Draft</span>
                            @endif
                            @if($event->is_featured)
                                <span class="bg-pink-100 text-pink-800 text-xs font-semibold px-2 py-0.5 rounded-full">Featured</span>
                            @endif
                        </div>
                        <h4 class="font-bold text-gray-800">{{ $event->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $event->location_name }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $event->start_date->format('d F Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.events.edit', $event) }}" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit"><span class="iconify" data-icon="solar:pen-bold"></span></a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Anda yakin?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-red-500 text-white rounded-md" title="Hapus"><span class="iconify" data-icon="solar:trash-bin-trash-bold"></span></button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Belum ada event yang ditambahkan.</p>
            @endforelse
        </div>
        
        {{-- Link Paginasi --}}
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    </div>
@endsection