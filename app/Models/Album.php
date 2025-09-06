<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    // ... properti fillable & casts
    protected $fillable = [
        'title', 'description', 'cover_url', 'sort_order', 'is_published'
    ];
    
    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Mendefinisikan relasi "satu album memiliki banyak foto".
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }
}