<script setup lang="ts">
  defineProps<{
    type: 'success' | 'error'
  }>()
  defineEmits(['close'])
</script>

<template>
  <div :class="[
    'mb-5 p-3 flex items-center justify-between gap-3 rounded',
    type === 'success' ? ' bg-emerald-200 text-emerald-900' : 'bg-red-200 text-red-900',
  ]">
    <p><slot /></p>
    <button type="button" class="text-2xl font-bold cursor-pointer" title="Close" @click="$emit('close')">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
      </svg>
    </button>
  </div>
</template>
