<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    // ... properti fillable & casts
    use HasFactory;

    protected $table = 'albums';
    
    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_url',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Mendefinisikan relasi "satu album memiliki banyak foto".
     */
    public function photos(): HasMany // Sekarang PHP tahu ini adalah Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Photo::class);
    }
}