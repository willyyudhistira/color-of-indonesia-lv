<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::orderBy('sort_order', 'asc')->get();
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_published' => $request->has('is_published')]);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'embed_code' => 'required|string',
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean',
        ]);
        Video::create($validated);
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $request->merge(['is_published' => $request->has('is_published')]);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'embed_code' => 'required|string',
            'sort_order' => 'required|integer',
            'is_published' => 'required|boolean',
        ]);
        $video->update($validated);
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus.');
    }
}