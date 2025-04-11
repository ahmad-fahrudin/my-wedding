<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { CalendarIcon, MapPinIcon, ClockIcon, UsersIcon, CreditCardIcon } from 'lucide-vue-next';
import { ref, onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Undangan',
        href: '/undangans',
    },
    {
        title: 'Create',
        href: '/undangans/create',
    },
];

const form = useForm({
  nama_mempelai_1: '',
  nama_mempelai_2: '',
  tanggal_acara: '',
  waktu_acara: '',
  tempat: '',
  url_maps: '',
  rekening_gift: '',
});

// Map related variables
const mapSearch = ref('');
let map: any;
let marker: any;

function submit() {
  form.post(route('undangans.store'), {
    onSuccess: () => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        icon: 'success',
        title: 'Undangan created successfully'
      })
    },
    onError: () => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        icon: 'error',
        title: 'Failed to create undangan'
      });
    },
  });
}

// Initialize OpenStreetMap
onMounted(() => {
  // Load Leaflet CSS
  if (!document.getElementById('leaflet-css')) {
    const link = document.createElement('link');
    link.id = 'leaflet-css';
    link.rel = 'stylesheet';
    link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
    link.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=';
    link.crossOrigin = '';
    document.head.appendChild(link);
  }

  // Load Leaflet JS
  if (!window.L) {
    const script = document.createElement('script');
    script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
    script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=';
    script.crossOrigin = '';
    script.onload = initMap;
    document.head.appendChild(script);
  } else {
    initMap();
  }
});

function initMap() {
  // Default location (Indonesia)
  const defaultLocation = [-6.200000, 106.816666];

  // Create map
  map = L.map('map').setView(defaultLocation, 12);

  // Add OpenStreetMap tiles
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // Create marker
  marker = L.marker(defaultLocation, {
    draggable: true
  }).addTo(map);

  // Add click event to map
  map.on('click', (event: any) => {
    const { lat, lng } = event.latlng;
    marker.setLatLng([lat, lng]);
    updateLocationUrl(lat, lng);
  });

  // Add dragend event to marker
  marker.on('dragend', () => {
    const position = marker.getLatLng();
    updateLocationUrl(position.lat, position.lng);
  });
}

function searchLocation() {
  if (!mapSearch.value) return;

  // Use Nominatim for geocoding (free and doesn't require API key)
  fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(mapSearch.value)}`)
    .then(response => response.json())
    .then(data => {
      if (data && data.length > 0) {
        const location = data[0];
        const lat = parseFloat(location.lat);
        const lng = parseFloat(location.lon);

        map.setView([lat, lng], 15);
        marker.setLatLng([lat, lng]);
        updateLocationUrl(lat, lng);

        // Update tempat field with display name
        form.tempat = location.display_name;
      } else {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          icon: 'error',
          title: 'Lokasi tidak ditemukan'
        });
      }
    })
    .catch(error => {
      console.error('Error searching location:', error);
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        icon: 'error',
        title: 'Error searching location'
      });
    });
}

function updateLocationUrl(lat: number, lng: number) {
  form.url_maps = `https://www.google.com/maps?q=${lat},${lng}`;

  // Optionally get address from coordinates using Nominatim
  fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
    .then(response => response.json())
    .then(data => {
      if (data && data.display_name) {
        // Update tempat field with display name if it's empty
        if (!form.tempat) {
          form.tempat = data.display_name;
        }
      }
    })
    .catch(error => {
      console.error('Error getting address:', error);
    });
}
</script>

<template>
  <Head title="Buat Undangan Pernikahan" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="flex justify-between items-center mb-2">
        <h1 class="text-2xl font-bold">Buat Undangan Pernikahan</h1>
      </div>

      <Card class="overflow-hidden border-gray-200 dark:border-gray-800">
        <form @submit.prevent="submit">
          <CardContent class="p-6">
            <div class="grid gap-6 md:grid-cols-2">
              <!-- Couple Information -->
              <div class="space-y-4">
                <h3 class="text-md font-medium flex items-center gap-2">
                  <UsersIcon class="h-4 w-4" />
                  Informasi Pasangan
                </h3>

                <div class="space-y-2">
                  <Label for="nama_mempelai_1" class="font-medium">Nama Pengantin Pria</Label>
                  <Input
                    id="nama_mempelai_1"
                    v-model="form.nama_mempelai_1"
                    type="text"
                    placeholder="Masukkan nama pengantin pria"
                    :error="form.errors.nama_mempelai_1"
                    required
                    class="bg-white dark:bg-gray-900"
                  />
                  <p v-if="form.errors.nama_mempelai_1" class="text-sm text-red-500">{{ form.errors.nama_mempelai_1 }}</p>
                </div>

                <div class="space-y-2">
                  <Label for="nama_mempelai_2" class="font-medium">Nama Pengantin Wanita</Label>
                  <Input
                    id="nama_mempelai_2"
                    v-model="form.nama_mempelai_2"
                    type="text"
                    placeholder="Masukkan nama pengantin wanita"
                    :error="form.errors.nama_mempelai_2"
                    required
                    class="bg-white dark:bg-gray-900"
                  />
                  <p v-if="form.errors.nama_mempelai_2" class="text-sm text-red-500">{{ form.errors.nama_mempelai_2 }}</p>
                </div>
              </div>

              <!-- Ceremony Details -->
              <div class="space-y-4">
                <h3 class="text-md font-medium flex items-center gap-2">
                  <CalendarIcon class="h-4 w-4" />
                  Detail Acara
                </h3>

                <div class="space-y-2">
                  <Label for="tanggal_acara" class="font-medium">Tanggal Acara</Label>
                  <Input
                    id="tanggal_acara"
                    v-model="form.tanggal_acara"
                    type="date"
                    :error="form.errors.tanggal_acara"
                    required
                    class="bg-white dark:bg-gray-900"
                  />
                  <p v-if="form.errors.tanggal_acara" class="text-sm text-red-500">{{ form.errors.tanggal_acara }}</p>
                </div>

                <div class="space-y-2">
                  <Label for="waktu_acara" class="font-medium">Waktu Acara</Label>
                  <div class="flex items-center">
                    <ClockIcon class="h-4 w-4 mr-2 text-gray-400" />
                    <Input
                      id="waktu_acara"
                      v-model="form.waktu_acara"
                      type="time"
                      :error="form.errors.waktu_acara"
                      required
                      class="bg-white dark:bg-gray-900"
                    />
                  </div>
                  <p v-if="form.errors.waktu_acara" class="text-sm text-red-500">{{ form.errors.waktu_acara }}</p>
                </div>
              </div>

              <!-- Location Information -->
              <div class="space-y-4 md:col-span-2">
                <h3 class="text-md font-medium flex items-center gap-2">
                  <MapPinIcon class="h-4 w-4" />
                  Informasi Lokasi
                </h3>

                <div class="space-y-2">
                  <Label for="tempat" class="font-medium">Tempat Acara</Label>
                    <textarea
                        id="tempat"
                        v-model="form.tempat"
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-sm"
                        placeholder="Masukkan alamat lengkap"
                    ></textarea>
                  <p v-if="form.errors.tempat" class="text-sm text-red-500">{{ form.errors.tempat }}</p>
                </div>

                <div class="space-y-2">
                <Label for="url_maps" class="font-medium">Lokasi Google Maps</Label>

                <!-- Map Selection Component -->
                <div class="border border-gray-300 dark:border-gray-700 rounded-md overflow-hidden">
                    <div class="p-2 bg-gray-50 dark:bg-gray-800 border-b border-gray-300 dark:border-gray-700">
                    <div class="flex items-center gap-2">
                        <Input
                        id="map_search"
                        v-model="mapSearch"
                        type="text"
                        placeholder="Cari lokasi..."
                        class="bg-white dark:bg-gray-900"
                        @keydown.enter.prevent="searchLocation"
                        />
                        <Button type="button" size="sm" @click="searchLocation">Cari</Button>
                    </div>
                    </div>

                    <div id="map" class="h-[300px] w-full"></div>

                    <div class="p-2 bg-gray-50 dark:bg-gray-800 border-t border-gray-300 dark:border-gray-700">
                    <Input
                        id="url_maps"
                        v-model="form.url_maps"
                        type="text"
                        placeholder="URL lokasi akan muncul di sini"
                        :error="form.errors.url_maps"
                        readonly
                        class="bg-white dark:bg-gray-900"
                    />
                    </div>
                </div>

                <p v-if="form.errors.url_maps" class="text-sm text-red-500">{{ form.errors.url_maps }}</p>
                <p class="text-xs text-gray-500">Cari dan pilih lokasi acara pada peta</p>
                </div>
              </div>

              <!-- Gift Information -->
              <div class="space-y-4 md:col-span-2">
                <h3 class="text-md font-medium flex items-center gap-2">
                  <CreditCardIcon class="h-4 w-4" />
                  Informasi Hadiah
                </h3>

                <div class="space-y-2">
                  <Label for="rekening_gift" class="font-medium">Detail Rekening Hadiah</Label>
                    <input
                    id="rekening_gift"
                    v-model="form.rekening_gift"
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-sm"
                    placeholder="Masukkan nomor rekening"
                    />
                  <p v-if="form.errors.rekening_gift" class="text-sm text-red-500">{{ form.errors.rekening_gift }}</p>
                  <p class="text-xs text-gray-500">Contoh: Bank BCA - 1234567890 - Atas Nama: Budi Santoso</p>
                </div>
              </div>
            </div>
          </CardContent>

        <CardFooter class="flex justify-between">
            <Link :href="route('undangans.index')">
                <Button type="button" variant="outline">Cancel</Button>
            </Link>
            <Button type="submit" :disabled="form.processing">Buat Undangan</Button>
        </CardFooter>
        </form>
      </Card>
    </div>
  </AppLayout>
</template>
