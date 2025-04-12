<?php

namespace App\Repositories;

use App\Models\Ucapan;
use Illuminate\Pagination\LengthAwarePaginator;

class UcapanRepository
{
    public function getAllByUndanganId(int $undanganId)
    {
        return Ucapan::where('undangan_id', $undanganId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAllPaginated(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = Ucapan::query();

        if (isset($filters['undangan_id'])) {
            $query->where('undangan_id', $filters['undangan_id']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('ucapan', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): Ucapan
    {
        return Ucapan::findOrFail($id);
    }

    public function create(array $data): Ucapan
    {
        return Ucapan::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $ucapan = Ucapan::findOrFail($id);
        return $ucapan->update($data);
    }

    public function delete(int $id): bool
    {
        $ucapan = Ucapan::findOrFail($id);
        return $ucapan->delete();
    }
}
