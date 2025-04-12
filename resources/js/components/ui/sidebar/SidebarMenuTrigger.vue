<script setup lang="ts">
defineProps<{
  class?: string
}>();
</script>

<template>
  <button type="button" :class="class">
    <slot />
  </button>
</template>
