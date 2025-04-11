<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\UndanganService;

class ContentController extends Controller
{
    protected $undanganService;

    public function __construct(UndanganService $undanganService)
    {
        $this->undanganService = $undanganService;
    }
    public function index()
    {
        $undangans = $this->undanganService->getAllUndangan([]);

        return Inertia::render('Content/Index', [
            'undangans' => $undangans
        ]);
    }
}
