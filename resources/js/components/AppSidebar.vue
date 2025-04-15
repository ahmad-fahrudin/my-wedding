<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { MessageSquareMore, Folder, LayoutGrid, Image, Album, Users, Send, ScanQrCode  } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

// Perbarui struktur NavItem untuk mendukung label
interface NavSection {
    label?: string;
    items: NavItem[];
}

const mainNavSections: NavSection[] = [
    {
        items: [
            {
                title: 'Dashboard',
                href: '/dashboard',
                icon: LayoutGrid,
            }
        ]
    },
    {
        label: 'Manajemen Undangan',
        items: [
            {
                title: 'Undangan',
                href: '/undangans',
                icon: Album,
            },
            {
                title: 'Tamu',
                href: '/tamus',
                icon: Users,
            },
            {
                title: 'Lihat Hasil',
                href: '/undangans/contents',
                icon: Folder,
            }
        ]
    },
    {
        label: 'Media',
        items: [
            {
                title: 'Galeri',
                href: '/galeris',
                icon: Image,
            }
        ]
    },
    {
        label: 'Komunikasi',
        items: [
            {
                title: 'Whatsapp',
                icon: MessageSquareMore,
                children: [
                    {
                        title: 'Daftar Device',
                        href: '/setup',
                        icon: ScanQrCode,
                    },
                    {
                        title: 'Kirim Pesan',
                        href: '/send-page',
                        icon: Send,
                    }
                ]
            }
        ]
    }
];

const footerNavItems: NavItem[] = [
//
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <div v-for="(section, index) in mainNavSections" :key="'section-'+index" class="mb-2">
                <div v-if="section.label" class="px-3 py-1 text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ section.label }}
                </div>
                <NavMain :items="section.items" />
            </div>
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
