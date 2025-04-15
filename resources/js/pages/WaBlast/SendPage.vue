<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { SearchIcon } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps({
  tamu: Object,
  filters: Object
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'WaBlast',
        href: '/wablast',
    },
    {
        title: 'Send',
        href: '/wablast/send',
    },
];

// Search functionality
const search = ref(props.filters?.search || '');

// Use debounce to avoid too many requests while typing
const debouncedSearch = debounce(() => {
  router.get(route('wablast.send'), { search: search.value }, {
    preserveState: true,
    preserveScroll: true,
    replace: true
  });
}, 500);

watch(search, debouncedSearch);
</script>

<template>
    <Head title="WA Blast - Send" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap items-center justify-end gap-4">
                        <div class="relative w-full md:w-auto md:min-w-[300px]">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <SearchIcon class="h-4 w-4 text-gray-400" />
                            </div>
                            <input
                                v-model="search"
                                type="text"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-900 text-sm"
                                placeholder="Cari nama tamu..."
                            />
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider w-12">No.</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Tamu</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No. WA</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Undangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr v-for="(item, index) in tamu?.data" :key="item.id" class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-4 py-2 whitespace-nowrap text-sm">{{ tamu.from + index }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm">{{ item.nama_tamu }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm">{{ item.no_wa || '-' }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                  {{ item.undangan ? `${item.undangan.nama_mempelai_1} & ${item.undangan.nama_mempelai_2}` : '-' }}
                                </td>
                            </tr>
                            <tr v-if="!tamu?.data || tamu.data.length === 0">
                                <td colspan="4" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data tamu
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="tamu?.data?.length" class="px-6 py-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            Showing
                            <span class="font-medium mx-1">{{ tamu.from || 0 }}</span>
                            to
                            <span class="font-medium mx-1">{{ tamu.to || 0 }}</span>
                            of
                            <span class="font-medium mx-1">{{ tamu.total }}</span>
                            results
                        </div>

                        <nav class="flex flex-wrap justify-center gap-2" aria-label="Pagination">
                            <template v-for="(link, key) in tamu.links" :key="key">
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
