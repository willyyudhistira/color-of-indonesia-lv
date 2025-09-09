@extends('layouts.admin')
@section('title', 'Program Management')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Program</h2>
        <a href="{{ route('admin.programs.create') }}" class="mt-4 sm:mt-0 bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            <span>Tambah Program Baru</span>
        </a>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($programs as $program)
                {{-- Pembungkus utama dibuat responsif (vertikal di mobile, horizontal di desktop) --}}
                <div class="flex flex-col sm:flex-row items-start gap-4 p-4 rounded-md border">
                    <div class="w-12 h-12 flex-shrink-0 bg-purple-100 rounded-lg flex items-center justify-center">
                        @if($program->icon_url)
                            <img src="{{ asset('storage/' . $program->icon_url) }}" alt="{{ $program->title }}" class="w-8 h-8 object-contain">
                        @else
                            <span class="iconify text-purple-400 w-8 h-8" data-icon="solar:gallery-minimalistic-bold"></span>
                        @endif
                    </div>
                    
                    <div class="flex-grow">
                        <h4 class="font-bold text-gray-800 break-words">{{ $program->title }}</h4>
                        <p class="text-sm font-semibold text-gray-600">{{ $program->subtitle }}</p>
                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $program->description }}</p>
                    </div>

                    {{-- Tombol Aksi, dibuat responsif --}}
                    <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto mt-3 sm:mt-0 border-t sm:border-none pt-3 sm:pt-0">
                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $program->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $program->is_published ? 'Published' : 'Draft' }}
                        </span>
                        
                        <div class="flex items-center gap-2 ml-auto">
                            <a href="{{ route('admin.programs.edit', $program) }}" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit">
                                <span class="iconify" data-icon="solar:pen-bold"></span>
                            </a>
                            {{-- Menggunakan SweetAlert2 untuk konfirmasi hapus --}}
                            <form action="{{ route('admin.programs.destroy', $program) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" class="delete-confirm-button p-2 bg-red-500 text-white rounded-md" title="Hapus">
                                    <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <p>Belum ada program yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection