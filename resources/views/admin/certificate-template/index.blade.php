@extends('layouts.admin')
@section('title', 'Certificate Template Management')

@section('content')
    {{-- 1. Header Halaman: Disesuaikan dengan referensi (responsif flex-col ke sm:flex-row) --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">List of Certificate Templates</h2>
        <a href="{{ route('admin.certificate-templates.create') }}"
           class="mt-4 sm:mt-0 bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center gap-2">
            <span class="iconify" data-icon="solar:add-circle-bold"></span>
            <span>Create a New Template</span>
        </a>
    </div>

    {{-- 2. Kartu Konten Utama: Menggunakan gaya padding dan shadow yang sama --}}
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            {{-- 3. Tabel: Menggunakan gaya thead, tr, dan td yang sama persis --}}
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Template Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-right">
                            {{-- Kolom Aksi dibuat tidak terlihat untuk aksesibilitas --}}
                            <span class="sr-only">Action</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($templates as $template)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $template->template_name }}
                            </th>
                            <td class="px-6 py-4 text-right">
                                {{-- 4. Tombol Aksi: Diubah menjadi tombol ikon berwarna yang konsisten --}}
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('admin.certificate-templates.download', $template) }}" class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600" title="Download Preview PDF">
                                        <span class="iconify" data-icon="solar:file-download-bold"></span>
                                    </a>
                                    <a href="{{ route('admin.certificate-templates.edit', $template) }}" class="p-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600" title="Edit Template">
                                        <span class="iconify" data-icon="solar:pen-bold"></span>
                                    </a>
                                    <form action="{{ route('admin.certificate-templates.destroy', $template) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this template??');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600" title="Delete Templates">
                                            <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-8 text-gray-500">
                                No templates have been created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Jika nanti ada paginasi, bisa ditambahkan di sini --}}
        <div class="mt-8">
            {{ $templates->links() }}
        </div>
    </div>
@endsection