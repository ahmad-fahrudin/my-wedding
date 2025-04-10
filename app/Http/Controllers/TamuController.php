<?php

namespace App\Http\Controllers;

use App\Http\Requests\TamuRequest;
use App\Services\TamuService;
use App\Services\UndanganService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class TamuController extends Controller
{
    protected $tamuService;
    protected $undanganService;

    public function __construct(
        TamuService $tamuService,
        UndanganService $undanganService
    ) {
        $this->tamuService = $tamuService;
        $this->undanganService = $undanganService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['search', 'undangan_id']);
            $tamu = $this->tamuService->getAllTamu($filters);

            return Inertia::render('Tamu/Index', [
                'tamu' => $tamu,
                'filters' => $filters,
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching tamu data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data tamu');
        }
    }

    public function create()
    {
        try {
            $undangan = $this->undanganService->getAllUndangan([]);

            return Inertia::render('Tamu/Create', [
                'undangan' => $undangan
            ]);
        } catch (Exception $e) {
            Log::error('Error loading tamu create form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memuat form tambah tamu');
        }
    }

    public function store(TamuRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->tamuService->createTamu($validated);

            return redirect()->route('tamus.index')->with('success', 'Tamu berhasil ditambahkan');
        } catch (Exception $e) {
            Log::error('Error creating tamu: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan tamu');
        }
    }

    public function edit($id)
    {
        try {
            $tamu = $this->tamuService->getTamu($id);
            $undangan = $this->undanganService->getAllUndangan([]);

            return Inertia::render('Tamu/Edit', [
                'tamu' => $tamu,
                'undangan' => $undangan
            ]);
        } catch (Exception $e) {
            Log::error('Error loading tamu edit form: ' . $e->getMessage());
            return redirect()->route('tamus.index')->with('error', 'Gagal memuat form edit tamu');
        }
    }

    public function update(TamuRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $this->tamuService->updateTamu($id, $validated);

            return redirect()->route('tamus.index')->with('success', 'Tamu berhasil diperbarui');
        } catch (Exception $e) {
            Log::error('Error updating tamu: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui tamu');
        }
    }

    public function destroy($id)
    {
        try {
            $this->tamuService->deleteTamu($id);

            return redirect()->route('tamus.index')->with('success', 'Tamu berhasil dihapus');
        } catch (Exception $e) {
            Log::error('Error deleting tamu: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus tamu');
        }
    }
}
