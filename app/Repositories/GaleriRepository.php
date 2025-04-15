<?php

namespace App\Repositories;

use App\Models\Galeri;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class GaleriRepository
{
    public function getAllPaginated(array $filters = []): LengthAwarePaginator
    {
        $query = Galeri::with('undangan');

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->whereHas('undangan', function ($q) use ($search) {
                $q->where('nama_mempelai_1', 'like', "%{$search}%")
                    ->orWhere('nama_mempelai_2', 'like', "%{$search}%");
            });
        }

        if (isset($filters['undangan_id'])) {
            $query->where('undangan_id', $filters['undangan_id']);
        }

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getById($id)
    {
        return Galeri::with('undangan')->findOrFail($id);
    }

    public function getByUndanganAndFilters($undanganId, array $filters = [])
    {
        $query = Galeri::where('undangan_id', $undanganId);

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        return $query->get();
    }

    public function create(array $data)
    {
        $imageBase64 = null;
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $imageContent = file_get_contents($data['image']->getRealPath());
            $imageBase64 = 'data:' . $data['image']->getMimeType() . ';base64,' . base64_encode($imageContent);
        }

        $id = DB::table('galeris')->insertGetId([
            'undangan_id' => $data['undangan_id'],
            'type' => $data['type'] ?? null,
            'category' => $data['category'] ?? null,
            'image' => $imageBase64,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return Galeri::with('undangan')->find($id);
    }

    public function createBatch(array $data, array $images)
    {
        $createdItems = [];

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $imageContent = file_get_contents($image->getRealPath());
                $imageBase64 = 'data:' . $image->getMimeType() . ';base64,' . base64_encode($imageContent);

                $id = DB::table('galeris')->insertGetId([
                    'undangan_id' => $data['undangan_id'],
                    'type' => $data['type'] ?? null,
                    'category' => $data['category'] ?? null,
                    'image' => $imageBase64,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $createdItems[] = Galeri::find($id);
            }
        }

        return $createdItems;
    }

    public function update($id, array $data)
    {
        $galeri = Galeri::findOrFail($id);

        // Prepare update data
        $updateData = [];

        if (isset($data['undangan_id'])) {
            $updateData['undangan_id'] = $data['undangan_id'];
        }

        if (isset($data['type'])) {
            $updateData['type'] = $data['type'];
        }

        if (isset($data['category'])) {
            $updateData['category'] = $data['category'];
        }

        // Handle image if provided
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $imageContent = file_get_contents($data['image']->getRealPath());
            $updateData['image'] = 'data:' . $data['image']->getMimeType() . ';base64,' . base64_encode($imageContent);
        }

        if (!empty($updateData)) {
            $galeri->update($updateData);
        }

        return $galeri->fresh('undangan');
    }

    public function delete($id)
    {
        $galeri = Galeri::findOrFail($id);
        return $galeri->delete();
    }
}
