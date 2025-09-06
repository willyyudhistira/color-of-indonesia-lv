<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLink extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'excerpt',
        'source_name',
        'source_url',
        'image_url',
        'published_at',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];
}