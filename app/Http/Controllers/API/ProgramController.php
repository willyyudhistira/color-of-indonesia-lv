<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use App\Services\ProgramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProgramController extends Controller
{
    public function __construct(private ProgramService $programService)
    {
    }

    // --- Endpoint untuk Publik ---
    public function index(): JsonResponse
    {
        $programs = $this->programService->getAllPrograms(false); // Ambil hanya yang published
        return response()->json($programs);
    }

    // --- Endpoint untuk Admin ---
    public function indexAdmin(): JsonResponse
    {
        $programs = $this->programService->getAllPrograms(true); // Ambil semua data
        return response()->json($programs);
    }

    public function store(StoreProgramRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        
        // Form request tidak bisa memvalidasi file secara langsung ke dalam array, kita tambahkan manual
        if ($request->hasFile('icon_url')) {
            $validatedData['icon_url'] = $request->file('icon_url');
        }

        $program = $this->programService->createProgram($validatedData);
        return response()->json($program, Response::HTTP_CREATED);
    }

    public function show(Program $program): JsonResponse
    {
        return response()->json($program);
    }

    public function update(UpdateProgramRequest $request, Program $program): JsonResponse
    {
        $validatedData = $request->validated();
        
        if ($request->hasFile('icon_url')) {
            $validatedData['icon_url'] = $request->file('icon_url');
        }

        $updatedProgram = $this->programService->updateProgram($program, $validatedData);
        return response()->json($updatedProgram);
    }

    public function destroy(Program $program): Response
    {
        $this->programService->deleteProgram($program);
        return response()->noContent();
    }
}