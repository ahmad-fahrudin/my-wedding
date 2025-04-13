<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Exception;

class WaBlastService
{
    private $client;
    private $apiBaseUrl;
    private $secretKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiBaseUrl = 'http://157.245.206.34:10020/api/whatsapp';
        $this->secretKey = env('WABLAST_SECRET_KEY', 'your_secret_key');
    }

    public function generateToken(): array
    {
        try {
            $response = $this->client->post($this->apiBaseUrl . '/auth/generate', [
                'json' => [
                    'token' => $this->secretKey
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            ]);

            $body = $response->getBody()->getContents();


            $result = json_decode($body, true);
            return $result;
        } catch (GuzzleException $e) {
            Log::error('Error generating token: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to generate token: ' . $e->getMessage()
            ];
        }
    }

    public function connectDevice(string $deviceId, string $token): array
    {
        try {
            $response = $this->client->post($this->apiBaseUrl . '/connect', [
                'json' => [
                    'deviceId' => $deviceId
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            $body = $response->getBody()->getContents();

            $result = json_decode($body, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("Failed to parse JSON: " . json_last_error_msg());
                return [
                    'success' => false,
                    'message' => 'Invalid JSON response from server',
                    'raw_response' => $body
                ];
            }

            return $result;
        } catch (GuzzleException $e) {
            Log::error('Error connecting device: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to connect device: ' . $e->getMessage()
            ];
        }
    }

    public function getQrCode(string $deviceId, string $token)
    {
        try {
            $response = $this->client->get($this->apiBaseUrl . '/qr/' . $deviceId, [
                'headers' => [
                    'Accept' => 'image/png',
                    'Authorization' => 'Bearer ' . $token
                ],
                'timeout' => 30
            ]);

            $contentType = $response->getHeaderLine('Content-Type');

            // For Postman testing, we need to return the image as base64
            if (strpos($contentType, 'image/png') !== false) {
                $imageData = $response->getBody()->getContents();
                $base64Image = base64_encode($imageData);

                return [
                    'success' => true,
                    'contentType' => 'image/png',
                    'isImage' => true,
                    'imageBase64' => $base64Image,
                    'imageUrl' => 'data:image/png;base64,' . $base64Image
                ];
            }

            $body = $response->getBody()->getContents();

            $result = json_decode($body, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'success' => false,
                    'message' => 'Invalid response format from server',
                    'raw_response' => $body
                ];
            }

            return $result;
        } catch (GuzzleException $e) {
            Log::error('Error getting QR code: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to get QR code: ' . $e->getMessage()
            ];
        }
    }

    public function processQrCodeGeneration(string $deviceId)
    {
        // Step 1: Generate token
        $tokenResult = $this->generateToken();
        if (!isset($tokenResult['success']) || $tokenResult['success'] !== true) {
            return [
                'success' => false,
                'step' => 'generate_token',
                'message' => $tokenResult['message'] ?? 'Failed to generate token',
                'details' => $tokenResult
            ];
        }

        $token = $tokenResult['token'] ?? null;
        if (!$token) {
            return [
                'success' => false,
                'step' => 'extract_token',
                'message' => 'No token received from authentication service'
            ];
        }

        // Step 2: Connect device
        $connectResult = $this->connectDevice($deviceId, $token);
        if (!isset($connectResult['success']) || $connectResult['success'] !== true) {
            return [
                'success' => false,
                'step' => 'connect_device',
                'message' => $connectResult['message'] ?? 'Failed to connect device',
                'details' => $connectResult
            ];
        }

        // Step 3: Get QR code
        return $this->getQrCode($deviceId, $token);
    }
}
