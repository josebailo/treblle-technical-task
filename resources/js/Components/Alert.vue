<script setup lang="ts">
  import { XMarkIcon } from '@heroicons/vue/20/solid'

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
      <XMarkIcon class="w-5 h-5" />
    </button>
  </div>
</template>
