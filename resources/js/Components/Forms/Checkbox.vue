<script setup lang="ts">
  interface Props {
    modelValue: boolean
  }

  defineProps<Props>()

  defineEmits(['update:modelValue'])
</script>

<template>
  <input
    type="checkbox"
    :value="modelValue"
    class="focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
    @input="$emit('update:modelValue', Boolean($event.target.value))"
  >
</template>
