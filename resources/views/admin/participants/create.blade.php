@extends('layouts.admin')

@section('title', 'Add New Participants')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add Participants Manually</h2>
        
        <form action="{{ route('admin.participants.store') }}" method="POST" class="space-y-6">
            @csrf
            @include('admin.participants.partials.form')
            <div class="flex justify-end gap-4 pt-4 border-t mt-6">
                <a href="{{ route('admin.participants.index') }}" class="py-2 px-6 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
                <button type="submit" class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg hover:bg-purple-800">
                    Save & Send Notification
                </button>
            </div>
        </form>
    </div>
@endsection