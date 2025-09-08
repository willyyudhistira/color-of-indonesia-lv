<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Program;

class AboutController extends Controller
{
  public function index()
    {
        // 2. Ambil data dari database, bukan dummy
        // Kondisi: Hanya program yang 'is_published' = true
        // Urutkan berdasarkan 'sort_order'
        $programs = Program::where('is_published', true)
                           ->orderBy('sort_order', 'asc')
                           ->get();

        // 3. Kirim data program dari database ke view
        return view('pages.about', ['programs' => $programs]);
    }
}
