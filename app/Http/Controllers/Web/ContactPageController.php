<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;

class ContactPageController extends Controller
{
    /**
     * Menampilkan halaman kontak.
     */
    public function index()
    {
        return view('pages.contact'); // Akan merujuk ke file contact.blade.php
    }

    /**
     * Menyimpan pesan kontak baru dari formulir.
     */
    public function store(StoreContactMessageRequest $request)
    {
        // Validasi sudah otomatis ditangani oleh StoreContactMessageRequest
        // Jika validasi gagal, Laravel akan otomatis redirect kembali dengan error

        // Buat record baru di database
        ContactMessage::create($request->validated());

        // Redirect kembali ke halaman kontak dengan pesan sukses
        return redirect()->back()->with('success', 'Pesan Anda telah berhasil terkirim! Kami akan segera menghubungi Anda.');
    }
}