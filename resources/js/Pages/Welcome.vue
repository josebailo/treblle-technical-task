<script setup lang="ts">
  import { User } from '../types'

  defineProps<{
    user?: User
  }>()
</script>

<template>
  <p v-if="user">Hello {{ user.name }}!</p>
  <p v-else>Please, sign in or sign up yourself!</p>
</template>
