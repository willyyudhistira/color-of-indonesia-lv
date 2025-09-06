<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:120',
            'subtitle' => 'nullable|string|max:150',
            'description' => 'sometimes|required|string',
            'icon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ];
    }
    
    protected function prepareForValidation(): void
    {
        if ($this->has('is_published')) {
            $this->merge([
                'is_published' => filter_var($this->is_published, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}