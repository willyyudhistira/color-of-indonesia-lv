<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Tentukan apakah user berwenang membuat request ini.
     */
    public function authorize(): bool
    {
        return true; // Siapapun boleh mencoba login
    }

    /**
     * Aturan validasi yang berlaku.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }
}