<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateNotification;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParticipantsImport;


class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::with('event')->latest()->paginate(15);
        $events = Event::where('is_published', true)->orderBy('title')->get(); // <-- TAMBAHKAN BARIS INI
        
        return view('admin.participants.index', compact('participants', 'events')); // <-- TAMBAHKAN 'events'
    }

    public function create()
    {
        $events = Event::where('is_published', true)->orderBy('title')->get();
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
            'group' => 'nullable|string',
        ]);

        // Generate nomor sertifikat unik
        $validated['certificate_number'] = 'COI-' . $validated['event_id'] . '-' . strtoupper(Str::random(8));

        $participant = Participant::create($validated);

        // Kirim email notifikasi ke peserta
        Mail::to($participant->email)->send(new CertificateNotification($participant));

        return redirect()->route('admin.participants.index')->with('success', 'Peserta berhasil ditambahkan dan notifikasi email telah dikirim.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:event_scheduled,id',
            'excel_file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new ParticipantsImport($request->event_id), $request->file('excel_file'));

        return redirect()->route('admin.participants.index')->with('success', 'Data peserta berhasil diimpor.');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();
        return redirect()->route('admin.participants.index')->with('success', 'Peserta berhasil dihapus.');
    }

    // Metode edit, update, dan destroy bisa Anda tambahkan dengan pola yang sama
}