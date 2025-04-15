<?php

namespace App\Http\Controllers;

use App\Services\WaBlastService;
use App\Services\TamuService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Log;

class WaBlastController extends Controller
{
    protected $waBlastService;
    protected $tamuService;

    public function __construct(
        WaBlastService $waBlastService,
        TamuService $tamuService
    ) {
        $this->waBlastService = $waBlastService;
        $this->tamuService = $tamuService;
    }

    public function setupDevice()
    {
        return Inertia::render('WaBlast/Setup');
    }

    public function connectDevice(Request $request)
    {
        $request->validate([
            'deviceId' => 'required|string',
        ]);
        try {
            // Get token first
            $tokenResult = $this->waBlastService->getAuthToken();
            if (!$tokenResult['success']) {
                return response()->json($tokenResult);
            }

            $response = $this->waBlastService->connectDevice(
                $request->deviceId,
                $tokenResult['token']
            );

            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Error connecting device: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error connecting device: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateQR(Request $request)
    {
        $request->validate([
            'deviceId' => 'required|string',
        ]);
        try {
            $response = $this->waBlastService->generateQrCodeOnly($request->deviceId);

            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Error generating QR: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error generating QR: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkDeviceStatus(Request $request)
    {
        $request->validate([
            'deviceId' => 'required|string',
        ]);

        try {
            // Get token first
            $tokenResult = $this->waBlastService->getAuthToken();
            if (!$tokenResult['success']) {
                return response()->json($tokenResult);
            }

            $response = $this->waBlastService->checkDevices($request->deviceId, $tokenResult['token']);

            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Error checking device status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error checking device status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sendPage(Request $request)
    {
        try {
            $filters = $request->only(['search', 'undangan_id']);
            $tamu = $this->tamuService->getAllTamu($filters);

            return Inertia::render('WaBlast/SendPage', [
                'tamu' => $tamu,
                'filters' => $filters,
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching tamu data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data tamu');
        }
    }
}
