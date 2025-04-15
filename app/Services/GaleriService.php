<?php

namespace App\Services;

use App\Repositories\GaleriRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GaleriService
{
    protected $galeriRepository;

    public function __construct(GaleriRepository $galeriRepository)
    {
        $this->galeriRepository = $galeriRepository;
    }

    public function getAllPaginated(array $filters = [], int $perPage = 10)
    {
        return $this->galeriRepository->getAllPaginated($filters, $perPage);
    }

    public function getById($id)
    {
        return $this->galeriRepository->getById($id);
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $galeri = $this->galeriRepository->create($data);
            DB::commit();
            return $galeri;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating galeri: ' . $e->getMessage());
            throw $e;
        }
    }

    public function createBatch(array $data, array $images)
    {
        try {
            DB::beginTransaction();
            $galeris = $this->galeriRepository->createBatch($data, $images);
            DB::commit();
            return $galeris;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating batch galeris: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        try {
            DB::beginTransaction();
            $galeri = $this->galeriRepository->update($id, $data);
            DB::commit();
            return $galeri;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating galeri: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $result = $this->galeriRepository->delete($id);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting galeri: ' . $e->getMessage());
            throw $e;
        }
    }
}
