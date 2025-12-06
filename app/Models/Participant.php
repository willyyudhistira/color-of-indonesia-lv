<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'name', 'email', 'certificate_number',
        'certificate_template_id',
        'purpose', 'type', 'category', 'group', 'subcategory', 'notes', 'phone_number',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function certificateTemplate()
    {
        return $this->belongsTo(CertificateTemplate::class, 'certificate_template_id');
    }
}