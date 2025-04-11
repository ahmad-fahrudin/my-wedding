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
        title: 'Galeri',
        href: '/galeris',
    },
    {
        title: 'Tambah',
        href: '/galeris/create',
    },
];

const form = useForm({
  undangan_id: '',
  image: null,
});

// Image handling
const imagePreview = ref(null);
const imageInput = ref(null);
const imageError = ref(null);

function handleImageUpload(e) {
  const file = e.target.files[0];
  if (!file) return;

  // Validation
  imageError.value = null;
  const maxSize = 2 * 1024 * 1024; // 2MB

  if (file.size > maxSize) {
    imageError.value = "Image size must be less than 2MB";
    form.image = null;
    imagePreview.value = null;
    return;
  }

  // Create preview
  const reader = new FileReader();
  reader.onload = (event) => {
    imagePreview.value = event.target.result;
  };
  reader.readAsDataURL(file);

  // Set form value
  form.image = file;
}

function removeImage() {
  form.image = null;
  imagePreview.value = null;
  if (imageInput.value) {
    imageInput.value.value = '';
  }
}

// Dropdown related variables
const isDropdownOpen = ref(false);
const searchTerm = ref('');
const dropdownRef = ref(null);
const selectedUndangan = ref(null);

// Filter undangan based on search term
const filteredUndangan = computed(() => {
  if (!searchTerm.value) {
    return props.undangans?.data || [];
  }

  const searchLower = searchTerm.value.toLowerCase();
  return props.undangans?.data.filter(item => {
    const fullName = `${item.nama_memelai_1} & ${item.nama_memelai_2}`.toLowerCase();
    return fullName.includes(searchLower);
  });
});

// Toggle dropdown visibility
function toggleDropdown() {
  isDropdownOpen.value = !isDropdownOpen.value;
}

// Handle selection
function selectUndangan(undangan) {
  form.undangan_id = undangan.id;
  selectedUndangan.value = undangan;
  isDropdownOpen.value = false;
}

// Handle click outside
function handleClickOutside(event) {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isDropdownOpen.value = false;
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
  form.post(route('galeris.store'), {
    onSuccess: () => {
      Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: 'success',
                title: 'Foto galeri berhasil ditambahkan'
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
                title: 'Gagal menambahkan foto galeri'
      });
    },
  });
}
</script>

<template>
    <Head title="Tambah Foto Galeri" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Tambah Foto Galeri</h1>
            </div>

            <Card>
                <form @submit.prevent="submit">
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <Label for="undangan_id">Undangan</Label>
                            <div class="relative" ref="dropdownRef">
                                <button
                                    type="button"
                                    @click="toggleDropdown"
                                    class="w-full flex items-center justify-between pl-4 pr-2 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-sm"
                                >
                                    <span v-if="selectedUndangan">{{ selectedUndangan.nama_memelai_1 }} & {{ selectedUndangan.nama_memelai_2 }}</span>
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
                                            {{ item.nama_memelai_1 }} & {{ item.nama_memelai_2 }}
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
                            <Label for="image">Foto Galeri (Max 2MB)</Label>
                            <div class="flex flex-col space-y-4">
                            <div class="flex items-center justify-center w-full">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6" v-if="!imagePreview">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or GIF (max 2MB)</p>
                                </div>
                                <img v-else :src="imagePreview" class="h-full w-auto max-h-28 object-contain" alt="Gallery Preview" />
                                <input id="image" ref="imageInput" type="file" @change="handleImageUpload" class="hidden" accept="image/*" />
                                </label>
                            </div>

                            <div v-if="imagePreview" class="flex justify-center">
                                <Button type="button" variant="outline" size="sm" @click="removeImage">Remove Image</Button>
                            </div>

                            <p v-if="imageError" class="text-sm text-red-500">{{ imageError }}</p>
                            <p v-else-if="form.errors.image" class="text-sm text-red-500">{{ form.errors.image }}</p>
                            <p v-else-if="imagePreview" class="text-xs text-green-500">Image ready to upload</p>
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter class="flex justify-between">
                        <Link :href="route('galeris.index')">
                            <Button type="button" variant="outline">Batal</Button>
                        </Link>
                        <Button type="submit" :disabled="form.processing">Simpan Foto</Button>
                    </CardFooter>
                </form>
            </Card>
        </div>
    </AppLayout>
</template>
