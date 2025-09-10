<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('is_published', true)
                       ->orderBy('sort_order', 'asc')
                       ->paginate(9); // 9 video per halaman

        return view('pages.videos.index', compact('videos'));
    }
}