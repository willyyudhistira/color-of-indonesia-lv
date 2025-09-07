<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna berwenang membuat request ini.
     */
    public function authorize(): bool
    {
        return true; // Siapapun boleh mengirim pesan kontak
    }

    /**
     * Aturan validasi yang berlaku untuk request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:120',
            'phone' => 'nullable|string|max:30', // 'subject' tidak ada di model, saya ganti dengan 'phone'
            'message' => 'required|string|max:5000',
        ];
    }
}