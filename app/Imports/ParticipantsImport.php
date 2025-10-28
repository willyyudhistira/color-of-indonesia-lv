<?php

namespace App\Imports;

use App\Models\Participant;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateNotification;
use App\Jobs\SendCertificateEmail;

class ParticipantsImport implements ToModel, WithHeadingRow
{
    private $eventId;

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
        // 1. Mengubah semua kunci header menjadi huruf kecil untuk pencarian yang konsisten.
        $row = array_change_key_case($row, CASE_LOWER);

        // 2. Mencari nilai 'nama' dan 'email' dengan beberapa kemungkinan nama kolom.
        $name = $this->findValue($row, ['nama', 'nama peserta', 'nama lengkap', 'name']);
        $email = $this->findValue($row, ['email', 'email peserta', 'alamat email']);

        // 3. Lewati baris ini jika nama atau email tidak ditemukan.
        // Ini adalah alasan utama mengapa data Anda sebelumnya tidak masuk.
        if (empty($name) || empty($email)) {
            return null; 
        }

        // 4. Buat objek Participant dengan data yang sudah ditemukan.
        $participant = new Participant([
            'name'     => $name,
            'email'    => $email,
            'phone_number' => $this->findValue($row, ['phone number', 'nomor telepon', 'no hp', 'phone', 'phone_number']),
            'purpose'  => $this->findValue($row, ['purpose', 'tujuan']),
            'type'     => $this->findValue($row, ['type', 'tipe']),
            'category' => $this->findValue($row, ['category', 'kategori']),
            'subcategory' => $this->findValue($row, ['subcategory', 'sub kategori']),
            'group'    => $this->findValue($row, ['group', 'grup', 'instansi']),
            'event_id' => $this->eventId,
            'certificate_number' => 'COI-' . $this->eventId . '-' . strtoupper(Str::random(8)),
        ]);

        $participant->save();

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
    private function findValue(array $row, array $keys)
    {
        foreach ($keys as $key) {
            // Menghapus spasi dan mengubah ke huruf kecil untuk mencocokkan
            $formattedKey = str_replace(' ', '_', trim(strtolower($key)));
            if (isset($row[$formattedKey])) {
                return $row[$formattedKey];
            }
        }
        return null;
    }
}