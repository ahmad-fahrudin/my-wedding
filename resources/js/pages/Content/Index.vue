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
  image: null,
  tema: 'tema1', // Default value for theme
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
  form.post(route('content.store'), {
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
    <Head title="Hasil Undangan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Hasil Undangan</h1>
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
    </AppLayout>
</template>
