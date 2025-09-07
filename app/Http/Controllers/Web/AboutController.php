<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
   public function index()
    {
        // Data dummy untuk section "Program Kami"
        $programs = [
            [
                'title' => 'International Culture Festivals',
                'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80'
            ],
            [
                'title' => 'Cultural Exchange & Delegation',
                'image' => 'https://images.unsplash.com/photo-1511795409837-091a56391d1a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80'
            ],
            [
                'title' => 'Youth & Education Program',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80'
            ],
            [
                'title' => 'Community Empowerment',
                'image' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80'
            ]
        ];

        // Mengirim data $programs ke view
        return view('pages.about', ['programs' => $programs]);
    }
}
