<?php

namespace App\Repositories;

use App\Models\Tamu;
use Illuminate\Pagination\LengthAwarePaginator;

class TamuRepository
{
    public function getAllPaginated(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        return Tamu::query()
            ->when(isset($filters['search']), function ($query) use ($filters) {
                $query->where('nama_tamu', 'like', "%{$filters['search']}%");
            })
            // ->when(isset($filters['undangan_id']), function ($query) use ($filters) {
            //     $query->where('undangan_id', $filters['undangan_id']);
            // })
            // ->with('undangan:id,nama_memelai_1,nama_memelai_2')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function findById(int $id): Tamu
    {
        return Tamu::findOrFail($id);
    }

    public function create(array $data): Tamu
    {
        return Tamu::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $tamu = $this->findById($id);
        return $tamu->update($data);
    }

    public function delete(int $id): bool
    {
        $tamu = $this->findById($id);
        return $tamu->delete();
    }

    // public function getByUndanganId(int $undanganId): array
    // {
    //     return Tamu::where('undangan_id', $undanganId)
    //         ->get()
    //         ->toArray();
    // }
}
