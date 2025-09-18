<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'name', 'email', 'certificate_number',
        'purpose', 'type', 'category', 'group'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}