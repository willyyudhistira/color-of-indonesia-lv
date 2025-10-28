@extends('layouts.app')
@section('title', 'E-Certificate List')

@section('content')
    {{-- Hero Section --}}
    <section class="relative h-96 flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/contact-hero.png') }}" class="w-full h-full object-cover" alt="Hero Image">
            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-black/50"></div>
        </div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-4xl md:text-6xl font-extrabold font-serif">E-Certificate</h1>
            <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto">Find your certificate by name or certificate number.</p>
        </div>
    </section>

    {{-- Filter and Table Section --}}
    <section class="py-20">
        <div class="container mx-auto px-6">

            @if(session('error'))
                <div class="max-w-4xl mx-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Filter Form --}}
            <form action="{{ route('e-certificate.index') }}" method="GET" class="max-w-4xl mx-auto mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Search Field --}}
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search Name / Number</label>
                        <input type="text" id="search" name="search" placeholder="e.g., Andriawan or COI-..."
                            value="{{ request('search') }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    {{-- Event Filter --}}
                    <div>
                        <label for="event_id" class="block text-sm font-medium text-gray-700">Filter by Event</label>
                        <select id="event_id" name="event_id"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 bg-white">
                            <option value="">All Events</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Submit Button --}}
                    <div class="md:pt-6">
                        <button type="submit"
                            class="w-full bg-purple-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-purple-700 transition-colors">
                            Filter / Search
                        </button>
                    </div>
                </div>
            </form>

            {{-- ========================================================= --}}
            {{-- Results Table (Hidden on Mobile) --}}
            {{-- ========================================================= --}}
            <div class="hidden md:block max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Certificate Number
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Download</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($participants as $participant)
                            <tr>
                                <td class="px-6 py-4">
                                    {{-- PERUBAHAN DI SINI: Menambah 'break-words' --}}
                                    <div class="text-sm font-medium text-gray-900 break-words">{{ $participant->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $participant->phone_number }}</div>
                                </td>
                                
                                {{-- PERUBAHAN DI SINI: Menghapus 'whitespace-nowrap' --}}
                                <td class="px-6 py-4">
                                    {{-- PERUBAHAN DI SINI: Menambah 'break-words' --}}
                                    <div class="text-sm text-gray-700 break-words">{{ $participant->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ $participant->certificate_number }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($participant->event && $participant->event->certificateTemplate)
                                        <a href="{{ route('e-certificate.download', $participant->id) }}" target="_blank"
                                            class="inline-block bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 transition-colors text-xs">
                                            Download
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Not Ready</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    No participants found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ========================================================= --}}
            {{-- Results Cards (Mobile View) --}}
            {{-- ========================================================= --}}
            <div class="block md:hidden max-w-4xl mx-auto space-y-4">
                @forelse($participants as $participant)
                    <div class="bg-white shadow-md rounded-lg p-5">
                        
                        {{-- Name, Phone, Email --}}
                        <div>
                            {{-- PERUBAHAN DI SINI: Menambah 'break-words' --}}
                            <h3 class="text-lg font-semibold text-purple-800 break-words">{{ $participant->name }}</h3>
                            @if($participant->phone_number)
                                <p class="text-sm text-gray-600">{{ $participant->phone_number }}</p>
                            @endif
                            {{-- PERUBAHAN DI SINI: Menambah 'break-words' --}}
                            <p class="text-sm text-gray-600 break-words">{{ $participant->email }}</p>
                        </div>

                        {{-- Divider --}}
                        <hr class="my-3">

                        {{-- Event and Cert Number --}}
                        <div>
                            <p class="text-sm text-gray-700">
                                <span class="font-medium text-gray-500">Event:</span>
                                {{ $participant->event->title ?? 'No Event' }}
                            </p>
                            <p class="text-sm text-gray-700 mt-1">
                                <span class="font-medium text-gray-500">Number:</span>
                                {{ $participant->certificate_number }}
                            </p>
                        </div>

                        {{-- Download Button --}}
                        <div class="mt-4 text-right">
                            @if($participant->event && $participant->event->certificateTemplate)
                                <a href="{{ route('e-certificate.download', $participant->id) }}" target="_blank"
                                   class="inline-block bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 transition-colors text-xs">
                                    Download
                                </a>
                            @else
                                <span class="text-xs text-gray-400 italic">Not Ready</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white shadow-md rounded-lg p-5 text-center text-gray-500">
                        No participants found matching your criteria.
                    </div>
                @endforelse
            </div>

            {{-- Pagination Links --}}
            <div class="max-w-4xl mx-auto mt-8">
                {{-- Ini akan mempertahankan query string (search & event_id) saat berganti halaman --}}
                {{ $participants->appends(request()->query())->links() }}
            </div>

        </div>
    </section>
@endsection