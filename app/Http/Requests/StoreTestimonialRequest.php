<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna berwenang untuk membuat permintaan ini.
     * Ubah menjadi true jika otentikasi ditangani oleh middleware.
     */
    public function authorize(): bool
    {
        return true; // Ganti dengan logic otorisasi, misal: Auth::check()
    }

    /**
     * Aturan validasi yang berlaku untuk permintaan ini.
     */
    public function rules(): array
    {
        return [
            'author_name' => 'required|string|max:100',
            'role_title' => 'nullable|string|max:100',
            'quote' => 'required|string',
            'avatar_url' => 'nullable|url|max:255',
            'sort_order' => 'sometimes|integer',
            'is_published' => 'sometimes|boolean',
        ];
    }
}