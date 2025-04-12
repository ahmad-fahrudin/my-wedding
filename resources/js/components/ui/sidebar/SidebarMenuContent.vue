<script setup lang="ts">
defineProps<{
  class?: string
}>();
</script>

<template>
  <div :class="class">
    <slot />
  </div>
</template>
