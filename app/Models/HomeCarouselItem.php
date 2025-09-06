<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCarouselItem extends Model
{
    use HasFactory;

    protected $table = 'home_carousel_items';

    protected $fillable = [
        'image_url',
        'alt_text',
        'link_url',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];
}