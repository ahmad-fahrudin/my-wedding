<?php

namespace App\Services;

use App\Models\Undangan;
use App\Repositories\UndanganRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UndanganService
{
    protected $undanganRepository;

    public function __construct(UndanganRepository $undanganRepository)
    {
        $this->undanganRepository = $undanganRepository;
    }

    public function getAllUndangan(array $filters): LengthAwarePaginator
    {
        return $this->undanganRepository->getAllPaginated($filters);
    }

    public function getUndangan(int $id): Undangan
    {
        return $this->undanganRepository->findById($id);
    }

    public function createUndangan(array $data): Undangan
    {
        return $this->undanganRepository->create($data);
    }

    public function updateUndangan($id, array $data): bool
    {
        return $this->undanganRepository->update($id, $data);
    }

    public function deleteUndangan(int $id): bool
    {
        return $this->undanganRepository->delete($id);
    }
}
