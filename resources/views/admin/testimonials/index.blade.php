@extends('layouts.admin')
@section('title', 'Testimonial Management')

@section('content')
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Testimoni</h2>
        <a href="{{ route('admin.testimonials.create') }}" class="bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            Tambah Testimoni
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($testimonials as $item)
                <div class="flex items-start gap-4 p-4 rounded-md border">
                    <img src="{{ $item->avatar_url ? asset('storage/' . $item->avatar_url) : 'https://via.placeholder.com/100' }}" alt="{{ $item->author_name }}" class="w-16 h-16 rounded-full object-cover flex-shrink-0 bg-gray-200">
                    <div class="flex-grow">
                        <p class="font-bold text-gray-800">{{ $item->author_name }} <span class="text-sm font-normal text-gray-500">- {{ $item->role_title }}</span></p>
                        <p class="text-sm text-gray-600 mt-1 italic">"{{ $item->quote }}"</p>
                    </div>
                    <div class="flex items-center gap-3">
                         <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $item->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <a href="{{ route('admin.testimonials.edit', $item) }}" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit"><span class="iconify" data-icon="solar:pen-bold"></span></a>
                        <form action="{{ route('admin.testimonials.destroy', $item) }}" method="POST" onsubmit="return confirm('Anda yakin?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-red-500 text-white rounded-md" title="Hapus"><span class="iconify" data-icon="solar:trash-bin-trash-bold"></span></button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Belum ada testimoni.</p>
            @endforelse
        </div>
    </div>
@endsection