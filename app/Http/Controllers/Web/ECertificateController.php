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
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');
        $eventId = $request->input('event_id');

        // 1. Mulai query dasar
        $query = Participant::query()
            ->with('event'); // Selalu muat relasi event
            // ->whereHas('event.certificateTemplate'); // Pastikan event punya template

        // 2. Terapkan filter event jika ada
        $query->when($eventId, function ($q, $eventId) {
            return $q->where('event_id', $eventId);
        });

        // 3. Terapkan filter pencarian jika ada
        $query->when($searchQuery, function ($q, $searchQuery) {
            return $q->where(function ($subQ) use ($searchQuery) {
                $subQ->where('name', 'LIKE', "%{$searchQuery}%")
                     ->orWhere('certificate_number', 'LIKE', "%{$searchQuery}%");
            });
        });

        // 4. Ambil data dengan paginasi
        $participants = $query->orderBy('name')->paginate(10);

        // ===================================================================
        // PERUBAHAN DI SINI (LANGKAH 5)
        // ===================================================================
        // 5. Ambil semua event untuk dropdown filter (TANPA MENGUBAH MODEL)

        // 5a. Ambil dulu semua ID event unik yang ada di tabel participants
        $eventIdsWithParticipants = Participant::select('event_id')
                                                ->distinct()
                                                ->pluck('event_id');

        // 5b. Sekarang, ambil data Event berdasarkan ID tersebut DAN yang memiliki template
        $events = Event::whereIn('id', $eventIdsWithParticipants)
                    //    ->whereHas('certificateTemplate') // <-- Relasi ini sepertinya sudah ada & aman
                       ->orderBy('title')
                       ->get();
        // ===================================================================
        // AKHIR PERUBAHAN
        // ===================================================================

        return view('pages.e-certificate', compact('participants', 'events'));
    }

    public function download(Participant $participant)
    {
        // (Metode ini tetap sama dari langkah kita sebelumnya)
        $participant->load('event.certificateTemplate');

        if (!$participant->event || !$participant->event->certificateTemplate) {
            return redirect()->route('e-certificate.index')->with('error', 'Certificate cannot be generated. Template is missing.');
        }

        $pdf = Pdf::loadView('certificate.template', [
                'participant' => $participant,
                'is_preview' => false
            ])
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

    // public function preview(Event $event)
    // {
    //     if (!$event->certificateTemplate) {
    //         // Arahkan ke halaman edit template jika masih kosong
    //         return redirect()->route('admin.events.template.edit', $event)
    //                          ->with('warning', 'The template for this event has not been set. Please complete it first.');
    //     }
    //     // 1. Buat data dummy untuk ditampilkan di pratinjau
    //     $dummyEvent = new Event([
    //         'title' => 'Indonesian Traditional Dance Competition',
    //         'start_date' => now(),
    //     ]);

    //     $dummyParticipant = new Participant([
    //         'name' => 'Andriawan',
    //         'email' => 'contoh@email.com',
    //         'certificate_number' => 'COI-DUMMY-12345678',
    //         'purpose' => 'Winner',
    //         'type' => 'Original Folklore Group Dance',
    //         'category' => 'Dewasa',
    //         'subcategory' => 'Tari Tradisional',
    //         'group' => 'Universitas Pakuan',
    //     ]);
        
    //     // 2. Hubungkan event dummy ke peserta dummy
    //     $dummyParticipant->setRelation('event', $event);

    //     // 3. Tampilkan view Blade seperti halaman web biasa
    //     return view('pages.certificate-preview', [
    //         'participant' => $dummyParticipant,
    //         'is_preview' => true
    //     ]);
    // }

    // public function verify($certificate_number)
    // {
    //     // Cari peserta di database berdasarkan nomor sertifikat dari URL
    //     $participant = Participant::with('event')
    //         ->where('certificate_number', $certificate_number)
    //         ->first();

    //     // Kirim data peserta (atau null jika tidak ditemukan) ke view verifikasi
    //     return view('pages.certificate-verify', compact('participant'));
    // }

    // public function downloadPreview($participantId)
    // {
    //     $participant = Participant::with('event')->findOrFail($participantId);

    //     $pdf = Pdf::loadView('certificate.template', [
    //         'participant' => $participant,
    //         'is_preview' => false
    //     ])->setPaper('A4', 'landscape'); // bisa disesuaikan ukuran kertas

    //     $fileName = 'Sertifikat_' . $participant->name . '.pdf';

    //     return $pdf->download($fileName);
    // }
}