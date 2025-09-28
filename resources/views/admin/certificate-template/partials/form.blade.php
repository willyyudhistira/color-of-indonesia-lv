@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
        <p class="font-bold">Oops! Something went wrong:</p>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <label for="template_name" class="block text-lg font-medium text-gray-700">Template Name</label>
    <input type="text" name="template_name" id="template_name"
        value="{{ old('template_name', $template->template_name ?? '') }}" required
        placeholder="Contoh: Template Lomba Tari 2025" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
</div>

<div>
    <label class="block text-lg font-medium text-gray-700">Certificate Background Image</label>
    @if(isset($template) && $template->background_image)
        <img src="{{ asset('storage/' . $template->background_image) }}"
            class="w-full h-auto object-contain rounded-md mt-2 border p-2">
    @endif
    <input type="file" name="background_image"
        class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0">
</div>

<div>
    <label class="block text-lg font-medium text-gray-700">Header Logo</label>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
        @for ($i = 1; $i <= 7; $i++)
            <div>
                <label class="block text-xs font-medium text-gray-500">Logo {{ $i }}</label>
                @if(isset($template) && $template->{'logo' . $i})
                    <img src="{{ asset('storage/' . $template->{'logo' . $i}) }}"
                        class="h-12 object-contain my-1 border p-1 rounded">
                @endif
                <input type="file" name="logo{{$i}}" class="block w-full text-xs ...">
            </div>
        @endfor
    </div>
</div>

<div class="mt-6">
    <label for="main_title" class="block text-lg font-medium text-gray-700">Certificate Main Title</label>
    <input type="text" id="main_title" name="main_title"
        value="{{ old('main_title', $template->main_title ?? 'Certificate of Participation') }}"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    <p class="text-xs text-gray-500 mt-1">Example: Certificate of Achievement, Certificate of Participation.</p>
</div>

<div class="space-y-6 bg-gray-50 p-6 rounded-lg border border-gray-200 mt-8">
    <h3 class="text-xl font-semibold text-gray-800">Description Text Settings</h3>
    <p class="text-sm text-gray-500">
        You can use the following placeholders in the text: <br>
        <code class="bg-gray-200 text-red-600 px-1 rounded">[event_title]</code>,
        <code class="bg-gray-200 text-red-600 px-1 rounded">[event_date]</code>,
        <code class="bg-gray-200 text-red-600 px-1 rounded">[purpose]</code>,
        <code class="bg-gray-200 text-red-600 px-1 rounded">[category]</code>
    </p>

    <div>
        <label for="body_text" class="block font-medium text-gray-700">Main Text (for all)</label>
        <textarea id="body_text" name="body_text" rows="3"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('body_text', $template->body_text ?? null) }}</textarea>
        <p class="text-xs text-gray-500 mt-1">Example: In recognition of your participation in the event [event_title],
            held on [event_date].</p>
    </div>

    <div>
        <label for="winner_text" class="block font-medium text-gray-700">Additional Text For Winner (Winner)</label>
        <textarea id="winner_text" name="winner_text" rows="3"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('winner_text', $template->winner_text ?? null) }}</textarea>
        <p class="text-xs text-gray-500 mt-1">Example: This award is given in recognition of your outstanding
            achievement as the Winner in the [purpose] competition, [category] category.</p>
    </div>

    <div>
        <label for="supporting_text" class="block font-medium text-gray-700">Additional Text for Supporters
            (Supporting)</label>
        <textarea id="supporting_text" name="supporting_text" rows="3"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('supporting_text', $template->supporting_text ?? null) }}</textarea>
        <p class="text-xs text-gray-500 mt-1">Example: Your contribution in the role of Supporter for the [category] was
            invaluable to the success of this event.</p>
    </div>

    <div>
        <label for="participant_text" class="block font-medium text-gray-700">Additional Text for Others
            (Default)</label>
        <textarea id="participant_text" name="participant_text" rows="3"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('participant_text', $template->participant_text ?? null) }}</textarea>
        <p class="text-xs text-gray-500 mt-1">Example: You have contributed to promoting understanding and friendship
            among participants.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-6 border-t">
    <div class="space-y-4">
        <h3 class="font-semibold text-gray-800">Signature 1</h3>
        <div>
            <label class="block text-sm">Name</label>
            <input type="text" name="signature1_name"
                value="{{ old('signature1_name', $template->signature1_name ?? '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label class="block text-sm">Position</label>
            <input type="text" name="signature1_title"
                value="{{ old('signature1_title', $template->signature1_title ?? '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label class="block text-sm">Signature Image</label>
            @if(isset($template) && $template->signature1_image)
                <img src="{{ asset('storage/' . $template->signature1_image) }}"
                    class="h-16 object-contain my-1 border p-1 rounded">
            @endif
            <input type="file" name="signature1_image" class="block w-full text-sm ...">
        </div>
    </div>
    <div class="space-y-4">
        <h3 class="font-semibold text-gray-800">Signature 2</h3>
        <div>
            <label class="block text-sm">Name</label>
            <input type="text" name="signature2_name"
                value="{{ old('signature2_name', $template->signature2_name ?? '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label class="block text-sm">Position</label>
            <input type="text" name="signature2_title"
                value="{{ old('signature2_title', $template->signature2_title ?? '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label class="block text-sm">Signature Image</label>
            @if(isset($template) && $template->signature2_image)
                <img src="{{ asset('storage/' . $template->signature2_image) }}"
                    class="h-16 object-contain my-1 border p-1 rounded">
            @endif
            <input type="file" name="signature2_image" class="block w-full text-sm ...">
        </div>
    </div>
    <div class="space-y-4">
        <h3 class="font-semibold text-gray-800">Signature 3</h3>
        <div>
            <label class="block text-sm">Name</label>
            <input type="text" name="signature3_name"
                value="{{ old('signature3_name', $template->signature3_name ?? '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label class="block text-sm">Position</label>
            <input type="text" name="signature3_title"
                value="{{ old('signature3_title', $template->signature3_title ?? '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label class="block text-sm">Signature Image</label>
            @if(isset($template) && $template->signature3_image)
                <img src="{{ asset('storage/' . $template->signature3_image) }}"
                    class="h-16 object-contain my-1 border p-1 rounded">
            @endif
            <input type="file" name="signature3_image" class="block w-full text-sm ...">
        </div>
    </div>
</div>

<!-- <div>
    <label class="block text-lg font-medium text-gray-700">Center Logo (between signatures)</label>
    @if(isset($template) && $template->center_logo)
        <img src="{{ asset('storage/' . $template->center_logo) }}" class="h-16 object-contain my-1 border p-1 rounded">
    @endif
    <input type="file" name="center_logo" class="mt-2 block w-full text-sm ...">
</div> -->
