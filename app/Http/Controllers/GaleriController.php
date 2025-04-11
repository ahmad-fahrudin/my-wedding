<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\GaleriService;
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $filters = $request->only(['undangan_id']);
            $galeris = $this->galeriService->getAllPaginated($filters);

            return Inertia::render('Galeri/Index', [
                'galeris' => $galeris,
                'filters' => $filters,
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

            return Inertia::render('Galeri/Create', [
                'undangans' => $undangans
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

    public function edit($id)
    {
        try {
            $galeri = $this->galeriService->getById($id);
            $undangans = $this->undanganService->getAllUndangan([]);

            return Inertia::render('Galeri/Edit', [
                'galeri' => $galeri,
                'undangans' => $undangans
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
