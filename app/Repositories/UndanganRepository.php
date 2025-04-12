<?php

namespace App\Repositories;

use App\Models\Undangan;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

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
            // Create the undangan
            $undangan = Undangan::create($undanganData);

            // Create the undangan content associated with the undangan
            $undangan->undanganContent()->create($contentData);

            // Load the relationship so it's available in the returned object
            $undangan->load('undanganContent');

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

            // Update or create undangan content
            if ($undangan->undanganContent) {
                $contentUpdated = $undangan->undanganContent->update($contentData);
            } else {
                $contentCreated = $undangan->undanganContent()->create($contentData);
                $contentUpdated = (bool)$contentCreated;
            }

            // Return true if both operations were successful
            return $undanganUpdated && $contentUpdated;
        });
    }

    public function delete(int $id): bool
    {
        $undangan = $this->findById($id);
        return $undangan->delete();
    }
}
