<?php

namespace App\Services;

use App\Models\Tamu;
use App\Repositories\TamuRepository;
use App\Repositories\UndanganRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TamuService
{
    protected $tamuRepository;
    protected $undanganRepository;

    public function __construct(
        TamuRepository $tamuRepository,
        UndanganRepository $undanganRepository
    ) {
        $this->tamuRepository = $tamuRepository;
        $this->undanganRepository = $undanganRepository;
    }

    public function getAllTamu(array $filters): LengthAwarePaginator
    {
        return $this->tamuRepository->getAllPaginated($filters);
    }

    /**
     * Get all tamu with filters, returning collection instead of paginated results
     * This is specifically for bulk operations
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithFilter($filters = [])
    {
        return $this->tamuRepository->getAllWithFilters($filters);
    }

    public function getTamu(int $id): Tamu
    {
        return $this->tamuRepository->findById($id);
    }

    public function getTamuById(int $id): Tamu
    {
        return $this->tamuRepository->findById($id);
    }

    public function createTamu(array $data): Tamu
    {
        // Validate undangan_id exists if needed
        if (isset($data['undangan_id'])) {
            $this->undanganRepository->findById($data['undangan_id']);
        }

        return $this->tamuRepository->create($data);
    }

    public function updateTamu(int $id, array $data): bool
    {
        return $this->tamuRepository->update($id, $data);
    }

    public function deleteTamu(int $id): bool
    {
        return $this->tamuRepository->delete($id);
    }

    public function getTamuByUndangan(int $undanganId): array
    {
        $this->undanganRepository->findById($undanganId);

        return $this->tamuRepository->getByUndanganId($undanganId);
    }
}
