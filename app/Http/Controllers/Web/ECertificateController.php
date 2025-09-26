<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ECertificateController extends Controller
{
    public function index() { return view('pages.e-certificate'); }

    public function generate(Request $request)
    {
        $request->validate(['certificate_number' => 'required|string']);
        
        // Memuat relasi event DAN relasi template di dalam event
        $participant = Participant::with('event.certificateTemplate')
            ->where('certificate_number', $request->certificate_number)
            ->first();

        // Cek jika peserta tidak ditemukan ATAU event-nya tidak memiliki template
        if (!$participant || !$participant->event->certificateTemplate) {
            return back()->with('error', 'The certificate number is invalid or the template for this event has not been set.');
        }

        $pdf = Pdf::loadView('certificate.template', compact('participant'))
              ->setPaper('a4', 'landscape');
        return $pdf->stream('sertifikat-' . Str::slug($participant->name) . '.pdf');
    }

    public function preview(Event $event)
    {
        if (!$event->certificateTemplate) {
            // Arahkan ke halaman edit template jika masih kosong
            return redirect()->route('admin.events.template.edit', $event)
                             ->with('warning', 'The template for this event has not been set. Please complete it first.');
        }
        // 1. Buat data dummy untuk ditampilkan di pratinjau
        $dummyEvent = new Event([
            'title' => 'Indonesian Traditional Dance Competition',
            'start_date' => now(),
        ]);

        $dummyParticipant = new Participant([
            'name' => 'Andriawan',
            'email' => 'contoh@email.com',
            'certificate_number' => 'COI-DUMMY-12345678',
            'purpose' => 'Winner',
            'type' => 'Original Folklore Group Dance',
            'category' => 'Dewasa',
            'subcategory' => 'Tari Tradisional',
            'group' => 'Universitas Pakuan',
        ]);
        
        // 2. Hubungkan event dummy ke peserta dummy
        $dummyParticipant->setRelation('event', $event);

        // 3. Tampilkan view Blade seperti halaman web biasa
        return view('pages.certificate-preview', [
            'participant' => $dummyParticipant,
            'is_preview' => true
        ]);
    }

    public function verify($certificate_number)
    {
        // Cari peserta di database berdasarkan nomor sertifikat dari URL
        $participant = Participant::with('event')
            ->where('certificate_number', $certificate_number)
            ->first();

        // Kirim data peserta (atau null jika tidak ditemukan) ke view verifikasi
        return view('pages.certificate-verify', compact('participant'));
    }

    public function downloadPreview($participantId)
    {
        $participant = Participant::with('event')->findOrFail($participantId);

        $pdf = Pdf::loadView('certificate.template', [
            'participant' => $participant,
            'is_preview' => false
        ])->setPaper('A4', 'landscape'); // bisa disesuaikan ukuran kertas

        $fileName = 'Sertifikat_' . $participant->name . '.pdf';

        return $pdf->download($fileName);
    }
}