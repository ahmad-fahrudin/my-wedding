<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref, computed, onMounted, onUnmounted, reactive } from 'vue';
import axios from 'axios';

const props = defineProps({
  galeri: Object,
  undangans: Object,
  types: Array,
  categories: Array
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Galeri',
        href: '/galeris',
    },
    {
        title: 'Edit',
        href: `/galeris/${props.galeri?.id}/edit`,
    },
];

const form = useForm({
  undangan_id: props.galeri?.undangan_id || '',
  type: props.galeri?.type || '',
  _method: 'PUT',
});

const categoryLimits = {
  'hero': 1,
  'couple': 2,
  'story': 3,
  'gallery': 6
};

const imageInputs = reactive({
  hero: [],
  couple: [],
  story: [],
  gallery: []
});

const imageErrors = reactive({
  hero: null,
  couple: null,
  story: null,
  gallery: null
});

const imagePreviews = reactive({
  hero: [],
  couple: [],
  story: [],
  gallery: []
});

// Initialize preview for existing image
onMounted(() => {
  if (props.galeri?.image && props.galeri?.category) {
    imagePreviews[props.galeri.category].push(props.galeri.image);
  }
});

function validateImage(file, category) {
  const maxSize = 2 * 1024 * 1024;

  if (file.size > maxSize) {
    imageErrors[category] = "Image size must be less than 2MB";
    return false;
  }

  return true;
}

function handleImageUpload(e, category) {
  const files = Array.from(e.target.files || []);
  const limit = categoryLimits[category];

  if (files.length > limit) {
    imageErrors[category] = `You can only upload up to ${limit} images for ${category}`;
    return;
  }

  imageErrors[category] = null;

  // Clear previous previews and files
  imagePreviews[category] = [];
  imageInputs[category] = [];

  // Process each file
  files.forEach(file => {
    if (validateImage(file, category)) {
      const reader = new FileReader();
      reader.onload = (event) => {
        imagePreviews[category].push(event.target.result);
      };
      reader.readAsDataURL(file);

      imageInputs[category].push(file);
    }
  });
}

function removeImage(category, index) {
  imagePreviews[category].splice(index, 1);
  imageInputs[category].splice(index, 1);
}

function removeAllImages(category) {
  imagePreviews[category] = [];
  imageInputs[category] = [];

  const inputElement = document.getElementById(`${category}-image`);
  if (inputElement) {
    inputElement.value = '';
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
    const fullName = `${item.nama_mempelai_1} & ${item.nama_mempelai_2}`.toLowerCase();
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

  // Set selected undangan from the galeri data
  if (props.galeri?.undangan_id && props.undangans?.data) {
    selectedUndangan.value = props.undangans.data.find(item => item.id === props.galeri.undangan_id);
  }
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});

const hasImages = computed(() => {
  return imageInputs.hero.length > 0 ||
         imageInputs.couple.length > 0 ||
         imageInputs.story.length > 0 ||
         imageInputs.gallery.length > 0;
});

const canSubmit = computed(() => {
  return form.undangan_id &&
         form.type &&
         (hasImages.value || imagePreviews.hero.length > 0 ||
          imagePreviews.couple.length > 0 || imagePreviews.story.length > 0 ||
          imagePreviews.gallery.length > 0) &&
         !form.processing;
});

async function submit() {
  if (!canSubmit.value) {
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      icon: 'error',
      title: 'Lengkapi data terlebih dahulu'
    });
    return;
  }

  Swal.fire({
    title: 'Updating images...',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  // First, update the existing entry if we're not replacing the image
  if (!hasImages.value) {
    form.post(route('galeris.update', props.galeri.id), {
      onSuccess: () => {
        Swal.close();
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          icon: 'success',
          title: 'Foto galeri berhasil diperbarui'
        });
        router.visit(route('galeris.index'));
      },
      onError: () => {
        Swal.close();
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          icon: 'error',
          title: 'Gagal memperbarui foto galeri'
        });
      },
    });
    return;
  }

  let successCount = 0;
  let failCount = 0;
  const totalImages = Object.values(imageInputs).reduce((sum, arr) => sum + arr.length, 0);

  try {
    // First delete the existing entry
    await axios.delete(route('galeris.destroy', props.galeri.id), {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-Inertia': true,
        'Accept': 'text/html, application/xhtml+xml'
      }
    });

    // Then upload new images
    for (const category of Object.keys(imageInputs)) {
      if (imageInputs[category].length > 0) {
        const formData = new FormData();
        formData.append('undangan_id', form.undangan_id);
        formData.append('type', form.type);
        formData.append('category', category);

        // Append each image file to the FormData properly
        for (let i = 0; i < imageInputs[category].length; i++) {
          formData.append(`images[${i}]`, imageInputs[category][i]);
        }

        try {
          // Use Axios for file uploads with proper Inertia headers
          const response = await axios.post(route('galeris.store-batch'), formData, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'X-Inertia': true,
              'Accept': 'text/html, application/xhtml+xml'
            }
          });

          if (response.status >= 200 && response.status < 300) {
            successCount += imageInputs[category].length;
          } else {
            failCount += imageInputs[category].length;
          }
        } catch (error) {
          console.error('Error uploading images for category', category, error);
          failCount += imageInputs[category].length;
        }
      }
    }

    Swal.close();

    if (successCount > 0) {
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        icon: 'success',
        title: `${successCount} dari ${totalImages} foto berhasil diunggah`
      });

      if (failCount === 0) {
        router.visit(route('galeris.index'));
      }
    }

    if (failCount > 0) {
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        icon: 'error',
        title: `${failCount} foto gagal diunggah`
      });
    }
  } catch (error) {
    console.error('Error in submission:', error);
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      icon: 'error',
      title: 'Terjadi kesalahan saat mengunggah foto'
    });
  }
}
</script>

<template>
    <Head title="Edit Foto Galeri" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Edit Foto Galeri</h1>
            </div>

            <Card>
                <form @submit.prevent="submit">
                    <CardContent class="space-y-6">
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold border-b pb-2">Informasi Dasar</h2>

                            <div class="space-y-2">
                                <Label for="undangan_id">Undangan</Label>
                                <div class="relative" ref="dropdownRef">
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
                                <Label for="type">Type</Label>
                                <select
                                    id="type"
                                    v-model="form.type"
                                    class="w-full pl-4 pr-2 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-sm"
                                >
                                    <option value="">Pilih Type</option>
                                    <option v-for="typeOption in types" :key="typeOption.value" :value="typeOption.value">
                                        {{ typeOption.label }}
                                    </option>
                                </select>
                                <p v-if="form.errors.type" class="mt-1 text-sm text-red-500">{{ form.errors.type }}</p>
                            </div>
                        </div>

                        <div class="space-y-4 border-t pt-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-semibold">Hero (max 1 foto)</h2>
                                <Button type="button" variant="outline" size="sm" @click="removeAllImages('hero')" v-if="imagePreviews.hero.length">
                                    Clear All
                                </Button>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-center w-full">
                                    <label for="hero-image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" v-if="!imagePreviews.hero.length">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Upload Hero Image</span></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or GIF (max 2MB)</p>
                                        </div>
                                        <input id="hero-image" type="file" accept="image/*" @change="(e) => handleImageUpload(e, 'hero')" class="hidden" />
                                    </label>
                                </div>

                                <div v-if="imagePreviews.hero.length" class="grid grid-cols-1 gap-4 mt-4">
                                    <div v-for="(preview, index) in imagePreviews.hero" :key="`hero-${index}`" class="relative">
                                        <img :src="preview" class="h-40 w-full object-cover rounded-lg" alt="Hero Preview" />
                                        <button
                                            @click="removeImage('hero', index)"
                                            type="button"
                                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center"
                                        >
                                            &times;
                                        </button>
                                    </div>
                                </div>

                                <p v-if="imageErrors.hero" class="text-sm text-red-500">{{ imageErrors.hero }}</p>
                            </div>
                        </div>

                        <div class="space-y-4 border-t pt-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-semibold">Couple (max 2 foto)</h2>
                                <Button type="button" variant="outline" size="sm" @click="removeAllImages('couple')" v-if="imagePreviews.couple.length">
                                    Clear All
                                </Button>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-center w-full">
                                    <label for="couple-image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" v-if="!imagePreviews.couple.length">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Upload Couple Images</span></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Select up to 2 images (max 2MB each)</p>
                                        </div>
                                        <input id="couple-image" type="file" accept="image/*" @change="(e) => handleImageUpload(e, 'couple')" class="hidden" multiple />
                                    </label>
                                </div>

                                <div v-if="imagePreviews.couple.length" class="grid grid-cols-2 gap-4 mt-4">
                                    <div v-for="(preview, index) in imagePreviews.couple" :key="`couple-${index}`" class="relative">
                                        <img :src="preview" class="h-40 w-full object-cover rounded-lg" alt="Couple Preview" />
                                        <button
                                            @click="removeImage('couple', index)"
                                            type="button"
                                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center"
                                        >
                                            &times;
                                        </button>
                                    </div>
                                </div>

                                <p v-if="imageErrors.couple" class="text-sm text-red-500">{{ imageErrors.couple }}</p>
                            </div>
                        </div>

                        <div class="space-y-4 border-t pt-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-semibold">Story (max 3 foto)</h2>
                                <Button type="button" variant="outline" size="sm" @click="removeAllImages('story')" v-if="imagePreviews.story.length">
                                    Clear All
                                </Button>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-center w-full">
                                    <label for="story-image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" v-if="!imagePreviews.story.length">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Upload Story Images</span></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Select up to 3 images (max 2MB each)</p>
                                        </div>
                                        <input id="story-image" type="file" accept="image/*" @change="(e) => handleImageUpload(e, 'story')" class="hidden" multiple />
                                    </label>
                                </div>

                                <div v-if="imagePreviews.story.length" class="grid grid-cols-3 gap-4 mt-4">
                                    <div v-for="(preview, index) in imagePreviews.story" :key="`story-${index}`" class="relative">
                                        <img :src="preview" class="h-40 w-full object-cover rounded-lg" alt="Story Preview" />
                                        <button
                                            @click="removeImage('story', index)"
                                            type="button"
                                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center"
                                        >
                                            &times;
                                        </button>
                                    </div>
                                </div>

                                <p v-if="imageErrors.story" class="text-sm text-red-500">{{ imageErrors.story }}</p>
                            </div>
                        </div>

                        <div class="space-y-4 border-t pt-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-semibold">Gallery (max 6 foto)</h2>
                                <Button type="button" variant="outline" size="sm" @click="removeAllImages('gallery')" v-if="imagePreviews.gallery.length">
                                    Clear All
                                </Button>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-center w-full">
                                    <label for="gallery-image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6" v-if="!imagePreviews.gallery.length">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Upload Gallery Images</span></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Select up to 6 images (max 2MB each)</p>
                                        </div>
                                        <input id="gallery-image" type="file" accept="image/*" @change="(e) => handleImageUpload(e, 'gallery')" class="hidden" multiple />
                                    </label>
                                </div>

                                <div v-if="imagePreviews.gallery.length" class="grid grid-cols-3 gap-4 mt-4">
                                    <div v-for="(preview, index) in imagePreviews.gallery" :key="`gallery-${index}`" class="relative">
                                        <img :src="preview" class="h-40 w-full object-cover rounded-lg" alt="Gallery Preview" />
                                        <button
                                            @click="removeImage('gallery', index)"
                                            type="button"
                                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center"
                                        >
                                            &times;
                                        </button>
                                    </div>
                                </div>

                                <p v-if="imageErrors.gallery" class="text-sm text-red-500">{{ imageErrors.gallery }}</p>
                            </div>
                        </div>
                    </CardContent>
                    <CardFooter class="flex justify-between">
                        <Link :href="route('galeris.index')">
                            <Button type="button" variant="outline">Batal</Button>
                        </Link>
                        <Button
                            type="submit"
                            :disabled="!canSubmit"
                            :class="{'opacity-50 cursor-not-allowed': !canSubmit}"
                        >
                            Simpan Perubahan
                        </Button>
                    </CardFooter>
                </form>
            </Card>
        </div>
    </AppLayout>
</template>
