<?php

namespace App\Http\Controllers;

use App\Services\WaBlastService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Log;

class WaBlastController extends Controller
{
    protected $waBlastService;

    public function __construct(WaBlastService $waBlastService)
    {
        $this->waBlastService = $waBlastService;
    }

    public function setupDevice()
    {
        return Inertia::render('WaBlast/Setup');
    }

    public function connectAndGenerateQR(Request $request)
    {
        $request->validate([
            'deviceId' => 'required|string',
        ]);
        try {
            $response = $this->waBlastService->processQrCodeGeneration($request->deviceId);

            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Error connecting and generating QR: ' . $e->getMessage());
            return response()->json(['message' => 'Error connecting and generating QR: ' . $e->getMessage()], 500);
        }
    }

    public function getDevices()
    {
        try {
            $response = $this->waBlastService->getDevices();

            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Error fetching devices: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching devices: ' . $e->getMessage()
            ], 500);
        }
    }
}
