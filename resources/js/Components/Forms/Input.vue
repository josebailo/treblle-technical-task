<script setup lang="ts">
  interface Props {
    modelValue: string
  }

  defineProps<Props>()

  defineEmits(['update:modelValue'])
</script>

<template>
  <input
    :value="modelValue"
    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
    @input="$emit('update:modelValue', $event.target.value)"
  >
</template>
