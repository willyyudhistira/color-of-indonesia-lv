<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorBanner extends Model
{
    use HasFactory;

    protected $table = 'sponsor_banners';

    protected $fillable = [
        'name',
        'image_url',
        'link_url',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];
}