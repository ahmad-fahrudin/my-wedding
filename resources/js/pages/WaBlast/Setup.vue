<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'WaBlast',
        href: '/wablast',
    },
    {
        title: 'Setup',
        href: '/wablast/setup',
    },
];

const form = useForm({
  deviceId: '',
});

const qrCode = ref(null);
const error = ref(null);
const processing = ref(false);
</script>

<template>
    <Head title="WaBlast Setup" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">WaBlast Setup</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Tutorial Section - 6 columns -->
                <div class="md:col-span-6">
                    <Card>
                        <CardContent>
                            <div class="space-y-4">
                                <h2 class="text-xl font-semibold text-blue-600 dark:text-blue-400">How to Use WaBlast</h2>

                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium">Step 1: Connect Your Device</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Enter a unique device name and click Connect to generate a QR code.</p>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium">Step 2: Scan QR Code</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Open WhatsApp on your phone and scan the QR code that appears.</p>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium">Step 3: Send Messages</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Once connected, you can send bulk messages to your contacts.</p>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium">Step 4: Monitor Status</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Track the delivery status of your messages in the dashboard.</p>
                                </div>

                                <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-md">
                                    <h3 class="text-lg font-medium mb-2">Important Notes:</h3>
                                    <ul class="list-disc pl-5 space-y-1 text-gray-600 dark:text-gray-300">
                                        <li>Ensure your phone has a stable internet connection</li>
                                        <li>Keep your phone charged while using the service</li>
                                        <li>Follow WhatsApp's policies to avoid being blocked</li>
                                    </ul>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Device Connection Form - 6 columns -->
                <div class="md:col-span-6">
                    <Card>
                        <form @submit.prevent="">
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="deviceId">Nama Device</Label>
                                    <Input
                                        id="deviceId"
                                        v-model="form.deviceId"
                                        placeholder="Masukkan nama device"
                                        required
                                    />
                                    <p v-if="form.errors.deviceId" class="text-sm text-red-500">
                                        {{ form.errors.deviceId }}
                                    </p>
                                </div>

                                <!-- QR Code Display -->
                                <div v-if="qrCode" class="mt-6 flex flex-col items-center justify-center">
                                    <h3 class="text-lg font-medium mb-3">Scan QR Code with WhatsApp</h3>
                                    <div
                                        class="p-4 bg-white border border-gray-200 dark:border-gray-700 rounded-md shadow-sm"
                                        v-html="qrCode"
                                    ></div>
                                    <p class="mt-3 text-gray-600 dark:text-gray-300">Scan this QR code using WhatsApp on your phone</p>
                                </div>

                                <!-- Error Message -->
                                <div v-if="error" class="p-3 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-300 rounded-md">
                                    {{ error }}
                                </div>
                            </CardContent>
                            <CardFooter>
                                <Button
                                    type="submit"
                                    class="w-full"
                                    :disabled="processing"
                                >
                                    {{ processing ? 'Connecting...' : 'Connect' }}
                                </Button>
                            </CardFooter>
                        </form>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
