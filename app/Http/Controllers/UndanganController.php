<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Models\Undangan;
use App\Http\Requests\UndanganRequest;
use App\Services\UndanganService;

class UndanganController extends Controller
{
    protected $undanganService;

    public function __construct(UndanganService $undanganService)
    {
        $this->undanganService = $undanganService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only('search');
            $undangan = $this->undanganService->getAllUndangan($filters);

            return Inertia::render('Undangan/Index', [
                'undangan' => $undangan,
                'filters' => $filters,
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching undangan: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            return Inertia::render('Undangan/Create');
        } catch (Exception $e) {
            Log::error('Error loading undangan create form: ' . $e->getMessage());
            return redirect()->route('undangan.index');
        }
    }

    public function store(UndanganRequest $request)
    {
        try {
            $validated = $request->validated();
            $this->undanganService->createUndangan($validated);

            return redirect()->route('undangans.index')->with('success', 'Undangan created successfully');
        } catch (Exception $e) {
            Log::error('Error creating undangan: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $undangan = $this->undanganService->getUndangan($id);
            return Inertia::render('Undangan/Edit', [
                'undangan' => $undangan
            ]);
        } catch (Exception $e) {
            Log::error('Error loading undangan edit form: ' . $e->getMessage());
            return redirect()->route('undangans.index');
        }
    }

    public function update(UndanganRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $this->undanganService->updateUndangan($id, $validated);

            return redirect()->route('undangans.index');
        } catch (Exception $e) {
            Log::error('Error updating undangan: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $this->undanganService->deleteUndangan($id);

            return redirect()->route('undangans.index');
        } catch (Exception $e) {
            Log::error('Error deleting undangan: ' . $e->getMessage());
            return redirect()->route('undangans.index');
        }
    }
}
