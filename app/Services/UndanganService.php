<?php

namespace App\Services;

use App\Models\Undangan;
use App\Repositories\UndanganRepository;
use App\Repositories\UcapanRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UndanganService
{
    protected $undanganRepository;
    protected $ucapanRepository;

    public function __construct(
        UndanganRepository $undanganRepository,
        UcapanRepository $ucapanRepository
    ) {
        $this->undanganRepository = $undanganRepository;
        $this->ucapanRepository = $ucapanRepository;
    }

    public function getAllUndangan(array $filters): LengthAwarePaginator
    {
        return $this->undanganRepository->getAllPaginated($filters);
    }

    public function getUndangan(int $id): Undangan
    {
        // Get undangan with content relationship
        $undangan = Undangan::with('content')->findOrFail($id);

        // Restructure the data to match what the frontend expects
        if ($undangan->content) {
            // Make content properties directly accessible in the undangan object
            $undangan->content->makeHidden(['id', 'undangan_id', 'created_at', 'updated_at']);
        } else {
            // If no content exists yet, create an empty content object
            $undangan->content = new \stdClass();
        }

        return $undangan;
    }

    public function createUndanganWithContent(array $undanganData, array $contentData): Undangan
    {
        return $this->undanganRepository->createWithContent($undanganData, $contentData);
    }

    public function updateUndanganWithContent(int $id, array $undanganData, array $contentData): bool
    {
        DB::beginTransaction();

        try {
            // Update main undangan data
            $undangan = Undangan::findOrFail($id);
            $undangan->update($undanganData);

            // Update or create content data
            if (!empty($contentData)) {
                // Handle the music file situation
                $keepExistingMusic = isset($contentData['keep_existing_music']) && $contentData['keep_existing_music'];

                if ($keepExistingMusic) {
                    // If keeping existing music, remove this flag from data to be saved
                    unset($contentData['keep_existing_music']);

                    // And remove music field to prevent overwriting
                    if (isset($contentData['music'])) {
                        unset($contentData['music']);
                    }
                }

                $undangan->content()->updateOrCreate(
                    ['undangan_id' => $undangan->id],
                    $contentData
                );
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating undangan with content: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteUndangan(int $id): bool
    {
        return $this->undanganRepository->delete($id);
    }

    // New methods for ucapan
    public function saveUcapan(array $data)
    {
        return $this->ucapanRepository->create($data);
    }

    public function getUcapanByUndanganId(int $undanganId)
    {
        return $this->ucapanRepository->getAllByUndanganId($undanganId);
    }

    public function getAllUcapan(array $filters)
    {
        return $this->ucapanRepository->getAllPaginated($filters);
    }

    public function deleteUcapan(int $id): bool
    {
        return $this->ucapanRepository->delete($id);
    }
}
