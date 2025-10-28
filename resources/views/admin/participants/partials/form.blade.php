@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p class="font-bold">Oops! There were some errors:</p>
        <ul class="list-disc list-inside mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Baris 1: Nama & Email --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Participant's Full Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $participant->name ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
        <input type="email" id="email" name="email" value="{{ old('email', $participant->email ?? '') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
        <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number', $participant->phone_number ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>

{{-- Baris 2: Event & Group --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="event_id" class="block text-sm font-medium text-gray-700">Select Events</label>
        <select id="event_id" name="event_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="">-- Select one --</option>
            @foreach($events as $event)
                <option value="{{ $event->id }}" @selected(old('event_id', $participant->event_id ?? '') == $event->id)>
                    {{ $event->title }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="group" class="block text-sm font-medium text-gray-700">Group / Institution (Optional)</label>
        <input type="text" id="group" name="group" value="{{ old('group', $participant->group ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>

{{-- Baris 3: Purpose, Type, Category --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div>
        <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose (Opsional)</label>
        <input type="text" id="purpose" name="purpose" value="{{ old('purpose', $participant->purpose ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="type" class="block text-sm font-medium text-gray-700">Type (Opsional)</label>
        <input type="text" id="type" name="type" value="{{ old('type', $participant->type ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="category" class="block text-sm font-medium text-gray-700">Category (Opsional)</label>
        <input type="text" id="category" name="category" value="{{ old('category', $participant->category ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
    <div>
        <label for="subcategory" class="block text-sm font-medium text-gray-700">Sub-Category (Opsional)</label>
        <input type="text" id="subcategory" name="subcategory" value="{{ old('subcategory', $participant->subcategory ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>
</div>