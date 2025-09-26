<?php
namespace App\Mail;
use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificateNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    public function build()
    {
        return $this->subject('Your E-Certificate from Color of Indonesia')
                    ->view('emails.certificate');
    }
}