@extends('layouts.admin')

@section('title', 'Main Event Management')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Main Event</h2>
        <a href="{{ route('admin.main-events.create') }}" class="bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            Tambah Main Event
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($mainEvents as $event)
                <div class="flex items-start gap-4 p-4 rounded-md border">
                    <img src="{{ asset('storage/' . $event->hero_image_url) }}" alt="{{ $event->title }}" class="w-32 h-20 object-cover rounded-md flex-shrink-0 bg-gray-200">
                    <div class="flex-grow">
                        <h4 class="font-bold text-gray-800">{{ $event->title }}</h4>
                        <p class="text-sm font-semibold text-purple-700">{{ $event->subtitle }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $event->location_name }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.main-events.edit', $event) }}" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit">
                            <span class="iconify" data-icon="solar:pen-bold"></span>
                        </a>
                        <form action="{{ route('admin.main-events.destroy', $event) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus event ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-500 text-white rounded-md" title="Hapus">
                                <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Belum ada main event yang ditambahkan.</p>
            @endforelse
        </div>
    </div>
@endsection