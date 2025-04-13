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

            // Separate data for Undangan
            $undanganData = [
                'nama_mempelai_1' => $validated['nama_mempelai_1'],
                'nama_mempelai_2' => $validated['nama_mempelai_2'],
                'tanggal_acara' => $validated['tanggal_acara'],
                'waktu_acara' => $validated['waktu_acara'],
                'tempat' => $validated['tempat'],
                'url_maps' => $validated['url_maps'],
                'rekening' => $validated['rekening'] ?? null,
            ];

            // Separate data for UndanganContent
            $contentData = array_filter([
                'description_mempelai_1' => $validated['description_mempelai_1'] ?? null,
                'description_mempelai_2' => $validated['description_mempelai_2'] ?? null,
                'story_1' => $validated['story_1'] ?? null,
                'story_2' => $validated['story_2'] ?? null,
                'story_3' => $validated['story_3'] ?? null,
                'tgl_story_1' => $validated['tgl_story_1'] ?? null,
                'tgl_story_2' => $validated['tgl_story_2'] ?? null,
                'tgl_story_3' => $validated['tgl_story_3'] ?? null,
            ]);

            // Handle music file separately
            if ($request->hasFile('music') && $request->file('music')->isValid()) {
                $contentData['music'] = $request->file('music');
            }

            $this->undanganService->createUndanganWithContent($undanganData, $contentData);

            return redirect()->route('undangans.index')->with('success', 'Undangan created successfully');
        } catch (Exception $e) {
            Log::error('Error creating undangan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create undangan');
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

            // Separate data for Undangan
            $undanganData = [
                'nama_mempelai_1' => $validated['nama_mempelai_1'],
                'nama_mempelai_2' => $validated['nama_mempelai_2'],
                'tanggal_acara' => $validated['tanggal_acara'],
                'waktu_acara' => $validated['waktu_acara'],
                'tempat' => $validated['tempat'],
                'url_maps' => $validated['url_maps'],
                'rekening' => $validated['rekening'] ?? null,
            ];

            // Separate data for UndanganContent
            $contentData = array_filter([
                'description_mempelai_1' => $validated['description_mempelai_1'] ?? null,
                'description_mempelai_2' => $validated['description_mempelai_2'] ?? null,
                'story_1' => $validated['story_1'] ?? null,
                'story_2' => $validated['story_2'] ?? null,
                'story_3' => $validated['story_3'] ?? null,
                'tgl_story_1' => $validated['tgl_story_1'] ?? null,
                'tgl_story_2' => $validated['tgl_story_2'] ?? null,
                'tgl_story_3' => $validated['tgl_story_3'] ?? null,
            ]);

            // Handle music file separately
            if ($request->hasFile('music') && $request->file('music')->isValid()) {
                $contentData['music'] = $request->file('music');
            } else if ($validated['keep_existing_music'] ?? false) {
                // Keep existing music (don't update music field)
                $contentData['keep_existing_music'] = true;
            } else {
                // Clear music if neither new file nor keep existing is specified
                $contentData['music'] = null;
            }

            $this->undanganService->updateUndanganWithContent($id, $undanganData, $contentData);

            return redirect()->route('undangans.index')->with('success', 'Undangan updated successfully');
        } catch (Exception $e) {
            Log::error('Error updating undangan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update undangan');
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

    public function content()
    {
        $undangans = $this->undanganService->getAllUndangan([]);

        return Inertia::render('Content/Index', [
            'undangans' => $undangans
        ]);
    }

    public function contentStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'undangan_id' => 'required|exists:undangans,id',
                'tema' => 'required|string|in:tema1,tema2',
            ]);

            return redirect()->back();
        } catch (Exception $e) {
            Log::error('Error storing content preferences: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menampilkan preview undangan');
        }
    }

    public function preview($undangan_id = null, $tema = null)
    {
        try {
            // Use either the URL parameters or the session values
            $undangan_id = $undangan_id ?? session('preview_undangan_id');
            $tema = $tema ?? session('preview_tema', 'tema1');

            $undangan = null;
            $galeri = [];
            $ucapan = [];

            if ($undangan_id) {
                // Get undangan data with relations
                $undangan = Undangan::with([
                    'galeri' => function ($query) {
                        // Ensure we're ordering galeri by category for better grouping
                        $query->orderBy('category', 'asc');
                    },
                    'ucapan' => function ($query) {
                        $query->orderBy('created_at', 'desc')->limit(5);
                    }
                ])->find($undangan_id);

                if ($undangan) {
                    $galeri = $undangan->galeri;
                    $ucapan = $undangan->ucapan;
                }
            }

            return view('lovelove.index', compact('undangan', 'galeri', 'ucapan', 'tema'));
        } catch (Exception $e) {
            Log::error('Error displaying preview: ' . $e->getMessage());
            return view('lovelove.index', [
                'undangan' => null,
                'galeri' => [],
                'ucapan' => [],
                'tema' => 'tema1'
            ]);
        }
    }

    public function storeUcapan(Request $request)
    {
        try {
            $validated = $request->validate([
                'undangan_id' => 'required|exists:undangans,id',
                'nama' => 'required|string|max:100',
                'kehadiran' => 'required|string|in:hadir,tidak_hadir',
                'ucapan' => 'required|string',
            ]);

            $this->undanganService->saveUcapan($validated);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Terima kasih atas ucapan dan doanya']);
            }

            return redirect()->back()->with('success', 'Terima kasih atas ucapan dan doanya');
        } catch (Exception $e) {
            Log::error('Error storing ucapan: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengirim ucapan'], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim ucapan');
        }
    }

    /**
     * Get ucapan for a specific undangan
     */
    public function ucapan($undangan_id)
    {
        try {
            $ucapan = $this->undanganService->getUcapanByUndanganId($undangan_id);
            return response()->json(['success' => true, 'data' => $ucapan]);
        } catch (Exception $e) {
            Log::error('Error fetching ucapan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal mengambil data ucapan'], 500);
        }
    }

    /**
     * Display admin page for managing ucapan
     */
    public function adminUcapan(Request $request)
    {
        try {
            $filters = $request->only('search', 'undangan_id');
            $ucapan = $this->undanganService->getAllUcapan($filters);

            return Inertia::render('Ucapan/Index', [
                'ucapan' => $ucapan,
                'filters' => $filters,
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching ucapan list: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Delete an ucapan
     */
    public function deleteUcapan($id)
    {
        try {
            $this->undanganService->deleteUcapan($id);
            return redirect()->back()->with('success', 'Ucapan berhasil dihapus');
        } catch (Exception $e) {
            Log::error('Error deleting ucapan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus ucapan');
        }
    }
}
