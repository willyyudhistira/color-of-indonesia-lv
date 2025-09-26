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
                                    <button type="button"
                                        class="open-delete-modal-btn p-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                                        title="Delete" data-participant-name="{{ e($participant->name) }}"
                                        data-delete-url="{{ route('admin.participants.destroy', $participant) }}">
                                        <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                    </button>

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

<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg">
        <!-- Header -->
        <div class="flex items-center justify-between border-b pb-3">
            <h3 class="text-lg font-bold text-gray-900">Delete Confirmation</h3>
            <button type="button" class="js-close-delete-modal text-gray-400 hover:text-gray-600 transition-colors">
                ✕
            </button>
        </div>

        <!-- Body -->
        <div class="mt-">
            <p class="text-gray-700">
                Are you sure you want to delete this participant?
            </p>
            <p class="mt-2 text-lg font-semibold text-red-600" id="deleteParticipantName"></p>
            <p class="mt-3 text-sm text-gray-500">
                This action is <span class="font-semibold text-red-600">permanent</span> and cannot be undone.
            </p>
        </div>

        <!-- Footer -->
        <div class="mt-6 flex justify-end space-x-4">
            <button type="button" class="js-close-delete-modal py-2 px-4 rounded-lg border border-gray-300 bg-gray-100 text-gray-700 hover:bg-gray-200 font-medium">
                Cancel
            </button>

            {{-- Form hapus --}}
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-red-600 text-white font-bold hover:bg-red-700 shadow-md">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('notesModal');
        const openModalButtons = document.querySelectorAll('.open-notes-modal-btn');
        const closeModalBtn = document.getElementById('closeNotesModalBtn');
        const notesForm = document.getElementById('notesForm');
        const notesTextarea = document.getElementById('notesTextarea');
        const participantNameSpan = document.getElementById('participantNameSpan');

        // Fungsi untuk membuka modal
        openModalButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Ambil data dari tombol yang diklik
                const name = this.dataset.participantName;
                const notes = this.dataset.currentNotes;
                const url = this.dataset.updateUrl;

                // Isi modal dengan data yang sesuai
                participantNameSpan.textContent = name;
                notesTextarea.value = notes;
                notesForm.action = url;

                // Tampilkan modal
                modal.classList.remove('hidden');
            });
        });

        // Fungsi untuk menutup modal
        function closeModal() {
            modal.classList.add('hidden');
        }

        closeModalBtn.addEventListener('click', closeModal);

        // Tutup modal jika klik di luar area konten
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });

        const deleteModal = document.getElementById('deleteModal');
        const openDeleteModalButtons = document.querySelectorAll('.open-delete-modal-btn');
        const closeDeleteModalButtons = document.querySelectorAll('.js-close-delete-modal');
        const deleteForm = document.getElementById('deleteForm');
        const deleteParticipantName = document.getElementById('deleteParticipantName');

        // Fungsi untuk membuka modal hapus
        openDeleteModalButtons.forEach(button => {
            button.addEventListener('click', function () {
                const name = this.dataset.participantName;
                const url = this.dataset.deleteUrl;

                // Isi modal dengan data yang sesuai
                deleteParticipantName.textContent = name;
                deleteForm.action = url;

                // Tampilkan modal
                deleteModal.classList.remove('hidden');
            });
        });

        // Fungsi untuk menutup modal hapus
        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
        }

        closeDeleteModalButtons.forEach(button => {
            button.addEventListener('click', closeDeleteModal);
        });

        // Tutup modal jika klik di luar area konten
        deleteModal.addEventListener('click', function (event) {
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });
    });
</script>