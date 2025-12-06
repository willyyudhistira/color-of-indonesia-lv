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
use Maatwebsite\Excel\Validators\ValidationException;
use App\Imports\ParticipantsImport;
use App\Jobs\SendCertificateEmail;


class ParticipantController extends Controller
{
    public function index(Request $request) 
    {
        $query = Participant::with('event')->latest();

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhere('certificate_number', 'like', $searchTerm);
            });
        }

        $participants = $query->paginate(15)->withQueryString();

        $events = Event::orderBy('title')->get();

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

        $validated['certificate_number'] = 'COI-' . $validated['event_id'] . '-' . strtoupper(Str::random(8));

        $participant = Participant::create($validated);

        SendCertificateEmail::dispatch($participant);

        return redirect()->route('admin.participants.index')->with('success', 'Participant has been successfully added and an email notification has been queued.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:event_scheduled,id',
            'excel_file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            Excel::import(new ParticipantsImport($request->event_id), $request->file('excel_file'));
        
        } catch (ValidationException $e) {
            $failures = $e->failures();
            
            $errorMessages = [];
            foreach ($failures as $failure) {
                $attribute = $failure->attribute(); 
                
                $value = '[N/A]'; 
                if (isset($failure->values()[$attribute])) {
                    $value = $failure->values()[$attribute];
                }

                $errorMessages[] = "Line " . $failure->row() . " [" . $attribute . "]: " . 
                                   implode(', ', $failure->errors()) .
                                   " (Value Given: '" . $value . "')";
            }

            return redirect()->back()
                ->with('error', 'Data import failed. There is invalid data in the Excel file.')
                ->withErrors($errorMessages);
        }

        return redirect()->route('admin.participants.index')->with('success', 'Participant data has been successfully imported.');
    }

    public function downloadCertificate(Participant $participant)
    {
        $participant->load('event.certificateTemplate');

        if (!$participant->event || !$participant->event->certificateTemplate) {
            return redirect()->back()->with('error', 'The certificate template for this event has not been set. Unable to download.');
        }

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
        $events = Event::orderBy('title')->get();
        return view('admin.participants.edit', compact('participant', 'events'));
    }

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
        ]);

        $participant->update($validated);

        return redirect()->route('admin.participants.index')->with('success', 'Participant data has been successfully updated.');
    }

    public function printCertificate(Participant $participant)
    {
        if (!$participant->event || !$participant->event->certificateTemplate) {
            return redirect()->back()->with('error', 'The certificate template for this event has not been set. Unable to print.');
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

}