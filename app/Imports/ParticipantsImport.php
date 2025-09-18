<?php

namespace App;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ParticipantsImport implements ToModel, WithHeadingRow
{
    private $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    public function model(array $row)
    {
        return new Participant([
            'event_id'           => $this->eventId,
            'name'               => $row['name'],
            'email'              => $row['email'], // Pastikan ada kolom email di Excel Anda
            'certificate_number' => 'COI-' . $this->eventId . '-' . strtoupper(Str::random(8)),
            'purpose'            => $row['purpose'],
            'type'               => $row['type'],
            'category'           => $row['category'],
            'group'              => $row['group'],
        ]);
    }
}