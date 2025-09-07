<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program; // Pastikan model Program sudah ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    /**
     * Menampilkan daftar semua program.
     */
    public function index()
    {
        $programs = Program::orderBy('sort_order', 'asc')->get();
        return view('admin.programs.index', ['programs' => $programs]);
    }

    /**
     * Menampilkan form untuk membuat program baru.
     */
    public function create()
    {
        return view('admin.programs.create');
    }

    /**
     * Menyimpan program baru ke database.
     */
    public function store(Request $request)
    {
        // ## TAMBAHKAN BARIS INI ##
        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'subtitle' => 'nullable|string|max:150',
            'description' => 'required|string',
            'icon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean', // Diubah menjadi required
        ]);

        if ($request->hasFile('icon_url')) {
            $validated['icon_url'] = $request->file('icon_url')->store('program_icons', 'public');
        }

        Program::create($validated);
        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit program.
     */
    public function edit(Program $program)
    {
        return view('admin.programs.edit', ['program' => $program]);
    }

    /**
     * Memperbarui program di database.
     */
    public function update(Request $request, Program $program)
    {
        // ## TAMBAHKAN BARIS INI JUGA ##
        $request->merge([
            'is_published' => $request->has('is_published'),
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'subtitle' => 'nullable|string|max:150',
            'description' => 'required|string',
            'icon_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean', // Diubah menjadi required
        ]);

        if ($request->hasFile('icon_url')) {
            if ($program->icon_url) {
                Storage::disk('public')->delete($program->icon_url);
            }
            $validated['icon_url'] = $request->file('icon_url')->store('program_icons', 'public');
        }
        
        $program->update($validated);
        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui.');
    }

    /**
     * Menghapus program dari database.
     */
    public function destroy(Program $program)
    {
        if ($program->icon_url) {
            Storage::disk('public')->delete($program->icon_url);
        }
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }
}