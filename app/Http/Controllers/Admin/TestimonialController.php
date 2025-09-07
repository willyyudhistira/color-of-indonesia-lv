<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial; // Pastikan model Testimonial sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Menampilkan daftar semua testimoni.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order', 'asc')->get();
        return view('admin.testimonials.index', ['testimonials' => $testimonials]);
    }

    /**
     * Menampilkan form untuk membuat testimoni baru.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Menyimpan testimoni baru.
     */
    public function store(Request $request)
    {
        // ## LANGKAH 1: Ubah nilai checkbox SEBELUM validasi ##
        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'role_title' => 'nullable|string|max:100',
            'quote' => 'required|string',
            'avatar_url' => 'nullable|image|max:2048',
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean', // Diubah dari sometimes menjadi required
        ]);

        if ($request->hasFile('avatar_url')) {
            $validated['avatar_url'] = $request->file('avatar_url')->store('testimonial_avatars', 'public');
        }
        
        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit testimoni.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', ['testimonial' => $testimonial]);
    }

    /**
     * Memperbarui testimoni.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        // ## LANGKAH 1: Ubah nilai checkbox SEBELUM validasi ##
        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'author_name' => 'required|string|max:100',
            'role_title' => 'nullable|string|max:100',
            'quote' => 'required|string',
            'avatar_url' => 'required|image|max:2048', 
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean', // Diubah dari sometimes menjadi required
        ]);

        if ($request->hasFile('avatar_url')) {
            if ($testimonial->avatar_url) {
                Storage::disk('public')->delete($testimonial->avatar_url);
            }
            $validated['avatar_url'] = $request->file('avatar_url')->store('testimonial_avatars', 'public');
        }
        
        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    /**
     * Menghapus testimoni.
     */
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar_url) {
            Storage::disk('public')->delete($testimonial->avatar_url);
        }
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}