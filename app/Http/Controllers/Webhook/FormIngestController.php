<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Mail\CertificateNotification;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FormIngestController extends Controller
{
    private const HANDSHAKE = 'my_handshake_key';
    private const FIXED_EVENT_ID = 9;

    private const FIELD_CANDIDATES = [
        'name'   => ['text_1', 'name'],
        'email'  => ['email_1', 'email'],
        'ext_id' => ['submission_number', 'id'],
        'purpose'     => ['purpose'],
        'type'        => ['type'],
        'category'    => ['category'],
        'subcategory' => ['subcategory'],
        'group'       => ['group'],
        'notes'       => ['notes'],
    ];

    public function ingest(Request $request)
    {
        $incomingKey = $request->input('handshake_key') ?? $request->header('X-Handshake-Key');
        if (! $incomingKey || ! hash_equals(self::HANDSHAKE, $incomingKey)) {
            return response()->json(['ok' => false, 'error' => 'bad-handshake'], 400);
        }

        $payload = $request->isJson() ? $request->json()->all() : $request->all();

        $name  = $this->pick($payload, self::FIELD_CANDIDATES['name']);
        $email = $this->pick($payload, self::FIELD_CANDIDATES['email']);
        $extId = $this->pick($payload, self::FIELD_CANDIDATES['ext_id']);

        validator(
            ['name' => $name, 'email' => $email],
            ['name' => 'required|string|max:255', 'email' => 'required|email|max:255']
        )->validate();

        $participant = DB::transaction(function () use ($payload, $name, $email, $extId) {
            $eventId = self::FIXED_EVENT_ID;

            $existing = Participant::where(['event_id' => $eventId, 'email' => $email])->first();
            if (! $existing) {
                $cert = $this->generateUniqueCertificate($eventId);

                $data = [
                    'event_id'           => $eventId,
                    'name'               => $name,
                    'email'              => $email,
                    'certificate_number' => $cert,
                    'purpose'            => $this->pick($payload, self::FIELD_CANDIDATES['purpose']),
                    'type'               => $this->pick($payload, self::FIELD_CANDIDATES['type']),
                    'category'           => $this->pick($payload, self::FIELD_CANDIDATES['category']),
                    'subcategory'        => $this->pick($payload, self::FIELD_CANDIDATES['subcategory']),
                    'group'              => $this->pick($payload, self::FIELD_CANDIDATES['group']),
                    'notes'              => $this->pick($payload, self::FIELD_CANDIDATES['notes']),
                ];

                if ($this->schemaHasColumn('participants', 'external_submission_id') && $extId) {
                    $data['external_submission_id'] = substr((string) $extId, 0, 100);
                }

                return Participant::create($data);
            }

            $existing->update([
                'name'        => $name,
                'purpose'     => $this->pick($payload, self::FIELD_CANDIDATES['purpose'], $existing->purpose),
                'type'        => $this->pick($payload, self::FIELD_CANDIDATES['type'], $existing->type),
                'category'    => $this->pick($payload, self::FIELD_CANDIDATES['category'], $existing->category),
                'subcategory' => $this->pick($payload, self::FIELD_CANDIDATES['subcategory'], $existing->subcategory),
                'group'       => $this->pick($payload, self::FIELD_CANDIDATES['group'], $existing->group),
                'notes'       => $this->pick($payload, self::FIELD_CANDIDATES['notes'], $existing->notes),
            ]);

            return $existing;
        });

        Mail::to($participant->email)->queue(new CertificateNotification($participant));

        return response()->json(['ok' => true, 'id' => $participant->id], 200);
    }

    private function pick(array $payload, array $keys, $default = null)
    {
        foreach ($keys as $k) {
            if (array_key_exists($k, $payload) && $payload[$k] !== null && $payload[$k] !== '') {
                return $payload[$k];
            }
        }
        return $default;
    }

    private function generateUniqueCertificate(int $eventId): string
    {
        do {
            $candidate = 'COI-' . $eventId . '-' . strtoupper(Str::random(8));
        } while (Participant::where('certificate_number', $candidate)->exists());

        return $candidate;
    }

    private function schemaHasColumn(string $table, string $column): bool
    {
        try { return \Illuminate\Support\Facades\Schema::hasColumn($table, $column); }
        catch (\Throwable $e) { return false; }
    }
}
