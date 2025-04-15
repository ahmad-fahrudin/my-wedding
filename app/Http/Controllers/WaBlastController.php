<?php

namespace App\Http\Controllers;

use App\Services\WaBlastService;
use App\Services\TamuService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function storeMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $user = Auth::user();
            $user->message = $request->message;
            $user->save();

            return redirect()->back()->with('success', 'Pesan berhasil disimpan');
        } catch (Exception $e) {
            Log::error('Error storing message: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan pesan');
        }
    }

    public function sendPage(Request $request)
    {
        try {
            $filters = $request->only(['search', 'undangan_id']);
            $tamu = $this->tamuService->getAllTamu($filters);
            $user = Auth::user();

            return Inertia::render('WaBlast/SendPage', [
                'tamu' => $tamu,
                'filters' => $filters,
                'currentMessage' => $user->message,
            ]);
        } catch (Exception $e) {
            Log::error('Error fetching tamu data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data tamu');
        }
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'tamuId' => 'required|exists:tamus,id',
        ]);

        try {
            // Get authenticated user for device ID and message template
            $user = Auth::user();
            if (!$user->device) {
                return response()->json([
                    'success' => false,
                    'message' => 'Device not registered. Please setup your device first.'
                ], 400);
            }

            if (!$user->message) {
                return response()->json([
                    'success' => false,
                    'message' => 'No message template found. Please create a message template first.'
                ], 400);
            }

            // Get tamu data
            $tamu = $this->tamuService->getTamuById($request->tamuId);
            if (!$tamu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tamu tidak ditemukan'
                ], 404);
            }

            if (!$tamu->no_wa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tamu tidak memiliki nomor WhatsApp'
                ], 400);
            }

            // Process message template with replacements
            $message = $user->message;
            $replacements = [
                '{nama_tamu}' => $tamu->nama_tamu,
            ];

            foreach ($replacements as $placeholder => $value) {
                $message = str_replace($placeholder, $value, $message);
            }

            // Send message using WaBlastService
            $response = $this->waBlastService->sendMessage(
                $user->device,
                $tamu->no_wa,
                $message
            );

            if (!$response['success']) {
                Log::error('Failed to send WhatsApp message: ' . json_encode($response));
                return response()->json([
                    'success' => false,
                    'message' => $response['message'] ?? 'Failed to send message',
                    'details' => $response
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully',
                'details' => $response
            ]);
        } catch (Exception $e) {
            Log::error('Error sending WhatsApp message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending WhatsApp message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send bulk messages to multiple recipients
     */
    public function sendBulkMessage(Request $request)
    {
        try {
            // Get authenticated user for device ID and message template
            $user = Auth::user();
            if (!$user->device) {
                return response()->json([
                    'success' => false,
                    'message' => 'Device not registered. Please setup your device first.'
                ], 400);
            }

            if (!$user->message) {
                return response()->json([
                    'success' => false,
                    'message' => 'No message template found. Please create a message template first.'
                ], 400);
            }

            // Validate request - get recipients from filter parameters
            $filters = $request->only(['search', 'undangan_id']);

            // Get tamu data based on filters
            $tamus = $this->tamuService->getAllWithFilter($filters);
            if (count($tamus) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No recipients found with the current filter'
                ], 404);
            }

            // Format tamus for the bulk service
            $recipients = $tamus->map(function ($tamu) {
                return [
                    'id' => $tamu->id,
                    'nama_tamu' => $tamu->nama_tamu,
                    'no_wa' => $tamu->no_wa
                ];
            })->toArray();

            // Send bulk messages
            $response = $this->waBlastService->sendBulkMessages(
                $user->device,
                $recipients,
                $user->message
            );

            return response()->json($response);
        } catch (Exception $e) {
            Log::error('Error sending bulk WhatsApp messages: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending bulk WhatsApp messages: ' . $e->getMessage()
            ], 500);
        }
    }
}
