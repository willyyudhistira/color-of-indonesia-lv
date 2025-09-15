@extends('layouts.admin')
@section('title', 'Events Management')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Card Event Terlaksana --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-red-100 p-3 rounded-full">
                <span class="iconify w-8 h-8 text-red-600" data-icon="solar:calendar-mark-bold"></span>
            </div>
            <div>
                <p class="text-3xl font-bold text-gray-800">{{ $pastEventsCount }}</p>
                <p class="text-gray-500">Event Terlaksana</p>
            </div>
        </div>

        {{-- Card Event Mendatang --}}
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center gap-4">
            <div class="bg-green-100 p-3 rounded-full">
                <span class="iconify w-8 h-8 text-green-600" data-icon="solar:calendar-bold"></span>
            </div>
            <div>
                <p class="text-3xl font-bold text-gray-800">{{ $upcomingEventsCount }}</p>
                <p class="text-gray-500">Event Mendatang</p>
            </div>
        </div>
    </div>

    {{-- Judul dan Tombol Tambah Event (kode ini sudah ada sebelumnya) --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Event</h2>
        <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
            {{-- Form Filter Bulan --}}
            <form id="month-filter-form-admin" action="{{ route('admin.events.index') }}" method="GET"
                class="relative w-full sm:w-auto">
                {{-- Input utama untuk Flatpickr --}}
                <input type="text" id="monthpicker-admin" name="month" value="{{ request('month') }}"
                    placeholder="Cari Bulan & Tahun"
                    class="w-full sm:w-64 bg-white border border-purple-700 rounded-lg py-2 pl-4 pr-10 text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500">

                {{-- Wrapper untuk ikon-ikon di sebelah kanan --}}
                <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2">

                    {{-- =============================================== --}}
                    {{-- == TOMBOL CLEAR FILTER (HANYA MUNCUL JIKA ADA FILTER) == --}}
                    {{-- =============================================== --}}
                    @if(request('month'))
                        <a href="{{ route('admin.events.index') }}" class="text-gray-500 hover:text-red-600"
                            title="Hapus Filter">
                            <span class="iconify" data-icon="solar:close-circle-bold"></span>
                        </a>
                    @endif

                    {{-- Ikon kalender (tetap ada) --}}
                    <span class="text-purple-700 pointer-events-none">
                        <span class="iconify" data-icon="solar:calendar-bold"></span>
                    </span>
                </div>
            </form>
            {{-- Tombol Tambah Event --}}
            <a href="{{ route('admin.events.create') }}"
                class="w-full sm:w-auto bg-purple-700 text-white font-bold py-2 px-4 rounded-lg hover:bg-purple-800 transition-colors flex items-center justify-center gap-2">
                <span class="iconify" data-icon="solar:add-circle-bold"></span>
                <span>Tambah Event</span>
            </a>
            <!-- Tombol Download Report -->
            <a href="{{ route('admin.events.export') }}" class="w-full sm:w-auto bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
            <span class="iconify" data-icon="solar:file-download-bold"></span>
            <span>Report</span>
            </a>
        </div>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
        <div class="space-y-4">
            @forelse ($events as $event)
                {{-- Pembungkus utama dibuat responsif (vertikal di mobile, horizontal di desktop) --}}
                <div class="flex flex-col sm:flex-row items-start gap-4 p-4 rounded-md border">
                    {{-- Gambar dibuat lebih besar di mobile --}}
                    <img src="{{ $event->hero_image_url ? asset('storage/' . $event->hero_image_url) : 'https://via.placeholder.com/400x300' }}"
                        alt="{{ $event->title }}"
                        class="w-full sm:w-32 h-48 sm:h-20 object-cover rounded-md flex-shrink-0 bg-gray-200">

                    <div class="flex-grow">
                        <div class="flex items-center flex-wrap gap-2 mb-1">
                            @if($event->is_published)
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-0.5 rounded-full">Published</span>
                            @else
                                <span class="bg-gray-200 text-gray-700 text-xs font-semibold px-2 py-0.5 rounded-full">Draft</span>
                            @endif
                            @if($event->is_featured)
                                <span
                                    class="bg-pink-100 text-pink-800 text-xs font-semibold px-2 py-0.5 rounded-full">Featured</span>
                            @endif
                        </div>
                        <h4 class="font-bold text-gray-800 break-words">{{ $event->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $event->location_name }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $event->start_date->format('d F Y') }}</p>
                    </div>

                    {{-- Tombol Aksi, dibuat responsif --}}
                    <div
                        class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto mt-3 sm:mt-0 border-t sm:border-none pt-3 sm:pt-0">
                        <div class="flex items-center gap-2 ml-auto">
                            <a href="{{ route('admin.events.edit', $event) }}" class="p-2 bg-yellow-500 text-white rounded-md"
                                title="Edit">
                                <span class="iconify" data-icon="solar:pen-bold"></span>
                            </a>
                            {{-- Menggunakan SweetAlert2 untuk konfirmasi hapus --}}
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" class="delete-confirm-button p-2 bg-red-500 text-white rounded-md"
                                    title="Hapus">
                                    <span class="iconify" data-icon="solar:trash-bin-trash-bold"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <p>Belum ada event yang ditambahkan.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $events->links() }}
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                // --- Bagian 1: Logika untuk Filter Tanggal Flatpickr ---
                const monthpickerInputAdmin = document.getElementById('monthpicker-admin');
                const formAdmin = document.getElementById('month-filter-form-admin');

                if (monthpickerInputAdmin && formAdmin) {
                    flatpickr(monthpickerInputAdmin, {
                        plugins: [
                            new monthSelectPlugin({
                                shorthand: true,
                                dateFormat: "Y-m",
                                altFormat: "F Y",
                            })
                        ],
                        onChange: function (selectedDates, dateStr, instance) {
                            if (dateStr) {
                                formAdmin.submit();
                            }
                        },
                        onClose: function (selectedDates, dateStr, instance) {
                            if (instance.input.value === '') {
                                window.location.href = "{{ route('admin.events.index') }}";
                            }
                        },
                    });
                }

                // --- Bagian 2: Logika untuk Konfirmasi Hapus SweetAlert2 ---
                const deleteButtons = document.querySelectorAll('.delete-confirm-button');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function (event) {
                        event.preventDefault();
                        const form = this.closest('form');
                        Swal.fire({
                            title: 'Anda yakin?',
                            text: "Event ini akan dihapus secara permanen!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#8B5CF6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
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

@endsection