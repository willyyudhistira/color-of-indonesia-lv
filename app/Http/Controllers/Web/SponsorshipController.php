<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function index()
    {
        // Data dummy untuk paket sponsorship
        $packages = [
            [
                'title' => 'Silver Partner',
                'price' => 'Rp 5.000.000',
                'benefits' => [
                    'Logo di website & media sosial',
                    'Penyebutan nama saat acara',
                    '2 Tiket VIP',
                ],
                'featured' => false,
            ],
            [
                'title' => 'Gold Partner',
                'price' => 'Rp 15.000.000',
                'benefits' => [
                    'Semua keuntungan Silver',
                    'Logo di materi cetak (spanduk)',
                    'Booth promosi ukuran standar',
                    'Ad-libs oleh MC',
                    '5 Tiket VIP',
                ],
                'featured' => true, // Paket ini akan ditandai sebagai "Paling Populer"
            ],
            [
                'title' => 'Platinum Partner',
                'price' => 'Rp 30.000.000',
                'benefits' => [
                    'Semua keuntungan Gold',
                    'Logo di panggung utama',
                    'Slot presentasi singkat',
                    'Booth promosi ukuran premium',
                    '10 Tiket VIP',
                ],
                'featured' => false,
            ],
        ];

        return view('pages.sponsorship', ['packages' => $packages]);
    }
}