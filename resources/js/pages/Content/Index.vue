<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  undangans: Object
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lihat Hasil',
        href: '/contents',
    },
];

const form = useForm({
  undangan_id: '',
  tema: 'tema1',
});

const hasPreviewData = ref(false);
const previewUrl = computed(() => {
  if (!form.undangan_id || !form.tema) return '';
  return `/undangans/preview/${form.undangan_id}/${form.tema}`;
});

// Dropdown related variables
const isDropdownOpen = ref(false);
const searchTerm = ref('');
const dropdownRef = ref(null);
const selectedUndangan = ref(null);

// Theme dropdown
const isThemeDropdownOpen = ref(false);
const themeDropdownRef = ref(null);

// Filter undangan based on search term
const filteredUndangan = computed(() => {
  if (!searchTerm.value) {
    return props.undangans?.data || [];
  }

  const searchLower = searchTerm.value.toLowerCase();
  return props.undangans?.data.filter(item => {
    const fullName = `${item.nama_mempelai_1} & ${item.nama_mempelai_2}`.toLowerCase();
    return fullName.includes(searchLower);
  });
});

// Toggle dropdown visibility
function toggleDropdown() {
  isDropdownOpen.value = !isDropdownOpen.value;
}

// Toggle theme dropdown
function toggleThemeDropdown() {
  isThemeDropdownOpen.value = !isThemeDropdownOpen.value;
}

// Handle selection
function selectUndangan(undangan) {
  form.undangan_id = undangan.id;
  selectedUndangan.value = undangan;
  isDropdownOpen.value = false;
}

// Handle theme selection
function selectTheme(theme) {
  form.tema = theme;
  isThemeDropdownOpen.value = false;
}

// Handle click outside
function handleClickOutside(event) {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isDropdownOpen.value = false;
  }
  if (themeDropdownRef.value && !themeDropdownRef.value.contains(event.target)) {
    isThemeDropdownOpen.value = false;
  }
}

// Set initial selected undangan if form has value
onMounted(() => {
  document.addEventListener('click', handleClickOutside);
  if (form.undangan_id && props.undangans?.data) {
    selectedUndangan.value = props.undangans.data.find(item => item.id === form.undangan_id);
  }
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});

function submit() {
  if (form.undangan_id && form.tema) {
    hasPreviewData.value = true;
    form.post(route('undangans.contents.store'), {
      onSuccess: () => {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          icon: 'success',
          title: 'Preview undangan berhasil ditampilkan'
        });
      },
      onError: () => {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          icon: 'error',
          title: 'Gagal menampilkan preview undangan'
        });
      },
    });
  }
}
</script>

<style scoped>
.mobile-preview {
  display: flex;
  justify-content: center;
  padding: 20px;
}

.mobile-frame {
  width: 400px;
  height: 650px;
  background-color: #111;
  border-radius: 36px;
  padding: 10px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
}

.mobile-top {
  height: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.mobile-notch {
  width: 150px;
  height: 20px;
  background-color: #111;
  border-radius: 0 0 15px 15px;
}

.mobile-screen {
  flex: 1;
  background-color: white;
  border-radius: 20px;
  overflow: hidden;
  position: relative;
}

.mobile-bottom {
  height: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.mobile-home-button {
  width: 40px;
  height: 4px;
  background-color: #444;
  border-radius: 2px;
}
</style>

<template>
    <Head title="Hasil Undangan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Hasil Undangan</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Form Section - 6 columns -->
                <div class="md:col-span-6">
                    <Card>
                        <form @submit.prevent="submit">
                            <CardContent class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="undangan_id">Undangan</Label>
                                    <div class="relative" ref="dropdownRef">
                                        <!-- Existing dropdown code for undangan -->
                                        <button
                                            type="button"
                                            @click="toggleDropdown"
                                            class="w-full flex items-center justify-between pl-4 pr-2 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-sm"
                                        >
                                            <span v-if="selectedUndangan">{{ selectedUndangan.nama_mempelai_1 }} & {{ selectedUndangan.nama_mempelai_2 }}</span>
                                            <span v-else class="text-gray-500">Pilih Undangan</span>
                                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <div v-show="isDropdownOpen" class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md shadow-lg max-h-60 overflow-auto">
                                            <div class="sticky top-0 z-10 bg-white dark:bg-gray-900 p-2 border-b border-gray-200 dark:border-gray-700">
                                                <Input
                                                    id="undangan-search"
                                                    v-model="searchTerm"
                                                    type="text"
                                                    placeholder="Cari undangan..."
                                                    class="w-full"
                                                    @click.stop
                                                />
                                            </div>
                                            <div v-if="filteredUndangan.length" class="py-1">
                                                <button
                                                    v-for="item in filteredUndangan"
                                                    :key="item.id"
                                                    type="button"
                                                    @click="selectUndangan(item)"
                                                    class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-800"
                                                    :class="{'bg-blue-50 dark:bg-blue-900': form.undangan_id === item.id}"
                                                >
                                                    {{ item.nama_mempelai_1 }} & {{ item.nama_mempelai_2 }}
                                                </button>
                                            </div>
                                            <div v-else class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">
                                                Undangan tidak ditemukan
                                            </div>
                                        </div>
                                        <input type="hidden" v-model="form.undangan_id" />
                                        <p v-if="form.errors.undangan_id" class="mt-1 text-sm text-red-500">{{ form.errors.undangan_id }}</p>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <Label for="tema">Tema</Label>
                                    <div class="relative" ref="themeDropdownRef">
                                        <!-- Existing theme dropdown code -->
                                        <button
                                            type="button"
                                            @click="toggleThemeDropdown"
                                            class="w-full flex items-center justify-between pl-4 pr-2 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-sm"
                                        >
                                            <span>{{ form.tema === 'tema1' ? 'Tema 1' : 'Tema 2' }}</span>
                                            <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <div v-show="isThemeDropdownOpen" class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md shadow-lg">
                                            <div class="py-1">
                                                <button
                                                    type="button"
                                                    @click="selectTheme('tema1')"
                                                    class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-800"
                                                    :class="{'bg-blue-50 dark:bg-blue-900': form.tema === 'tema1'}"
                                                >
                                                    Tema 1
                                                </button>
                                                <button
                                                    type="button"
                                                    @click="selectTheme('tema2')"
                                                    class="w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-800"
                                                    :class="{'bg-blue-50 dark:bg-blue-900': form.tema === 'tema2'}"
                                                >
                                                    Tema 2
                                                </button>
                                            </div>
                                        </div>
                                        <input type="hidden" v-model="form.tema" />
                                        <p v-if="form.errors.tema" class="mt-1 text-sm text-red-500">{{ form.errors.tema }}</p>
                                    </div>
                                </div>
                            </CardContent>
                            <CardFooter class="flex justify-between">
                                <Link :href="route('galeris.index')">
                                    <Button type="button" variant="outline">Batal</Button>
                                </Link>
                                <Button type="submit" :disabled="form.processing">Lihat Hasil</Button>
                            </CardFooter>
                        </form>
                    </Card>
                </div>

                <!-- Mobile Preview Section - 6 columns -->
                <div class="md:col-span-6">
                    <Card class="h-full">
                        <CardContent class="flex flex-col items-center justify-center h-full">
                            <div class="mobile-preview">
                                <div class="mobile-frame">
                                    <div class="mobile-top">
                                        <div class="mobile-notch"></div>
                                    </div>
                                    <div class="mobile-screen">
                                        <div v-if="hasPreviewData && !previewUrl" class="flex flex-col items-center justify-center h-full">
                                            <div class="text-gray-400 text-center">
                                                <svg class="animate-spin mx-auto h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <p class="mt-2">Loading preview...</p>
                                            </div>
                                        </div>
                                        <div v-else-if="!hasPreviewData" class="flex flex-col items-center justify-center h-full text-gray-400 text-center p-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p>Silakan pilih undangan dan tema untuk melihat preview</p>
                                        </div>
                                        <iframe v-else-if="hasPreviewData && previewUrl"
                                            :src="previewUrl"
                                            class="w-full h-full border-none"
                                            title="Wedding Invitation Preview"
                                            sandbox="allow-scripts allow-same-origin"
                                            scrolling="yes">
                                        </iframe>
                                    </div>
                                    <div class="mobile-bottom">
                                        <div class="mobile-home-button"></div>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
