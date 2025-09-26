@extends('layouts.admin')
@section('title', 'Add New Event')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Event</h2>
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @include('admin.events.partials.form')
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.events.index') }}" class="py-2 px-6 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg hover:bg-purple-800">Save Event</button>
            </div>
        </form>
    </div>
@endsection