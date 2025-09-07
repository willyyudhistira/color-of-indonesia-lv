<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    // Method ini akan menjadi halaman utama Sponsor Management
    public function index()
    {
        $sponsors = Sponsor::orderBy('name', 'asc')->get();
        $sponsorBanners = SponsorBanner::orderBy('name', 'asc')->get();
        
        return view('admin.sponsors.index', compact('sponsors', 'sponsorBanners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'website_url' => 'nullable|url',
            'logo_url' => 'required|image|max:2048',
        ]);

        $validated['logo_url'] = $request->file('logo_url')->store('sponsor_logos', 'public');
        Sponsor::create($validated);

        return back()->with('success', 'Sponsor (Logo) berhasil ditambahkan.');
    }

    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->logo_url) {
            Storage::disk('public')->delete($sponsor->logo_url);
        }
        $sponsor->delete();

        return back()->with('success', 'Sponsor (Logo) berhasil dihapus.');
    }

    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'website_url' => 'nullable|url',
            'logo_url' => 'nullable|image|max:2048', // Penting: nullable agar tidak wajib saat tidak ada upload baru
        ]);

        // Logika ini yang penting untuk mengganti gambar:
        if ($request->hasFile('logo_url')) {
            // Hapus gambar lama jika ada
            if ($sponsor->logo_url) {
                Storage::disk('public')->delete($sponsor->logo_url);
            }
            // Simpan gambar baru
            $validated['logo_url'] = $request->file('logo_url')->store('sponsor_logos', 'public');
        }
        // Jika tidak ada file baru diunggah, jangan timpa 'logo_url' di $validated
        // agar URL gambar lama tetap ada jika tidak diganti.
        // Jika Anda ingin mengizinkan penghapusan gambar, Anda perlu logika terpisah.

        $sponsor->update($validated);
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor (Logo) berhasil diperbarui.');
    }
}