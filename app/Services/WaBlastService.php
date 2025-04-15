<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class WaBlastService
{
    private $client;
    private $apiBaseUrl;
    private $secretKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiBaseUrl = 'http://localhost:10020/api/whatsapp';
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

    public function getAuthToken(): array
    {
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

        return [
            'success' => true,
            'token' => $token
        ];
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

            // Update the user's device
            if (isset($result['success']) && $result['success'] === true) {
                if (Auth::check()) {
                    $user = Auth::user();
                    $user->device = $deviceId;
                    $user->save();

                    // Add information about the update to the result
                    $result['device_updated'] = true;
                } else {
                    Log::warning('Could not update device: No authenticated user found');
                    $result['device_updated'] = false;
                    $result['device_update_message'] = 'No authenticated user found';
                }
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

    public function checkDeviceStatus(string $deviceId, string $token): array
    {
        try {
            $response = $this->client->get($this->apiBaseUrl . '/devices', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if (
                isset($result['success']) && $result['success'] === true &&
                isset($result['devices']) && is_array($result['devices'])
            ) {

                $deviceExists = false;
                $isConnected = false;

                foreach ($result['devices'] as $device) {
                    if ($device['deviceId'] === $deviceId) {
                        $deviceExists = true;
                        $isConnected = ($device['status'] === 'connected');
                        break;
                    }
                }

                return [
                    'success' => true,
                    'exists' => $deviceExists,
                    'isConnected' => $isConnected
                ];
            }

            return [
                'success' => false,
                'message' => 'Could not determine device status'
            ];
        } catch (GuzzleException $e) {
            Log::error('Error checking device status: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error checking device status: ' . $e->getMessage()
            ];
        }
    }

    public function generateQrCodeOnly(string $deviceId): array
    {
        // Get token
        $tokenResult = $this->getAuthToken();
        if (!$tokenResult['success']) {
            return $tokenResult;
        }

        $token = $tokenResult['token'];

        // Check device status first
        $deviceStatus = $this->checkDeviceStatus($deviceId, $token);
        if ($deviceStatus['success'] && $deviceStatus['isConnected']) {
            return [
                'success' => true,
                'message' => 'Device sudah terhubung',
                'isConnected' => true
            ];
        }

        // Get QR code directly
        $qrResult = $this->getQrCode($deviceId, $token);

        // Handle specific error case
        if (
            !$qrResult['success'] &&
            isset($qrResult['message']) &&
            strpos($qrResult['message'], 'No QR Code available') !== false
        ) {

            // Check if device status changed
            $deviceStatus = $this->checkDeviceStatus($deviceId, $token);
            if ($deviceStatus['success'] && $deviceStatus['isConnected']) {
                return [
                    'success' => true,
                    'message' => 'Device sudah terhubung',
                    'isConnected' => true
                ];
            } else if (!$deviceStatus['exists']) {
                return [
                    'success' => false,
                    'message' => 'Device belum terhubung. Silakan hubungkan terlebih dahulu.'
                ];
            }
        }

        return $qrResult;
    }

    public function checkDevices(string $deviceId, string $token): array
    {
        try {
            $response = $this->client->get($this->apiBaseUrl . '/devices', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if (
                isset($result['success']) && $result['success'] === true &&
                isset($result['devices']) && is_array($result['devices'])
            ) {

                $deviceFound = false;
                $isConnected = false;
                $devices = $result['devices'];
                $targetDevice = null;

                // Find the specific device in the list
                foreach ($devices as $device) {
                    if ($device['deviceId'] === $deviceId) {
                        $deviceFound = true;
                        $isConnected = ($device['status'] === 'connected');
                        $targetDevice = $device;
                        break;
                    }
                }

                // Update the user's device
                $user = Auth::user();
                $user->is_connect = true;
                $user->save();

                return [
                    'success' => true,
                    'deviceFound' => $deviceFound,
                    'isConnected' => $isConnected,
                    'device' => $targetDevice,
                    'allDevices' => $devices
                ];
            }

            return [
                'success' => false,
                'message' => 'Could not get device information from server'
            ];
        } catch (GuzzleException $e) {
            Log::error('Error checking devices: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error checking devices: ' . $e->getMessage()
            ];
        }
    }

    public function sendMessage(string $deviceId, string $to, string $message): array
    {
        try {
            // Get token first
            $tokenResult = $this->getAuthToken();
            if (!$tokenResult['success']) {
                return $tokenResult;
            }

            $token = $tokenResult['token'];

            // Format phone number if it doesn't end with @s.whatsapp.net
            if (strpos($to, '@s.whatsapp.net') === false) {
                $to = $to . '@s.whatsapp.net';
            }

            $response = $this->client->post($this->apiBaseUrl . '/send', [
                'json' => [
                    'deviceId' => $deviceId,
                    'to' => $to,
                    'message' => $message
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ],
                'timeout' => 30
            ]);

            $body = $response->getBody()->getContents();
            $result = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("Failed to parse JSON response from send message: " . json_last_error_msg());
                return [
                    'success' => false,
                    'message' => 'Invalid JSON response from server',
                    'raw_response' => $body
                ];
            }

            return $result;
        } catch (GuzzleException $e) {
            Log::error('Error sending message: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Send bulk messages to multiple recipients
     * 
     * @param string $deviceId The device ID to use for sending
     * @param array $recipients Array of recipient information (id, no_wa, nama_tamu)
     * @param string $messageTemplate The message template with placeholders
     * @return array Response with success status and details
     */
    public function sendBulkMessages(string $deviceId, array $recipients, string $messageTemplate): array
    {
        // Get token first
        $tokenResult = $this->getAuthToken();
        if (!$tokenResult['success']) {
            return $tokenResult;
        }

        $token = $tokenResult['token'];

        $results = [
            'success' => true,
            'total' => count($recipients),
            'sent' => 0,
            'failed' => 0,
            'details' => []
        ];

        foreach ($recipients as $recipient) {
            try {
                // Skip if no WhatsApp number
                if (empty($recipient['no_wa'])) {
                    $results['failed']++;
                    $results['details'][] = [
                        'id' => $recipient['id'],
                        'name' => $recipient['nama_tamu'],
                        'success' => false,
                        'message' => 'No WhatsApp number provided'
                    ];
                    continue;
                }

                // Process message template with replacements
                $message = $messageTemplate;
                $message = str_replace('{nama_tamu}', $recipient['nama_tamu'], $message);

                // Format phone number if needed
                $to = $recipient['no_wa'];
                if (strpos($to, '@s.whatsapp.net') === false) {
                    $to = $to . '@s.whatsapp.net';
                }

                // Send message
                $response = $this->client->post($this->apiBaseUrl . '/send', [
                    'json' => [
                        'deviceId' => $deviceId,
                        'to' => $to,
                        'message' => $message
                    ],
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $token
                    ],
                    'timeout' => 30
                ]);

                $body = $response->getBody()->getContents();
                $responseData = json_decode($body, true);

                if (isset($responseData['success']) && $responseData['success'] === true) {
                    $results['sent']++;
                    $results['details'][] = [
                        'id' => $recipient['id'],
                        'name' => $recipient['nama_tamu'],
                        'success' => true
                    ];
                } else {
                    $results['failed']++;
                    $results['details'][] = [
                        'id' => $recipient['id'],
                        'name' => $recipient['nama_tamu'],
                        'success' => false,
                        'message' => $responseData['message'] ?? 'Unknown error'
                    ];
                }

                // Add a small delay to avoid rate limiting (optional)
                usleep(500000); // 500ms delay

            } catch (GuzzleException $e) {
                Log::error('Error sending bulk message to ' . $recipient['nama_tamu'] . ': ' . $e->getMessage());
                $results['failed']++;
                $results['details'][] = [
                    'id' => $recipient['id'],
                    'name' => $recipient['nama_tamu'],
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ];
            } catch (Exception $e) {
                Log::error('General error sending bulk message: ' . $e->getMessage());
                $results['failed']++;
                $results['details'][] = [
                    'id' => $recipient['id'],
                    'name' => $recipient['nama_tamu'],
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ];
            }
        }

        // Update success status if any failures occurred
        if ($results['failed'] > 0 && $results['sent'] == 0) {
            $results['success'] = false;
            $results['message'] = 'All messages failed to send';
        } elseif ($results['failed'] > 0) {
            $results['message'] = "Sent {$results['sent']} of {$results['total']} messages";
        } else {
            $results['message'] = "All {$results['sent']} messages sent successfully";
        }

        return $results;
    }
}
