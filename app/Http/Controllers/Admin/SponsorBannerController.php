<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SponsorBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorBannerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'link_url' => 'nullable|url',
            'image_url' => 'required|image|max:2048',
        ]);

        $validated['image_url'] = $request->file('image_url')->store('sponsor_banners', 'public');
        SponsorBanner::create($validated);

        return back()->with('success', 'Sponsor (Banner) berhasil ditambahkan.');
    }

    public function destroy(SponsorBanner $sponsorBanner)
    {
        if ($sponsorBanner->image_url) {
            Storage::disk('public')->delete($sponsorBanner->image_url);
        }
        $sponsorBanner->delete();

        return back()->with('success', 'Sponsor (Banner) berhasil dihapus.');
    }

    public function edit(SponsorBanner $sponsorBanner)
    {
        return view('admin.sponsor-banners.edit', compact('sponsorBanner'));
    }

    public function update(Request $request, SponsorBanner $sponsorBanner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'link_url' => 'nullable|url',
            'image_url' => 'nullable|image|max:2048', // Penting: nullable
        ]);

        // Logika ini yang penting untuk mengganti gambar:
        if ($request->hasFile('image_url')) {
            // Hapus gambar lama jika ada
            if ($sponsorBanner->image_url) {
                Storage::disk('public')->delete($sponsorBanner->image_url);
            }
            // Simpan gambar baru
            $validated['image_url'] = $request->file('image_url')->store('sponsor_banners', 'public');
        }
        // Sama seperti di atas, jika tidak ada file baru diunggah, jangan timpa.

        $sponsorBanner->update($validated);
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor (Banner) berhasil diperbarui.');
    }
}