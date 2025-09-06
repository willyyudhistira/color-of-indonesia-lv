<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\HomeService;
use Illuminate\Http\JsonResponse;

class HomePageController extends Controller
{
    public function __construct(private HomeService $homeService)
    {
    }

    /**
     * Endpoint untuk mengambil semua data halaman utama.
     */
    public function index(): JsonResponse
    {
        $data = $this->homeService->fetchHomePageData();
        return response()->json($data);
    }
}