<script setup lang="ts">
  import Tr from './Tr.vue'
</script>

<template>
  <table class="w-full">
    <thead>
      <Tr>
        <slot name="headers" />
      </Tr>
    </thead>
    <tbody>
      <slot />
    </tbody>
  </table>
</template>
