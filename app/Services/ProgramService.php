<?php

namespace App\Services;

use App\Models\Program;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ProgramService
{
    /**
     * Mengambil data program.
     *
     * @param bool $includeUnpublished Untuk menyertakan data yang tidak di-publish (untuk admin).
     * @return Collection
     */
    public function getAllPrograms(bool $includeUnpublished = false): Collection
    {
        $query = Program::orderBy('sort_order', 'asc');

        if (!$includeUnpublished) {
            $query->where('is_published', true);
        }

        return $query->get();
    }

    /**
     * Membuat program baru.
     *
     * @param array $data Data yang tervalidasi dari request.
     * @return Program
     */
    public function createProgram(array $data): Program
    {
        // Handle file upload jika ada file yang dikirim
        if (isset($data['icon_url']) && $data['icon_url'] !== null) {
            // Simpan file di 'storage/app/public/program_icons' dan simpan path-nya
            $path = $data['icon_url']->store('program_icons', 'public');
            $data['icon_url'] = $path;
        }

        return Program::create($data);
    }

    /**
     * Memperbarui data program.
     *
     * @param Program $program Model program yang akan diupdate.
     * @param array $data Data baru yang tervalidasi.
     * @return Program
     */
    public function updateProgram(Program $program, array $data): Program
    {
        // Handle file upload jika ada file baru
        if (isset($data['icon_url']) && $data['icon_url'] !== null) {
            // Hapus file lama jika ada
            if ($program->icon_url) {
                Storage::disk('public')->delete($program->icon_url);
            }
            // Simpan file baru dan update path-nya
            $path = $data['icon_url']->store('program_icons', 'public');
            $data['icon_url'] = $path;
        }

        $program->update($data);
        return $program;
    }

    /**
     * Menghapus program.
     *
     * @param Program $program Model program yang akan dihapus.
     * @return void
     */
    public function deleteProgram(Program $program): void
    {
        // Hapus file icon dari storage sebelum menghapus record database
        if ($program->icon_url) {
            Storage::disk('public')->delete($program->icon_url);
        }

        $program->delete();
    }
}   