@extends('layouts.admin')
@section('title', 'E-Certificate Management')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Peserta & Sertifikat</h2>
        <a href="{{ route('admin.participants.create') }}"
            class="mt-4 sm:mt-0 bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            <span>Tambah Peserta</span>
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-xl font-bold text-gray-700 mb-4">Impor Peserta dari Excel</h3>
        <form action="{{ route('admin.participants.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="import_event_id" class="block text-sm font-medium text-gray-700">Pilih Event untuk
                        Peserta</label>
                    <select id="import_event_id" name="event_id" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        {{-- ## TAMBAHKAN PERULANGAN INI ## --}}
                        <option value="">-- Pilih salah satu --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="excel_file" class="block text-sm font-medium text-gray-700">File Excel (.xlsx, .csv)</label>
                    <input type="file" name="excel_file" id="excel_file" required class="mt-1 block w-full text-sm ...">
                </div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    Impor Data
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Peserta</th>
                        <th scope="col" class="px-6 py-3">Event</th>
                        <th scope="col" class="px-6 py-3">Nomor Sertifikat</th>
                        <th scope="col" class="px-6 py-3">Tanggal Dibuat</th>
                        <th scope="col" class="px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($participants as $participant)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $participant->name }}<br>
                                <span class="font-normal text-gray-500">{{ $participant->email }}</span>
                            </th>
                            <td class="px-6 py-4">{{ $participant->event->title ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-mono">{{ $participant->certificate_number }}</td>
                            <td class="px-6 py-4">{{ $participant->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    {{-- Tombol Edit bisa ditambahkan nanti --}}
                                    {{-- <a href="#" class="p-2 bg-yellow-500 text-white rounded-md" title="Edit"><span
                                            class="iconify" data-icon="solar:pen-bold"></span></a> --}}
                                    <form action="{{ route('admin.participants.destroy', $participant) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" class="delete-confirm-button p-2 bg-red-500 text-white rounded-md"
                                            title="Hapus">
                                            <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">Belum ada data peserta.</td>
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