<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * Nama tabel sesuai skema Prisma Anda (setelah diubah ke snake_case).
     */
    protected $table = 'event_scheduled';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'location_name',
        'address',
        'hero_image_url',
        'form_url',
        'is_featured',
        'is_published',
    ];

    /**
     * Casting tipe data untuk kemudahan penggunaan.
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];
}