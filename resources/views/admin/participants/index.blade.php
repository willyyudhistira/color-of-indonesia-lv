@extends('layouts.admin')
@section('title', 'E-Certificate Management')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">List of Participants & Certificates</h2>
        <a href="{{ route('admin.participants.create') }}"
            class="mt-4 sm:mt-0 bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            <span>Add Participants</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Import Failed!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- TAMPILKAN DETAIL ERROR VALIDASI DARI EXCEL --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold block">Details of Errors in Excel Data:</strong>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-xl font-bold text-gray-700 mb-4">Import Participants from Excel</h3>
        <form action="{{ route('admin.participants.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="import_event_id" class="block text-sm font-medium text-gray-700">Select Event
                        Participants</label>
                    <select id="import_event_id" name="event_id" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        {{-- ## TAMBAHKAN PERULANGAN INI ## --}}
                        <option value="">-- Select one --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="excel_file" class="block text-sm font-medium text-gray-700">Excel Files (.xlsx,
                        .csv)</label>
                    <input type="file" name="excel_file" id="excel_file" required class="mt-1 block w-full text-sm ...">
                </div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    Import
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-md mb-8">
        <form action="{{ route('admin.participants.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                {{-- Input Pencarian --}}
                <div>
                    <label for="search" class="sr-only">Search</label>
                    <input type="text" name="search" id="search" placeholder="Search for name, email, or certificate no..."
                        value="{{ request('search') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                {{-- Filter Berdasarkan Event --}}
                <div>
                    <label for="filter_event_id" class="sr-only">Filter by Event</label>
                    <select id="filter_event_id" name="event_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- All Events --</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Tombol Aksi --}}
                <div class="flex items-center space-x-2">
                    <button type="submit"
                        class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                        Search / Filter
                    </button>
                    <a href="{{ route('admin.participants.index') }}"
                        class="w-full md:w-auto text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Participant Name</th>
                        <th scope="col" class="px-6 py-3">Event</th>
                        <th scope="col" class="px-6 py-3">Certificate Number</th>
                        <th scope="col" class="px-6 py-3">Date Created</th>
                        <th scope="col" class="px-6 py-3"><span class="sr-only">Action</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($participants as $participant)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{-- Bungkus nama dalam div dengan class truncate dan title --}}
                                <div class="max-w-xs truncate" title="{{ $participant->name }}">
                                    {{ $participant->name }}
                                </div>
                                <span class="font-normal text-gray-500">{{ $participant->email }}</span>
                            </th>
                            <td class="px-6 py-4">{{ $participant->event->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-mono">{{ $participant->certificate_number }}</td>
                            <td class="px-6 py-4">{{ $participant->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center space-x-2">

                                    {{-- TOMBOL EDIT --}}
                                    <a href="{{ route('admin.participants.edit', $participant) }}"
                                        class="p-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600"
                                        title="Edit Participant">
                                        <span class="iconify" data-icon="solar:pen-bold"></span>
                                    </a>

                                    {{-- TOMBOL CATATAN --}}
                                    <button type="button"
                                        class="open-notes-modal-btn p-2 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                                        title="Add/Edit Notes" data-participant-name="{{ e($participant->name) }}"
                                        data-current-notes="{{ e($participant->notes) }}"
                                        data-update-url="{{ route('admin.participants.updateNote', $participant) }}">
                                        <span class="iconify" data-icon="solar:notebook-bold"></span>
                                    </button>

                                    {{-- TOMBOL PRINT --}}
                                    <a href="{{ route('admin.participants.printCertificate', $participant) }}" target="_blank"
                                        class="p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                                        title="Print Certificate">
                                        <span class="iconify" data-icon="solar:printer-bold"></span>
                                    </a>

                                    {{-- TOMBOL DOWNLOAD --}}
                                    <a href="{{ route('admin.participants.downloadCertificate', $participant) }}"
                                        class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                                        title="Download Certificate PDF">
                                        <span class="iconify" data-icon="solar:file-download-bold"></span>
                                    </a>

                                    {{-- TOMBOL HAPUS --}}
                                    <form action="{{ route('admin.participants.destroy', $participant) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="delete-confirm-button p-2 mt-3.5 bg-red-500 text-white rounded-md hover:bg-red-600"
                                            title="Delete Participant">
                                            <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">There is no participant data yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8">
            {{ $participants->links() }}
        </div>
    </div>
@endsection

<div id="notesModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg">
        <h3 class="text-xl font-bold mb-4">Note for <span id="participantNameSpan" class="text-purple-700"></span>
        </h3>

        <form id="notesForm" method="POST">
            @csrf
            @method('PATCH')

            <textarea id="notesTextarea" name="notes" rows="6" class="w-full border-gray-300 rounded-md shadow-sm"
                placeholder="Add a note..."></textarea>

            <div class="mt-6 flex justify-end space-x-4">
                <button type="button" id="closeNotesModalBtn"
                    class="py-2 px-4 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit"
                    class="py-2 px-6 bg-purple-700 text-white font-bold rounded-lg hover:bg-purple-800">
                    Save Note
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
{{-- Pastikan script SweetAlert2 sudah diload di layouts.admin --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- 1. LOGIKA UNTUK MODAL NOTES (TIDAK BERUBAH) ---
        const modal = document.getElementById('notesModal');
        const openModalButtons = document.querySelectorAll('.open-notes-modal-btn');
        const closeModalBtn = document.getElementById('closeNotesModalBtn');
        const notesForm = document.getElementById('notesForm');
        const notesTextarea = document.getElementById('notesTextarea');
        const participantNameSpan = document.getElementById('participantNameSpan');

        openModalButtons.forEach(button => {
            button.addEventListener('click', function () {
                const name = this.dataset.participantName;
                const notes = this.dataset.currentNotes;
                const url = this.dataset.updateUrl;

                participantNameSpan.textContent = name;
                notesTextarea.value = notes;
                notesForm.action = url;
                modal.classList.remove('hidden');
            });
        });

        function closeModal() {
            modal.classList.add('hidden');
        }

        closeModalBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        // --- 2. LOGIKA UNTUK DELETE DENGAN SWEETALERT2 ---
        const deleteButtons = document.querySelectorAll('.delete-confirm-button');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this! The participant will be permanently deleted.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    });
</script>
@endpush