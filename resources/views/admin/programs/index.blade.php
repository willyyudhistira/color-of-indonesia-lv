@extends('layouts.admin')

@section('title', 'Program Management')

@section('content')
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Program</h2>
        <a href="{{ route('admin.programs.create') }}" class="bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            Tambah Program Baru
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($programs as $program)
                <div class="flex items-start gap-4 p-4 rounded-md border">
                    <div class="w-12 h-12 flex-shrink-0 bg-purple-100 rounded-lg flex items-center justify-center">
                        @if($program->icon_url)
                            <img src="{{ asset('storage/' . $program->icon_url) }}" alt="{{ $program->title }}" class="w-8 h-8 object-contain">
                        @else
                            <span class="iconify text-purple-400 w-8 h-8" data-icon="solar:gallery-minimalistic-bold"></span>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-bold text-gray-800">{{ $program->title }}</h4>
                        <p class="text-sm font-semibold text-gray-600">{{ $program->subtitle }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($program->description, 100) }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $program->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $program->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <a href="{{ route('admin.programs.edit', $program) }}" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit">
                            <span class="iconify" data-icon="solar:pen-bold"></span>
                        </a>
                        <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus program ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-500 text-white rounded-md" title="Hapus">
                                <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Belum ada program yang ditambahkan.</p>
            @endforelse
        </div>
    </div>
@endsection