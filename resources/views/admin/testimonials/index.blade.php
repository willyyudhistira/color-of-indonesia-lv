@extends('layouts.admin')
@section('title', 'Testimonial Management')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Testimonial List</h2>
        <a href="{{ route('admin.testimonials.create') }}" class="mt-4 sm:mt-0 bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            <span>Add Testimonial</span>
        </a>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($testimonials as $item)
                {{-- Pembungkus utama untuk setiap item, dibuat responsif --}}
                <div class="flex flex-col sm:flex-row items-start gap-4 p-4 rounded-md border">
                    <img src="{{ $item->avatar_url ? asset('storage/'. $item->avatar_url) : 'https://ui-avatars.com/api/?name='.urlencode($item->author_name).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $item->author_name }}" class="w-16 h-16 rounded-full object-cover flex-shrink-0 bg-gray-200">
                    
                    <div class="flex-grow">
                        <p class="font-bold text-gray-800">{{ $item->author_name }} 
                            <span class="text-sm font-normal text-gray-500">- {{ $item->role_title }}</span>
                        </p>
                        <p class="text-sm text-gray-600 mt-1 italic">"{{ $item->quote }}"</p>
                    </div>

                    {{-- Tombol Aksi, dibuat responsif --}}
                    <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto mt-3 sm:mt-0">
                         <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $item->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                            {{ $item->is_published ? 'Published' : 'Draft' }}
                        </span>
                        
                        {{-- Wrapper untuk tombol edit dan hapus agar lebih rapi di mobile --}}
                        <div class="flex items-center gap-2 ml-auto">
                            <a href="{{ route('admin.testimonials.edit', $item) }}" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit">
                                <span class="iconify" data-icon="solar:pen-bold"></span>
                            </a>
                            <form action="{{ route('admin.testimonials.destroy', $item) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" class="delete-confirm-button p-2 bg-red-500 text-white rounded-md" title="Delete">
                                    <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <p>There are no testimonials yet. Please add a new one.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection