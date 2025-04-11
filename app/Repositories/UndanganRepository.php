<?php

namespace App\Repositories;

use App\Models\Undangan;
use Illuminate\Pagination\LengthAwarePaginator;

class UndanganRepository
{
    public function getAllPaginated(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return Undangan::query()
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where('nama_memelai_1', 'like', "%{$filters['search']}%")
                    ->orWhere('nama_memelai_2', 'like', "%{$filters['search']}%");
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

    public function create(array $data): Undangan
    {
        return Undangan::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $undangan = $this->findById($id);
        return $undangan->update($data);
    }

    public function delete(int $id): bool
    {
        $undangan = $this->findById($id);
        return $undangan->delete();
    }
}
