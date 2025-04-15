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
}
