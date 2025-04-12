<script setup lang="ts">
import { SidebarMenu, SidebarMenuItem, SidebarMenuButton } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
  items: NavItem[]
}>();

const openDropdowns = ref<Record<string, boolean>>({});

const toggleDropdown = (title: string) => {
  openDropdowns.value[title] = !openDropdowns.value[title];
};
</script>

<template>
  <SidebarMenu>
    <SidebarMenuItem v-for="item in items" :key="item.title" :value="item.title">
      <!-- For items with children (dropdown) -->
      <template v-if="item.children">
        <!-- Make this look like a regular menu button but trigger dropdown -->
        <SidebarMenuButton
          @click="toggleDropdown(item.title)"
          class="w-full flex items-center justify-between"
        >
          <div class="flex items-center gap-4">
            <component :is="item.icon" class="h-4 w-4" />
            <span>{{ item.title }}</span>
          </div>
          <span class="transition-transform" :class="{ 'rotate-180': openDropdowns[item.title] }">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m6 9 6 6 6-6"/>
            </svg>
          </span>
        </SidebarMenuButton>

        <div
          v-show="openDropdowns[item.title]"
          class="pl-6 mt-2 space-y-1"
        >
          <SidebarMenuItem v-for="child in item.children" :key="child.title" :value="child.title">
            <SidebarMenuButton asChild size="sm">
              <Link :href="child.href" class="flex items-center gap-4">
                <component :is="child.icon" class="h-4 w-4" />
                <span>{{ child.title }}</span>
              </Link>
            </SidebarMenuButton>
          </SidebarMenuItem>
        </div>
      </template>

      <!-- Regular menu items without dropdown -->
      <template v-else>
        <SidebarMenuButton asChild>
          <Link :href="item.href" class="flex items-center gap-4">
            <component :is="item.icon" class="h-4 w-4" />
            <span>{{ item.title }}</span>
          </Link>
        </SidebarMenuButton>
      </template>
    </SidebarMenuItem>
  </SidebarMenu>
</template>
