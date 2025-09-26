<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    use HasFactory;
    protected $table = 'certificate_templates';
    protected $fillable = [
        'template_name',
        'main_title',
        'background_image',
        'logo1',
        'logo2',
        'logo3',
        'logo4',
        'logo5',
        'logo6',
        'logo7',
        'signature1_image',
        'signature1_name',
        'signature1_title',
        'signature2_image',
        'signature2_name',
        'signature2_title',
        'signature3_name',
        'signature3_title',
        'signature3_image',
        'body_text',
        'center_logo',
        'winner_text',
        'supporting_text',
        'participant_text',
        'background_image_path'
    ]; // Mengizinkan semua kolom diisi
}