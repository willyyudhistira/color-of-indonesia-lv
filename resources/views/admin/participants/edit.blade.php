@extends('layouts.admin')
@section('title', 'Participant Edit')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit</h2>

        <form action="{{ route('admin.participants.update', $participant) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Peserta --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Participant Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $participant->name) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $participant->email) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            {{-- Event --}}
            <div>
                <label for="event_id" class="block text-sm font-medium text-gray-700">Event</label>
                <select id="event_id" name="event_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id', $participant->event_id) == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Grup/Instansi --}}
            <div>
                <label for="group" class="block text-sm font-medium text-gray-700">Group / Institution</label>
                <input type="text" id="group" name="group" value="{{ old('group', $participant->group) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            
            {{-- Detail Sertifikat Lainnya --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t">
                <div>
                    <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                    <input type="text" id="purpose" name="purpose" value="{{ old('purpose', $participant->purpose) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <input type="text" id="type" name="type" value="{{ old('type', $participant->type) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" id="category" name="category" value="{{ old('category', 'category') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="subcategory" class="block text-sm font-medium text-gray-700">Sub-Category</label>
                    <input type="text" id="subcategory" name="subcategory" value="{{ old('subcategory', $participant->subcategory) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end items-center pt-6 border-t space-x-4">
                <a href="{{ route('admin.participants.index') }}" class="py-2 px-6 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">
                    Back
                </a>
                <button type="submit" class="py-2 px-8 bg-purple-700 text-white font-bold rounded-lg hover:bg-purple-800">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection