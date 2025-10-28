<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateNotification;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParticipantsImport;


class ParticipantController extends Controller
{
    public function index(Request $request) // <-- Tambahkan Request $request
    {
        // Memulai query dasar untuk peserta dengan relasi event
        $query = Participant::with('event')->latest();

        // 1. Terapkan filter berdasarkan Event jika ada
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // 2. Terapkan filter pencarian (search) jika ada
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('certificate_number', 'like', $searchTerm);
            });
        }

        // Eksekusi query dengan paginasi
        $participants = $query->paginate(15)->withQueryString();

        // Ambil data events untuk dropdown filter
        $events = Event::orderBy('title')->get();

        // Kirim data ke view
        return view('admin.participants.index', compact('participants', 'events'));
    }

    public function create()
    {
        $events = Event::orderBy('title')->get();
        return view('admin.participants.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'event_id' => 'required|exists:event_scheduled,id',
            'purpose' => 'nullable|string',
            'type' => 'nullable|string',
            'category' => 'nullable|string',
            'subcategory' => 'nullable|string',
            'group' => 'nullable|string',
        ]);

        // Generate nomor sertifikat unik
        $validated['certificate_number'] = 'COI-' . $validated['event_id'] . '-' . strtoupper(Str::random(8));

        $participant = Participant::create($validated);

        // Kirim email notifikasi ke peserta
        Mail::to($participant->email)->send(new CertificateNotification($participant));

        return redirect()->route('admin.participants.index')->with('success', 'Participant has been successfully added and an email notification has been sent.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:event_scheduled,id',
            'excel_file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new ParticipantsImport($request->event_id), $request->file('excel_file'));

        return redirect()->route('admin.participants.index')->with('success', 'Participant data has been successfully imported.');
    }

    public function downloadCertificate(Participant $participant)
    {
        // Memuat relasi event dan template sertifikatnya
        $participant->load('event.certificateTemplate');

        // Cek jika peserta tidak ada ATAU event-nya tidak memiliki template
        if (!$participant->event || !$participant->event->certificateTemplate) {
            return redirect()->back()->with('error', 'The certificate template for this event has not been set. Unable to download.');
        }

        // Render PDF menggunakan view 'certificate.template'
        $pdf = Pdf::loadView('certificate.template', [
            'participant' => $participant,
            'is_preview' => false // Penting agar DomPDF menggunakan path file lokal
        ])->setPaper('a4', 'landscape');

        // Buat nama file yang akan diunduh
        $fileName = 'sertifikat-' . Str::slug($participant->name) . '.pdf';

        return $pdf->download($fileName);
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();
        return redirect()->route('admin.participants.index')->with('success', 'Participant has been successfully deleted.');
    }

    public function edit(Participant $participant)
    {
        // Ambil data semua event untuk ditampilkan di dropdown
        $events = Event::orderBy('title')->get();
        return view('admin.participants.edit', compact('participant', 'events'));
    }

    /**
     * Memperbarui data peserta di database.
     */
    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'event_id' => 'required|exists:event_scheduled,id',
            'purpose' => 'nullable|string',
            'type' => 'nullable|string',
            'category' => 'nullable|string',
            'subcategory' => 'nullable|string',
            'group' => 'nullable|string',
            // Kita tidak memvalidasi certificate_number karena tidak diubah di sini
        ]);

        $participant->update($validated);

        return redirect()->route('admin.participants.index')->with('success', 'Participant data has been successfully updated.');
    }

    public function printCertificate(Participant $participant)
    {
        // Cek jika event atau template tidak ada (sama seperti fungsi download)
        if (!$participant->event || !$participant->event->certificateTemplate) {
            return redirect()->back()->with('error', 'The certificate template for this event has not been set. Unable to print.');
        }

        // Tampilkan view khusus untuk print
        return view('admin.participants.print', compact('participant'));
    }

    public function updateNote(Request $request, Participant $participant)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $participant->update([
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Note for the participant has been successfully saved.');
    }

    // Metode edit, update, dan destroy bisa Anda tambahkan dengan pola yang sama
}