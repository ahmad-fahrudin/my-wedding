<?php

namespace App\Repositories;

use App\Models\Undangan;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

class UndanganRepository
{
    public function getAllPaginated(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return Undangan::query()
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where('nama_mempelai_1', 'like', "%{$filters['search']}%")
                    ->orWhere('nama_mempelai_2', 'like', "%{$filters['search']}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function getAll()
    {
        return Undangan::all();
    }

    public function findById(int $id): Undangan
    {
        return Undangan::findOrFail($id);
    }

    public function createWithContent(array $undanganData, array $contentData): Undangan
    {
        return DB::transaction(function () use ($undanganData, $contentData) {
            // Process music file if exists
            if (isset($contentData['music']) && $contentData['music'] instanceof UploadedFile) {
                $contentData['music'] = $this->convertMusicToBase64($contentData['music']);
            }

            // Create the undangan
            $undangan = Undangan::create($undanganData);

            // Create the undangan content associated with the undangan
            $undangan->content()->create($contentData);

            // Load the relationship so it's available in the returned object
            $undangan->load('content');

            return $undangan;
        });
    }

    public function updateWithContent(int $id, array $undanganData, array $contentData): bool
    {
        return DB::transaction(function () use ($id, $undanganData, $contentData) {
            // Get the undangan
            $undangan = $this->findById($id);

            // Update undangan data
            $undanganUpdated = $undangan->update($undanganData);

            // Process music file if exists
            if (isset($contentData['music'])) {
                if ($contentData['music'] instanceof UploadedFile) {
                    // If it's a file, convert to base64
                    $contentData['music_filename'] = $contentData['music']->getClientOriginalName();
                    $contentData['music'] = $this->convertMusicToBase64($contentData['music']);
                } elseif ($contentData['music'] === null) {
                    // If music is null (meaning user wants to remove it), clear both fields
                    $contentData['music'] = null;
                    $contentData['music_filename'] = null;
                }
            }

            // Update or create undangan content
            if ($undangan->content) {
                $contentUpdated = $undangan->content->update($contentData);
            } else {
                $contentCreated = $undangan->content()->create($contentData);
                $contentUpdated = (bool)$contentCreated;
            }

            // Return true if both operations were successful
            return $undanganUpdated && $contentUpdated;
        });
    }

    /**
     * Convert music file to base64 string
     *
     * @param UploadedFile $file
     * @return string
     */
    private function convertMusicToBase64(UploadedFile $file): string
    {
        $fileContent = file_get_contents($file->getPathname());
        $mimeType = $file->getMimeType();
        $base64 = base64_encode($fileContent);

        return "data:{$mimeType};base64,{$base64}";
    }

    public function delete(int $id): bool
    {
        $undangan = $this->findById($id);
        return $undangan->delete();
    }
}
