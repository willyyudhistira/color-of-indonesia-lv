<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;
    
    // Menonaktifkan updated_at karena tidak ada di skema
    public const UPDATED_AT = null;

    protected $table = 'contact';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'status',
    ];
}