<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { SearchIcon } from 'lucide-vue-next';
import { ref, watch, computed } from 'vue';
import debounce from 'lodash/debounce';
import Swal from 'sweetalert2';
import axios from 'axios';

const props = defineProps({
  tamu: Object,
  filters: Object,
  currentMessage: {
    type: String,
    default: '',
  }
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

// Form for message template
const form = useForm({
  message: props.currentMessage || '',
});

const charCount = computed(() => {
  return form.message ? form.message.length : 0;
});

// Preview functionality
const previewTamu = ref('Nama Tamu');
const previewTime = computed(() => {
  const now = new Date();
  return now.getHours() + ':' + now.getMinutes().toString().padStart(2, '0');
});

const formattedMessage = computed(() => {
  if (!form.message) return 'Pesan preview akan muncul di sini';
  return form.message.replace(/{nama_tamu}/g, previewTamu.value);
});

const saveMessage = () => {
    form.post(route('blast.message.store'), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Template pesan berhasil disimpan!',
                timer: 1500,
                showConfirmButton: false,
            });
        },
    });
};

// Toggle form visibility
const isFormVisible = ref(true);
const toggleForm = () => {
  isFormVisible.value = !isFormVisible.value;
};

// Search functionality
const search = ref(props.filters?.search || '');

// Use debounce to avoid too many requests while typing
const debouncedSearch = debounce(() => {
  router.get(route('blast.send'), { search: search.value }, {
    preserveState: true,
    preserveScroll: true,
    replace: true
  });
}, 500);

watch(search, debouncedSearch);

// Send message functionality
const isSending = ref({});

// Add bulk sending state
const isBulkSending = ref(false);

// Bulk send functionality
const sendBulkMessages = async () => {
  if (!form.message) {
    Swal.fire({
      icon: 'error',
      title: 'Pesan Kosong',
      text: 'Template pesan tidak boleh kosong!',
      timer: 2000,
      showConfirmButton: false,
    });
    return;
  }

  // Confirmation dialog
  const result = await Swal.fire({
    title: 'Kirim Pesan Massal',
    text: `Kirim pesan ke ${props.tamu?.total || 0} tamu yang ditampilkan?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Kirim',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33'
  });

  if (!result.isConfirmed) {
    return;
  }

  // Set loading state
  isBulkSending.value = true;

  try {
    // Send request with current filters
    const response = await axios.post(route('blast.send.bulk'), {
      search: search.value,
      // Add any other filters here
    });

    if (response.data.success) {
      Swal.fire({
        icon: 'success',
        title: 'Pesan Terkirim',
        text: `${response.data.message}`,
        timer: 3000,
        showConfirmButton: false,
      });
    } else {
      throw new Error(response.data.message || 'Gagal mengirim beberapa pesan');
    }
  } catch (error) {
    console.error('Error sending bulk messages:', error);
    Swal.fire({
      icon: 'error',
      title: 'Gagal Mengirim Pesan Massal',
      text: error.response?.data?.message || 'Gagal mengirim pesan WhatsApp secara massal',
      timer: 3000,
      showConfirmButton: false,
    });
  } finally {
    // Clear loading state
    isBulkSending.value = false;
  }
};

const sendMessage = async (tamuId) => {
  // Set loading state for this specific tamu
  isSending.value[tamuId] = true;

  try {
    const response = await axios.post(route('blast.send.message'), {
      tamuId: tamuId
    });

    if (response.data.success) {
      Swal.fire({
        icon: 'success',
        title: 'Pesan Terkirim',
        text: 'Pesan WhatsApp berhasil dikirim!',
        timer: 2000,
        showConfirmButton: false,
      });
    } else {
      throw new Error(response.data.message || 'Gagal mengirim pesan');
    }
  } catch (error) {
    console.error('Error sending message:', error);
    Swal.fire({
      icon: 'error',
      title: 'Gagal Mengirim',
      text: error.response?.data?.message || 'Gagal mengirim pesan WhatsApp',
      timer: 3000,
      showConfirmButton: false,
    });
  } finally {
    // Clear loading state
    isSending.value[tamuId] = false;
  }
};
</script>

<template>
    <Head title="WA Blast - Send" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- Message Template Form -->
            <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <div class="bg-gradient-to-r from-gray-900 to-gray-700 text-white px-6 py-4 rounded-t-xl flex justify-between items-center">
                    <h2 class="text-xl font-semibold">Template Pesan WhatsApp</h2>
                    <button
                        @click="toggleForm"
                        class="text-white hover:bg-gray-200 hover:text-gray-900 rounded-full p-2 transition-colors"
                        :title="isFormVisible ? 'Sembunyikan Form' : 'Tampilkan Form'"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="{'rotate-180': !isFormVisible}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <div v-if="isFormVisible" class="p-6 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                    <form @submit.prevent="saveMessage">
                        <!-- Variables Reference -->
                        <div class="mb-3 text-sm text-gray-500 dark:text-gray-400">
                            <p>Gunakan variabel berikut untuk mengisi data dinamis:</p>
                            <ul class="list-disc ml-5 mt-2 flex flex-wrap gap-x-6">
                                <li><code class="bg-gray-200 dark:bg-gray-800 px-2 py-1 rounded">{nama_tamu}</code> - Nama penerima</li>
                            </ul>
                        </div>

                        <!-- Two-column layout -->
                        <div class="flex flex-col lg:flex-row gap-6">
                            <!-- Left Column - Textarea Full Height -->
                            <div class="flex-1 flex flex-col min-w-0">
                                <label for="message" class="block text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">Tulis Template Pesan</label>
                                <div class="flex-1 flex flex-col">
                                    <textarea
                                        id="message"
                                        v-model="form.message"
                                        rows="12"
                                        class="flex-1 min-h-[300px] block w-full rounded-md border-gray-400 dark:border-gray-700 shadow-sm focus:border-gray-900 focus:ring-gray-900 dark:bg-gray-800 dark:text-gray-100 sm:text-sm bg-white text-gray-900"
                                        placeholder="Tulis pesan untuk undangan di sini..."
                                        :disabled="form.processing"
                                    ></textarea>
                                    <div v-if="form.errors.message" class="text-sm text-red-600 mt-1">{{ form.errors.message }}</div>
                                </div>

                                <!-- Character Count and Save Button -->
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ charCount }}/1000 karakter</div>
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-gray-900 dark:border-gray-100 shadow-sm text-sm font-medium rounded-md text-white bg-gray-900 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 dark:bg-gray-100 dark:text-gray-900 dark:hover:bg-gray-300"
                                        :disabled="form.processing"
                                    >
                                        <span v-if="form.processing">
                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white dark:text-gray-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Menyimpan...
                                        </span>
                                        <span v-else>Simpan Template</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Right Column - Mobile Preview Only -->
                            <div class="lg:w-[320px] flex flex-col">
                                <div class="mb-3 flex justify-between items-center">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preview Mobile:</label>
                                    <div class="flex items-center">
                                        <label class="text-xs text-gray-500 dark:text-gray-400 mr-2">Nama:</label>
                                        <input
                                            v-model="previewTamu"
                                            type="text"
                                            class="text-xs rounded-md border-gray-400 dark:border-gray-700 shadow-sm focus:border-gray-900 focus:ring-gray-900 dark:bg-gray-800 dark:text-gray-100 bg-white text-gray-900 py-1 px-2 w-32"
                                            placeholder="Nama tamu"
                                        />
                                    </div>
                                </div>

                                <!-- Phone Frame -->
                                <div class="phone-frame bg-gray-800 rounded-[36px] p-3 shadow-lg mx-auto">
                                    <!-- Phone Screen -->
                                    <div class="phone-screen bg-white dark:bg-gray-900 rounded-[28px] overflow-hidden h-[540px] flex flex-col">
                                        <!-- WhatsApp Header -->
                                        <div class="whatsapp-header bg-[#128C7E] text-white px-4 py-2">
                                            <div class="flex items-center">
                                                <div class="mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                                    </svg>
                                                </div>
                                                <div class="flex items-center">
                                                    <!-- Avatar Circle -->
                                                    <div class="w-9 h-9 rounded-full bg-gray-300 mr-3 flex items-center justify-center text-[#128C7E] font-bold">
                                                        {{ previewTamu.charAt(0) || '?' }}
                                                    </div>
                                                    <div>
                                                        <div class="font-medium">{{ previewTamu || 'Nama Tamu' }}</div>
                                                        <div class="text-xs opacity-80">online</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Chat Background -->
                                        <div class="flex-1 bg-[#E5DDD5] dark:bg-gray-800 p-3 overflow-y-auto">
                                            <!-- Chat Bubble -->
                                            <div class="flex justify-end mb-4">
                                                <div class="bg-[#DCF8C6] dark:bg-[#056162] text-gray-800 dark:text-white rounded-lg py-2 px-3 max-w-[90%] relative chat-bubble">
                                                    <div class="whitespace-pre-wrap text-sm break-words">{{ formattedMessage }}</div>
                                                    <div class="text-right mt-1">
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ previewTime }}</span>
                                                        <span class="ml-1 text-gray-500 dark:text-gray-400">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Chat Input -->
                                        <div class="whatsapp-input bg-white dark:bg-gray-900 p-2 flex items-center gap-2">
                                            <div class="rounded-full bg-gray-100 dark:bg-gray-800 p-2 flex-1 text-xs text-gray-400">Ketik pesan</div>
                                            <div class="text-[#128C7E] rounded-full p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14v-4H8c-.55 0-1-.45-1-1s.45-1 1-1h3V6c0-.55.45-1 1-1s1 .45 1 1v4h3c.55 0 1 .45 1 1s-.45 1-1 1h-3v4c0 .55-.45 1-1 1s-1-.45-1-1z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tamu Table -->
            <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Tamu</h2>
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
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
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
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-center">
                                    <button
                                        @click="sendMessage(item.id)"
                                        class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50"
                                        :disabled="!form.message || !item.no_wa || isSending[item.id]"
                                        title="Kirim pesan WhatsApp"
                                    >
                                        <template v-if="isSending[item.id]">
                                            <svg class="animate-spin inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </template>
                                        <template v-else>
                                            <i class="fas fa-paper-plane"></i> Kirim
                                        </template>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!tamu?.data || tamu.data.length === 0">
                                <td colspan="5" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data tamu
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Bulk Send Button -->
                <div class="px-6 py-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    <button
                        @click="sendBulkMessages"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                        :disabled="isBulkSending || !form.message"
                        title="Kirim pesan massal"
                    >
                        <template v-if="isBulkSending">
                            <svg class="animate-spin inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mengirim...
                        </template>
                        <template v-else>
                            <i class="fas fa-paper-plane"></i> Kirim Pesan Massal
                        </template>
                    </button>
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

<style scoped>
code {
  font-family: monospace;
}
.phone-frame {
  width: 300px;
  height: 600px;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
  border: 8px solid #333;
}
.phone-screen {
  width: 100%;
}
.chat-bubble {
  position: relative;
}
.chat-bubble::after {
  content: "";
  position: absolute;
  right: -8px;
  top: 10px;
  width: 0;
  height: 0;
  border-left: 10px solid #DCF8C6;
  border-top: 6px solid transparent;
  border-bottom: 6px solid transparent;
}
.dark .chat-bubble::after {
  border-left-color: #056162;
}

/* WhatsApp styling */
.whatsapp-header {
  background-color: #128C7E;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.whatsapp-input {
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}

/* Mobile responsiveness */
@media (max-width: 768px) {
  .phone-frame {
    width: 280px;
    height: 560px;
  }
}
@media (max-width: 640px) {
  .phone-frame {
    width: 260px;
    height: 520px;
  }
}
</style>
