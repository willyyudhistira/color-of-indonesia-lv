<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainEvent extends Model
{
    use HasFactory;

    protected $table = 'main_event';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'location_name',
        'address',
        'hero_image_url',
    ];
}