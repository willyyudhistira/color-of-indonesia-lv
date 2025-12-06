<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Participant;
use App\Mail\CertificateNotification;
use Illuminate\Support\Facades\Mail;

class SendCertificateEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $participant;
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(10);
        Mail::to($this->participant->email)->send(new CertificateNotification($this->participant));
        // Logika pengiriman email dipindahkan ke sini
        // Mail::to($this->participant->email)->send(new CertificateNotification($this->participant));
    }
}