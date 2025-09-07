@extends('layouts.admin')

@section('title', 'Sponsor Management')

@section('content')
    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">Oops! Terjadi kesalahan:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-8">
        {{-- BAGIAN SPONSOR LOGO --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Form Tambah Sponsor Logo --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-6 border-b pb-4">Tambah Sponsor (Logo)</h2>
                <form action="{{ route('admin.sponsors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium">Nama Sponsor</label>
                        <input type="text" name="name" placeholder="Contoh: PT Jaya Abadi" class="w-full mt-1 border-gray-300 rounded-lg p-2 shadow-sm" required>
                    </div>
                    <div>
                        <label for="website_url" class="block text-sm font-medium">Link Sponsor (URL)</label>
                        <input type="url" name="website_url" placeholder="https://contoh.com" class="w-full mt-1 p-2 border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Logo Sponsor</label>
                        <div id="logo-preview-container" class="mt-2 w-full h-32 hidden items-center justify-center bg-gray-100 rounded-lg overflow-hidden border border-dashed">
                            <img id="logo-preview" src="#" alt="Logo Preview" class="h-full object-contain p-2">
                        </div>
                        {{-- ID unik untuk input file --}}
                        <input id="logo_url_input" type="file" name="logo_url" accept="image/*" class="mt-2 block w-full text-sm ..." required>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="flex items-center gap-2 bg-purple-700 text-white font-bold py-2 px-6 rounded-lg hover:bg-purple-800">
                            <span class="iconify" data-icon="solar:upload-bold"></span><span>Simpan Sponsor</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Daftar Sponsor Logo --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-gray-700 mb-6 border-b pb-4">Daftar Sponsor (Logo)</h3>
                <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2">
                    @forelse ($sponsors as $sponsor)
                        <div class="grid grid-cols-3 items-center gap-4 p-3 rounded-md even:bg-gray-50">
                            <div class="col-span-2 flex items-center gap-4">
                                <img src="{{ asset('storage/' . $sponsor->logo_url) }}" alt="{{ $sponsor->name }}" class="h-10 object-contain">
                                <span class="font-semibold">{{ $sponsor->name }}</span>
                            </div>
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="p-2 bg-yellow-500 text-white rounded-md"><span class="iconify" data-icon="solar:pen-bold"></span></a>
                                <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" onsubmit="return confirm('Hapus sponsor ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500 text-white rounded-md"><span class="iconify" data-icon="solar:trash-bin-trash-bold"></span></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Belum ada sponsor.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- BAGIAN SPONSOR BANNER --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Form Tambah Sponsor Banner --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold text-gray-700 mb-6 border-b pb-4">Tambah Sponsor (Banner)</h2>
                <form action="{{ route('admin.sponsor-banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label for="banner_name" class="block text-sm font-medium">Nama Banner</label>
                        <input type="text" name="name" placeholder="Contoh: Banner Promo HUT" class="w-full mt-1 border-gray-300 rounded-lg p-2 shadow-sm" required>
                    </div>
                     <div>
                        <label for="banner_link_url" class="block text-sm font-medium">Link Banner (URL)</label>
                        <input type="url" name="link_url" placeholder="https://contoh.com" class="w-full mt-1 p-2 border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Gambar Banner</label>
                        <div id="banner-preview-container" class="mt-2 w-full h-32 hidden items-center justify-center bg-gray-100 rounded-lg overflow-hidden border border-dashed">
                            <img id="banner-preview" src="#" alt="Banner Preview" class="h-full object-contain p-2">
                        </div>
                        {{-- ID unik untuk input file --}}
                        <input id="banner_image_input" type="file" name="image_url" accept="image/*" class="mt-2 block w-full text-sm ..." required>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="flex items-center gap-2 bg-purple-700 text-white font-bold py-2 px-6 rounded-lg hover:bg-purple-800">
                             <span class="iconify" data-icon="solar:upload-bold"></span><span>Simpan Banner</span>
                        </button>
                    </div>
                </form>
            </div>

             {{-- Daftar Sponsor Banner --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-bold text-gray-700 mb-6 border-b pb-4">Daftar Sponsor (Banner)</h3>
                <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2">
                    @forelse ($sponsorBanners as $banner)
                         <div class="grid grid-cols-3 items-center gap-4 p-3 rounded-md even:bg-gray-50">
                            <div class="col-span-2 flex items-center gap-4">
                                <img src="{{ asset('storage/' . $banner->image_url) }}" alt="{{ $banner->name }}" class="h-10 object-contain">
                                <span class="font-semibold">{{ $banner->name }}</span>
                            </div>
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('admin.sponsor-banners.edit', $banner) }}" class="p-2 bg-yellow-500 text-white rounded-md"><span class="iconify" data-icon="solar:pen-bold"></span></a>
                                <form action="{{ route('admin.sponsor-banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Hapus banner ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500 text-white rounded-md"><span class="iconify" data-icon="solar:trash-bin-trash-bold"></span></button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Belum ada banner sponsor.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection