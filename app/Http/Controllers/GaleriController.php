<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\GaleriService;
use App\Enums\GaleriTypeEnum;
use App\Enums\GaleriCategoryEnum;
use App\Services\UndanganService;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\GaleriRequest;

class GaleriController extends Controller
{
    protected $galeriService;
    protected $undanganService;

    public function __construct(GaleriService $galeriService, UndanganService $undanganService)
    {
        $this->galeriService = $galeriService;
        $this->undanganService = $undanganService;
    }

    public function index(Request $request)
    {
        try {
            // Accept all filter parameters from the frontend
            $filters = $request->only(['search', 'type', 'category', 'undangan_id']);
            $galeris = $this->galeriService->getAllPaginated($filters);

            // Get enum values for dropdowns
            $types = collect(GaleriTypeEnum::cases())->map(function ($type) {
                return [
                    'value' => $type->value,
                    'label' => $type->label()
                ];
            });

            $categories = collect(GaleriCategoryEnum::cases())->map(function ($category) {
                return [
                    'value' => $category->value,
                    'label' => $category->label()
                ];
            });

            return Inertia::render('Galeri/Index', [
                'galeris' => $galeris,
                'filters' => $filters,
                'types' => $types,
                'categories' => $categories
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching galeri data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data galeri');
        }
    }

    public function create()
    {
        try {
            $undangans = $this->undanganService->getAllUndangan([]);

            // Get enum values for dropdowns
            $types = collect(GaleriTypeEnum::cases())->map(function ($type) {
                return [
                    'value' => $type->value,
                    'label' => $type->label()
                ];
            });

            $categories = collect(GaleriCategoryEnum::cases())->map(function ($category) {
                return [
                    'value' => $category->value,
                    'label' => $category->label()
                ];
            });

            return Inertia::render('Galeri/Create', [
                'undangans' => $undangans,
                'types' => $types,
                'categories' => $categories
            ]);
        } catch (Exception $e) {
            Log::error('Error loading galeri create form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat form tambah galeri');
        }
    }

    public function store(GaleriRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->galeriService->create($validated);

            return redirect()->route('galeris.index')->with('success', 'Galeri berhasil ditambahkan');
        } catch (Exception $e) {
            Log::error('Error creating galeri: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan galeri');
        }
    }

    public function storeBatch(Request $request)
    {
        $request->validate([
            'undangan_id' => 'required|exists:undangans,id',
            'type' => 'required|string',
            'category' => 'required|string',
            'images' => 'required|array',
            'images.*' => 'required|image|max:2048',
        ]);

        $data = $request->only(['undangan_id', 'type', 'category']);
        $images = $request->file('images');

        try {
            $galeris = $this->galeriService->createBatch($data, $images);
            return response()->json([
                'success' => true,
                'message' => 'Galeri berhasil ditambahkan',
                'data' => $galeris
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan galeri: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $galeri = $this->galeriService->getById($id);
            $undangans = $this->undanganService->getAllUndangan([]);

            // Get enum values for dropdowns
            $types = collect(GaleriTypeEnum::cases())->map(function ($type) {
                return [
                    'value' => $type->value,
                    'label' => $type->label()
                ];
            });

            $categories = collect(GaleriCategoryEnum::cases())->map(function ($category) {
                return [
                    'value' => $category->value,
                    'label' => $category->label()
                ];
            });

            return Inertia::render('Galeri/Edit', [
                'galeri' => $galeri,
                'undangans' => $undangans,
                'types' => $types,
                'categories' => $categories
            ]);
        } catch (Exception $e) {
            Log::error('Error loading galeri edit form: ' . $e->getMessage());
            return redirect()->route('galeris.index')->with('error', 'Gagal memuat form edit galeri');
        }
    }

    public function update(GaleriRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $this->galeriService->update($id, $validated);

            return redirect()->route('galeris.index')->with('success', 'Galeri berhasil diperbarui');
        } catch (Exception $e) {
            Log::error('Error updating galeri: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui galeri');
        }
    }

    public function destroy($id)
    {
        try {
            $this->galeriService->delete($id);

            return redirect()->route('galeris.index')->with('success', 'Galeri berhasil dihapus');
        } catch (Exception $e) {
            Log::error('Error deleting galeri: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus galeri');
        }
    }
}
