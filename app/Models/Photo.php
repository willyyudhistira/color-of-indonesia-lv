<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    // ... properti fillable & casts
    protected $fillable = [
        'album_id', 'image_url', 'caption', 'sort_order', 'is_published'
    ];
    
    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Mendefinisikan relasi "satu foto milik satu album".
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}