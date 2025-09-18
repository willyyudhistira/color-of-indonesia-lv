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
        $participant = Participant::with('event')->where('certificate_number', $request->certificate_number)->first();

        if (!$participant) {
            return back()->with('error', 'Nomor sertifikat tidak ditemukan.');
        }

        $pdf = Pdf::loadView('certificate.template', compact('participant'))->setPaper('a4', 'landscape');
        return $pdf->stream('sertifikat-' . Str::slug($participant->name) . '.pdf');
        
    }

    public function preview()
    {
        // 1. Buat data dummy untuk ditampilkan di pratinjau
        $dummyEvent = new Event([
            'title' => 'International Ta\'aruf Kota Bogor 2025',
            'start_date' => now(),
        ]);

        $dummyParticipant = new Participant([
            'name' => 'Andriawan',
            'email' => 'contoh@email.com',
            'certificate_number' => 'COI-DUMMY-12345678',
            'purpose' => 'Winner',
            'type' => 'Original Folklore Group Dance',
            'category' => 'Dewasa',
            'group' => 'Universitas Pakuan',
        ]);
        
        // 2. Hubungkan event dummy ke peserta dummy
        $dummyParticipant->setRelation('event', $dummyEvent);

        // 3. Tampilkan view Blade seperti halaman web biasa
        return view('certificate.template', [
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
}