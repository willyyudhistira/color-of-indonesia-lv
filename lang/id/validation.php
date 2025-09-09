<?php
// lang/id/validation.php

return [
    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi
    |--------------------------------------------------------------------------
    */

    'required' => 'Kolom :attribute wajib diisi.',
    'unique'   => ':attribute ini sudah pernah digunakan.',
    'image'    => ':attribute harus berupa gambar.',
    'mimes'    => ':attribute harus berupa file dengan tipe: :values.',
    'url'      => ':attribute harus berupa URL yang valid.',
    'boolean'  => 'Kolom :attribute harus bernilai benar atau salah.',
    'date'     => ':attribute bukan tanggal yang valid.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    
    'max' => [
        'file'    => ':attribute tidak boleh lebih besar dari :max kilobyte.',
        'string'  => ':attribute tidak boleh lebih dari :max karakter.',
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
    ],
    'min' => [
        'string'  => ':attribute minimal harus :min karakter.',
        'numeric' => ':attribute minimal harus :min.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Atribut Validasi Kustom
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'title'           => 'Judul',
        'excerpt'         => 'Kutipan',
        'source_url'      => 'URL Sumber',
        'password'        => 'Password',
        'email'           => 'Alamat Email',
        'name'            => 'Nama',
        
        'image_url'       => 'Gambar',
        'logo_url'        => 'Logo',
        'avatar_url'      => 'Foto',
        'cover_url'       => 'Gambar Sampul',
        'icon_url'        => 'Ikon',
        'hero_image_url'  => 'Gambar Hero',
        'photo'           => 'Foto',
    ],
];