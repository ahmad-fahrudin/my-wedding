<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { PlusIcon, PencilIcon, TrashIcon, SearchIcon, FilterIcon } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import { ref, watch } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps({
  galeris: Object,
  filters: Object,
  types: Array,
  categories: Array,
  undangans: Object
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Galeri',
        href: '/galeris',
    },
];

// Search and filter functionality
const search = ref(props.filters?.search || '');
const selectedType = ref(props.filters?.type || '');
const selectedCategory = ref(props.filters?.category || '');

// Use debounce to avoid too many requests while typing
const debouncedSearch = debounce(() => {
  applyFilters();
}, 500);

watch(search, debouncedSearch);

// Apply filters immediately when dropdowns change
watch(selectedType, applyFilters);
watch(selectedCategory, applyFilters);

function applyFilters() {
  const filters = {
    search: search.value,
    type: selectedType.value,
    category: selectedCategory.value,
  };

  // Remove empty filters
  Object.keys(filters).forEach(key => {
    if (!filters[key]) delete filters[key];
  });

  // Use router.get to apply the filters
  router.get(route('galeris.index'), filters, {
    preserveState: true,
    preserveScroll: true,
    replace: true
  });
}

function clearFilters() {
  search.value = '';
  selectedType.value = '';
  selectedCategory.value = '';
  applyFilters();
}

function deleteGaleri(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(route('galeris.destroy', id), {
        onSuccess: () => {
          Swal.fire(
            'Deleted!',
            'Foto galeri has been deleted.',
            'success'
          );
        },
        onError: () => {
          Swal.fire(
            'Error!',
            'There was a problem deleting the foto galeri.',
            'error'
          );
        }
      });
    }
  });
}

// Helper to get the label from value
function getTypeLabel(value) {
  const type = props.types?.find(t => t.value === value);
  return type ? type.label : value;
}

function getCategoryLabel(value) {
  const category = props.categories?.find(c => c.value === value);
  return category ? category.label : value;
}
</script>

<template>
    <Head title="Daftar Galeri" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Daftar Foto Galeri</h1>
                <Link :href="route('galeris.create')">
                    <Button variant="default" class="flex items-center gap-2">
                        <PlusIcon class="h-4 w-4" />
                        Tambah Foto
                    </Button>
                </Link>
            </div>

            <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center">
                            <Button
                                variant="outline"
                                size="sm"
                                @click="clearFilters"
                                class="mr-2"
                                :disabled="!search && !selectedType && !selectedCategory"
                            >
                                Clear Filters
                            </Button>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <!-- Type Filter -->
                            <div class="w-full md:w-auto">
                                <select
                                    v-model="selectedType"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-sm"
                                >
                                    <option value="">All Types</option>
                                    <option v-for="type in types" :key="type.value" :value="type.value">
                                        {{ type.label }}
                                    </option>
                                </select>
                            </div>

                            <!-- Category Filter -->
                            <div class="w-full md:w-auto">
                                <select
                                    v-model="selectedCategory"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-sm"
                                >
                                    <option value="">All Categories</option>
                                    <option v-for="category in categories" :key="category.value" :value="category.value">
                                        {{ category.label }}
                                    </option>
                                </select>
                            </div>

                            <!-- Search Box -->
                            <div class="relative w-full md:w-auto md:min-w-[300px]">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <SearchIcon class="h-4 w-4 text-gray-400" />
                                </div>
                                <input
                                    v-model="search"
                                    type="text"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-sm"
                                    placeholder="Cari galeri..."
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-12">No.</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Foto</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Undangan</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr v-for="(item, index) in galeris.data" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-4 py-2 whitespace-nowrap text-sm">{{ galeris.from + index }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                    <img :src="item.image" alt="Gallery Image" class="w-16 h-16 object-cover rounded" />
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                    {{ item.undangan ? `${item.undangan.nama_mempelai_1} & ${item.undangan.nama_mempelai_2}` : '-' }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                    <span v-if="item.type" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                        {{ getTypeLabel(item.type) }}
                                    </span>
                                    <span v-else>-</span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                    <span v-if="item.category" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                        {{ getCategoryLabel(item.category) }}
                                    </span>
                                    <span v-else>-</span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <div class="flex space-x-1">
                                        <Link :href="route('galeris.edit', item.id)">
                                            <Button variant="outline" size="sm" class="h-7 w-7 p-0">
                                                <PencilIcon class="h-3.5 w-3.5" />
                                                <span class="sr-only">Edit</span>
                                            </Button>
                                        </Link>
                                        <Button
                                            variant="outline"
                                            size="sm"
                                            class="h-7 w-7 p-0 text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300"
                                            @click="deleteGaleri(item.id)"
                                        >
                                            <TrashIcon class="h-3.5 w-3.5" />
                                            <span class="sr-only">Delete</span>
                                        </Button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="galeris.data.length === 0">
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada foto galeri
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            Showing
                            <span class="font-medium mx-1">{{ galeris.from || 0 }}</span>
                            to
                            <span class="font-medium mx-1">{{ galeris.to || 0 }}</span>
                            of
                            <span class="font-medium mx-1">{{ galeris.total }}</span>
                            results
                        </div>

                        <nav class="flex flex-wrap justify-center gap-2" aria-label="Pagination">
                            <template v-for="(link, key) in galeris.links" :key="key">
                                <template v-if="link.label !== '&hellip;'">
                                    <Link
                                        v-if="link.url"
                                        :href="link.url"
                                        class="px-3 py-1 rounded border text-sm font-medium"
                                        :class="{
                                            'bg-blue-500 text-white border-blue-500 hover:bg-blue-600': link.active,
                                            'bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800': !link.active
                                        }"
                                        :preserve-scroll="true"
                                        :preserve-state="true"
                                    >
                                        <span v-if="link.label === '&laquo; Previous'">Previous</span>
                                        <span v-else-if="link.label === 'Next &raquo;'">Next</span>
                                        <span v-else v-html="link.label"></span>
                                    </Link>
                                    <span
                                        v-else
                                        class="px-3 py-1 rounded border text-sm font-medium text-gray-400 bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700 cursor-not-allowed"
                                    >
                                        <span v-if="link.label === '&laquo; Previous'">Previous</span>
                                        <span v-else-if="link.label === 'Next &raquo;'">Next</span>
                                        <span v-else v-html="link.label"></span>
                                    </span>
                                </template>
                                <span
                                    v-else
                                    class="px-3 py-1 rounded border text-sm font-medium text-gray-400 bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-700"
                                >
                                    ...
                                </span>
                            </template>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
