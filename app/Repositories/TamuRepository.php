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
            ->when(isset($filters['undangan_id']), function ($query) use ($filters) {
                $query->where('undangan_id', $filters['undangan_id']);
            })
            ->with('undangan:id,nama_mempelai_1,nama_mempelai_2')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get all tamu with filters without pagination (for bulk operations)
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithFilters(array $filters = [])
    {
        $query = Tamu::query()->with('undangan');

        if (isset($filters['search']) && !empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('nama_tamu', 'LIKE', '%' . $filters['search'] . '%')
                    ->orWhere('no_wa', 'LIKE', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['undangan_id']) && !empty($filters['undangan_id'])) {
            $query->where('undangan_id', $filters['undangan_id']);
        }

        return $query->get();
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

    public function getByUndanganId(int $undanganId): array
    {
        return Tamu::where('undangan_id', $undanganId)
            ->get()
            ->toArray();
    }
}
