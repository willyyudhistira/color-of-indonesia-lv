<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     * Sesuai dengan file migrasi yang kita buat sebelumnya.
     *
     * @var string
     */
    protected $table = 'programs';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini penting untuk keamanan saat menggunakan method create() atau update().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'icon_url',
        'sort_order',
        'is_published',
    ];

    /**
     * Tipe data asli dari atribut.
     * Ini memastikan Laravel secara otomatis mengubah tipe data
     * saat mengambil atau menyimpan data ke database.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean', // Mengubah 1/0 dari database menjadi true/false di PHP
        'sort_order' => 'integer',
    ];
}