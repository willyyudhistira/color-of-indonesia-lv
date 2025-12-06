<?php

namespace App\Imports;

use App\Models\Participant;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateNotification;
use App\Jobs\SendCertificateEmail;

class ParticipantsImport implements ToModel, WithHeadingRow, WithValidation
{
    private $eventId;
    // private $rowCount = 0;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * Fungsi utama yang akan dijalankan untuk setiap baris di Excel.
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // // 1. Mengubah semua kunci header menjadi huruf kecil untuk pencarian yang konsisten.
        // $row = array_change_key_case($row, CASE_LOWER);

        // // 2. Mencari nilai 'nama' dan 'email' dengan beberapa kemungkinan nama kolom.
        // $name = $this->findValue($row, ['nama', 'nama peserta', 'nama lengkap', 'name']);
        // $email = $this->findValue($row, ['email', 'email peserta', 'alamat email']);

        // // 3. Lewati baris ini jika nama atau email tidak ditemukan.
        // // Ini adalah alasan utama mengapa data Anda sebelumnya tidak masuk.
        // if (empty($name) || empty($email)) {
        //     return null; 
        // }

        // 4. Buat objek Participant dengan data yang sudah ditemukan.
        $participant = new Participant([
            'name'         => $row['name'], // Harus ada header 'nama'
            'email'        => $row['email'], // Harus ada header 'email'
            'purpose'      => $row['purpose'] ?? null,
            'type'         => $row['type'] ?? null,
            'category'     => $row['category'] ?? null,
            'subcategory'  => $row['subcategory'] ?? null,
            'group'        => $row['group'] ?? null,
            'phone_number' => $row['phone_number'] ?? null, // Ganti 'nomor_telepon'
            'event_id'     => $this->eventId,
            'certificate_number' => 'COI-' . $this->eventId . '-' . strtoupper(Str::random(8)),
        ]);

        $participant->save();

        // $delayInSeconds = ($this->rowCount + 1) * 3;
        // SendCertificateEmail::dispatch($participant)->delay(now()->addSeconds($delayInSeconds));

        SendCertificateEmail::dispatch($participant);

        return $participant;
    }

    /**
     * Fungsi bantuan untuk mencari nilai dalam sebuah baris berdasarkan beberapa kemungkinan kunci.
     *
     * @param array $row Baris data dari Excel.
     * @param array $keys Daftar kemungkinan nama kolom (dalam huruf kecil).
     * @return mixed|null Nilai yang ditemukan atau null jika tidak ada.
     */
    // private function findValue(array $row, array $keys)
    // {
    //     foreach ($keys as $key) {
    //         // Menghapus spasi dan mengubah ke huruf kecil untuk mencocokkan
    //         $formattedKey = str_replace(' ', '_', trim(strtolower($key)));
    //         if (isset($row[$formattedKey])) {
    //             return $row[$formattedKey];
    //         }
    //     }
    //     return null;
    // }

    public function rules(): array
    {
        // 'nama', 'email' harus sesuai dengan nama header di file Excel Anda
        return [
            'name' => 'required|string|max:255',
            
            'email' => 'required|email|unique:participants,email', // Cek unik
            
            // Buat aturan untuk kolom lain (bisa nullable)
            'purpose'      => 'nullable|string',
            'type'         => 'nullable|string',
            'category'     => 'nullable|string',
            'subcategory'  => 'nullable|string',
            'group'        => 'nullable|string',
            'phone_number' => 'nullable|string|max:20', // Sesuaikan
        ];
    }
}