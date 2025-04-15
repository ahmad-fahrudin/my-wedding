<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const page = usePage();
const user = page.props.auth.user;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'WaBlast',
        href: '/setup',
    },
    {
        title: 'Setup',
        href: '/setup',
    },
];

const form = useForm({
    deviceId: user.device || '',
});

const qrCode = ref(null);
const error = ref(null);
const connectionStatus = ref(null);
const processingConnect = ref(false);
const processingQR = ref(false);
const processingCheck = ref(false);
const deviceStatus = ref(null);
const hasDevice = ref(!!user.device);
const isConnected = ref(user.is_connect || false);

// Check if device is already connected on mount
onMounted(() => {
    if (hasDevice.value) {
        connectionStatus.value = 'Device sudah terdaftar';
        handleCheckDevice();
    }
});

const handleConnectDevice = async () => {
    error.value = null;
    connectionStatus.value = null;
    processingConnect.value = true;

    try {
        // Validate device ID before sending request
        if (!form.deviceId) {
            error.value = 'Nama device tidak boleh kosong';
            processingConnect.value = false;
            return;
        }

        const response = await axios.get('/connect-device', {
            params: {
                deviceId: form.deviceId
            }
        });

        if (response.data && response.data.success) {
            connectionStatus.value = 'Device berhasil terhubung';
            Swal.fire({
                icon: 'success',
                title: 'Device Berhasil Terhubung',
                text: 'Device telah berhasil didaftarkan. Silakan generate QR Code untuk menghubungkan dengan WhatsApp.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        } else {
            error.value = response.data?.message || 'Gagal menghubungkan device';
        }
    } catch (err) {
        console.error('Error connecting device:', err);
        error.value = err.response?.data?.message || 'Terjadi kesalahan saat menghubungkan perangkat';
    } finally {
        processingConnect.value = false;
    }
};

const handleGenerateQR = async () => {
    error.value = null;
    qrCode.value = null;
    processingQR.value = true;

    try {
        // Validate device ID before sending request
        if (!form.deviceId) {
            error.value = 'Nama device tidak boleh kosong';
            processingQR.value = false;
            return;
        }

        const response = await axios.get('/generate-qr', {
            params: {
                deviceId: form.deviceId
            }
        });

        if (response.data && response.data.success) {
            // Handle already connected device
            if (response.data.isConnected) {
                connectionStatus.value = 'Device sudah terhubung dengan WhatsApp';
                deviceStatus.value = 'connected';
                Swal.fire({
                    icon: 'info',
                    title: 'Device Sudah Terhubung',
                    text: 'Device ini sudah terhubung dengan WhatsApp',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                return;
            }

            qrCode.value = response.data.imageUrl;
            Swal.fire({
                icon: 'success',
                title: 'QR Code Berhasil Dibuat',
                text: 'Silakan scan QR code dengan WhatsApp di perangkat Anda',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        } else {
            error.value = response.data?.message || 'Gagal menghasilkan QR code';
        }
    } catch (err) {
        console.error('Error generating QR code:', err);
        error.value = err.response?.data?.message || 'Terjadi kesalahan saat menghasilkan QR code';
    } finally {
        processingQR.value = false;
    }
};

const handleCheckDevice = async () => {
    error.value = null;
    deviceStatus.value = null;
    processingCheck.value = true;

    try {
        // Validate device ID before sending request
        if (!form.deviceId) {
            error.value = 'Nama device tidak boleh kosong';
            processingCheck.value = false;
            return;
        }

        const response = await axios.get('/device-check', {
            params: {
                deviceId: form.deviceId
            }
        });

        if (response.data && response.data.success) {
            if (response.data.deviceFound) {
                const status = response.data.isConnected ? 'connected' : 'not connected';
                deviceStatus.value = status;

                if (response.data.isConnected) {
                    connectionStatus.value = 'Device terhubung dengan WhatsApp';
                    Swal.fire({
                        icon: 'success',
                        title: 'Device Terhubung',
                        text: 'Device sudah terhubung dengan WhatsApp',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    connectionStatus.value = 'Device belum terhubung dengan WhatsApp';
                    Swal.fire({
                        icon: 'warning',
                        title: 'Device Belum Terhubung',
                        text: 'Device belum terhubung dengan WhatsApp. Silakan generate QR Code dan scan untuk menghubungkan.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            } else {
                error.value = 'Device tidak ditemukan. Silakan connect device terlebih dahulu.';
                Swal.fire({
                    icon: 'error',
                    title: 'Device Tidak Ditemukan',
                    text: 'Device tidak ditemukan. Silakan connect device terlebih dahulu.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        } else {
            error.value = response.data?.message || 'Gagal memeriksa status device';
        }
    } catch (err) {
        console.error('Error checking device status:', err);
        error.value = err.response?.data?.message || 'Terjadi kesalahan saat memeriksa status perangkat';
    } finally {
        processingCheck.value = false;
    }
};
</script>

<template>
    <Head title="WaBlast Setup" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-primary">WhatsApp Blast Setup</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Tutorial Section - 5 columns -->
                <div class="md:col-span-5">
                    <Card class="h-full">
                        <CardHeader className="pb-2">
                            <CardTitle class="text-xl font-semibold text-blue-600 dark:text-blue-400">
                                How to Use WaBlast
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium">Step 1: Register Your Device</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Enter a unique device name and click "Connect Device" to register your device with the system.</p>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium">Step 2: Generate QR Code</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Click the "Generate QR Code" button to create a QR code for your device.</p>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium">Step 3: Scan QR Code</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Open WhatsApp on your phone and scan the QR code that appears to connect your WhatsApp account.</p>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium">Step 4: Send Messages</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Once connected, you can send bulk messages to your contacts from the dashboard.</p>
                                </div>

                                <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-md">
                                    <h3 class="text-lg font-medium mb-2">Important Notes:</h3>
                                    <ul class="list-disc pl-5 space-y-1 text-gray-600 dark:text-gray-300">
                                        <li>Ensure your phone has a stable internet connection</li>
                                        <li>Keep your phone charged while using the service</li>
                                        <li>Follow WhatsApp's policies to avoid being blocked</li>
                                        <li>Only use this service for legitimate communication</li>
                                    </ul>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Device Connection Form - 7 columns -->
                <div class="md:col-span-7">
                    <Card class="mb-6">
                        <CardHeader className="pb-2">
                            <CardTitle>Device Registration</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="deviceId">Nama Device</Label>
                                    <Input
                                        id="deviceId"
                                        v-model="form.deviceId"
                                        placeholder="Masukkan nama device (contoh: wa-sender-1)"
                                        required
                                    />
                                    <p v-if="form.errors.deviceId" class="text-sm text-red-500">
                                        {{ form.errors.deviceId }}
                                    </p>
                                </div>
                            </div>
                        </CardContent>
                        <CardFooter class="flex justify-between items-center flex-wrap gap-4">
                            <Button
                                type="button"
                                class="w-full sm:w-auto px-6"
                                :disabled="processingConnect || hasDevice"
                                @click="handleConnectDevice"
                            >
                                <span v-if="processingConnect" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Menghubungkan...
                                </span>
                                <span v-else class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                                    </svg>
                                    Connect Device
                                </span>
                            </Button>
                            <Button
                                type="button"
                                variant="outline"
                                class="w-full sm:w-auto px-6"
                                :disabled="processingQR || isConnected"
                                @click="handleGenerateQR"
                            >
                                <span v-if="processingQR" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Generating...
                                </span>
                                <span v-else class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1v-2a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                    Generate QR Code
                                </span>
                            </Button>
                            <Button
                                type="button"
                                variant="secondary"
                                class="w-full sm:w-auto px-6"
                                :disabled="processingCheck"
                                @click="handleCheckDevice"
                            >
                                <span v-if="processingCheck" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Checking...
                                </span>
                                <span v-else class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Check Connection
                                </span>
                            </Button>
                        </CardFooter>
                    </Card>

                    <!-- Status Display -->
                    <Card v-if="connectionStatus && deviceStatus === 'connected'" class="mb-6 border-green-200 bg-green-50 dark:bg-green-900/20 dark:border-green-900">
                        <CardContent class="p-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-green-700 dark:text-green-300 font-medium">{{ connectionStatus }}</span>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Not Connected Status Display -->
                    <Card v-if="connectionStatus && deviceStatus === 'not connected'" class="mb-6 border-yellow-200 bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-900">
                        <CardContent class="p-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-yellow-700 dark:text-yellow-300 font-medium">{{ connectionStatus }}</span>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- Error Display -->
                    <Card v-if="error" class="mb-6 border-red-200 bg-red-50 dark:bg-red-900/20 dark:border-red-900">
                        <CardContent class="p-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-red-700 dark:text-red-300 font-medium">{{ error }}</span>
                            </div>
                        </CardContent>
                    </Card>

                    <!-- QR Code Display -->
                    <Card v-if="qrCode" class="border-blue-200">
                        <CardContent class="p-4">
                            <div class="flex flex-col items-center justify-center">
                                <h3 class="text-lg font-medium mb-4 text-center">Scan QR Code dengan WhatsApp</h3>
                                <div class="bg-white border-4 border-gray-200 rounded-md p-3 shadow-lg">
                                    <img :src="qrCode" alt="WhatsApp QR Code" class="w-64 h-64 object-contain" />
                                </div>
                                <div class="mt-4 text-center max-w-md mx-auto bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                    <p class="font-medium mb-2 text-blue-600 dark:text-blue-400">Cara Scan:</p>
                                    <ol class="text-gray-600 dark:text-gray-300 list-decimal pl-5 text-left space-y-1">
                                        <li>Buka WhatsApp di perangkat Anda</li>
                                        <li>Ketuk Menu (⋮) > <b>Perangkat Tertaut</b></li>
                                        <li>Ketuk <b>Tautkan Perangkat</b></li>
                                        <li>Arahkan kamera ke QR code ini</li>
                                    </ol>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
