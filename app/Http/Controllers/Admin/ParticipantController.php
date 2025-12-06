<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\CertificateTemplate;
use App\Mail\CertificateNotification;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParticipantsImport;


class ParticipantController extends Controller
{
    public function index(Request $request)
{
    // 1. Eager load 'event' dan 'certificateTemplate'
    $query = Participant::with(['event', 'certificateTemplate'])->latest();

    // 2. Filter Event (Sudah ada)
    if ($request->filled('event_id')) {
        $query->where('event_id', $request->event_id);
    }

    // 3. Filter Template (BARU)
    if ($request->filled('certificate_template_id')) {
        $query->where('certificate_template_id', $request->certificate_template_id);
    }

    // 4. Search Logic (Sudah ada)
    if ($request->filled('search')) {
        $searchTerm = '%' . $request->search . '%';
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', $searchTerm)
                ->orWhere('email', 'like', $searchTerm)
                ->orWhere('certificate_number', 'like', $searchTerm);
        });
    }

    $participants = $query->paginate(15)->withQueryString();
    
    // Ambil data untuk dropdown
    $events = Event::where('is_published', true)->orderBy('title')->get();
    
    // Ambil data templates untuk dropdown (BARU)
    $templates = CertificateTemplate::orderBy('template_name')->get(); 

    // Jangan lupa kirim 'templates' ke view
    return view('admin.participants.index', compact('participants', 'events', 'templates'));
}

    public function create()
    {
        $events = Event::where('is_published', true)->orderBy('title')->get();
        
        // Ambil data template untuk dropdown
        $templates = CertificateTemplate::orderBy('template_name')->get(); 

        return view('admin.participants.create', compact('events', 'templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'nullable|string|max:20',
            'event_id' => 'required|exists:event_scheduled,id',
            'certificate_template_id' => 'required|exists:certificate_templates,id', // Validasi baru
            'purpose' => 'nullable|string',
            'type' => 'nullable|string',
            'category' => 'nullable|string',
            'subcategory' => 'nullable|string',
            'group' => 'nullable|string',
        ]);

        // Generate nomor sertifikat
        $validated['certificate_number'] = 'COI-' . $validated['event_id'] . '-' . strtoupper(Str::random(8));

        Participant::create($validated);

        return redirect()->route('admin.participants.index')->with('success', 'Participant added successfully with linked certificate.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:event_scheduled,id',
            'certificate_template_id' => 'required|exists:certificate_templates,id', // Harus pilih template saat import
            'excel_file' => 'required|mimes:xlsx,csv'
        ]);

        // Kirim event_id DAN template_id ke Class Import
        Excel::import(new ParticipantsImport($request->event_id, $request->certificate_template_id), $request->file('excel_file'));

        return redirect()->route('admin.participants.index')->with('success', 'Participants imported successfully.');
    }

    public function downloadCertificate(Participant $participant)
    {
        // Load relasi template LANGSUNG dari participant, bukan via event lagi
        $participant->load(['event', 'certificateTemplate']);

        // Cek apakah participant memiliki template
        if (!$participant->certificateTemplate) {
            return redirect()->back()->with('error', 'No certificate template linked to this participant.');
        }

        // Render PDF
        $pdf = Pdf::loadView('certificate.template', [
            'participant' => $participant,
            'is_preview' => false
        ])->setPaper('a4', 'landscape');

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
        $events = Event::where('is_published', true)->orderBy('title')->get();
        $templates = CertificateTemplate::orderBy('template_name')->get(); // Ambil template

        return view('admin.participants.edit', compact('participant', 'events', 'templates'));
    }

    /**
     * Memperbarui data peserta di database.
     */
    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'nullable|string|max:20',
            'event_id' => 'required|exists:event_scheduled,id',
            'certificate_template_id' => 'required|exists:certificate_templates,id', // Validasi baru
            'purpose' => 'nullable|string',
            'type' => 'nullable|string',
            'category' => 'nullable|string',
            'subcategory' => 'nullable|string',
            'group' => 'nullable|string',
        ]);

        $participant->update($validated);

        return redirect()->route('admin.participants.index')->with('success', 'Participant updated successfully.');
    }

    public function printCertificate(Participant $participant)
    {
         // Cek template langsung di participant
        if (!$participant->certificateTemplate) {
            return redirect()->back()->with('error', 'No certificate template linked to this participant.');
        }

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