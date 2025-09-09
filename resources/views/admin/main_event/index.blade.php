@extends('layouts.admin')

@section('title', 'Main Event Management')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Main Event</h2>
        <a href="{{ route('admin.main-events.create') }}" class="mt-4 sm:mt-0 bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            <span>Tambah Main Event</span>
        </a>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($mainEvents as $event)
                {{-- Pembungkus utama dibuat responsif (vertikal di mobile, horizontal di desktop) --}}
                <div class="flex flex-col sm:flex-row items-start gap-4 p-4 rounded-md border">
                    {{-- Gambar dibuat lebih besar di mobile --}}
                    <img src="{{ $event->hero_image_url ? asset('storage/' . $event->hero_image_url) : 'https://via.placeholder.com/400x300' }}" alt="{{ $event->title }}" class="w-full sm:w-32 h-48 sm:h-20 object-cover rounded-md flex-shrink-0 bg-gray-200">
                    
                    <div class="flex-grow">
                        <h4 class="font-bold text-gray-800 break-words">{{ $event->title }}</h4>
                        <p class="text-sm font-semibold text-purple-700">{{ $event->subtitle }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $event->location_name }}</p>
                    </div>

                    {{-- Tombol Aksi, dibuat responsif --}}
                    <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto mt-3 sm:mt-0 border-t sm:border-none pt-3 sm:pt-0">
                        <div class="flex items-center gap-2 ml-auto">
                            <a href="{{ route('admin.main-events.edit', $event) }}" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit">
                                <span class="iconify" data-icon="solar:pen-bold"></span>
                            </a>
                            {{-- Menggunakan SweetAlert2 untuk konfirmasi hapus --}}
                            <form action="{{ route('admin.main-events.destroy', $event) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete-confirm-button p-2 bg-red-500 text-white rounded-md" title="Hapus">
                                    <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <p>Belum ada main event yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection