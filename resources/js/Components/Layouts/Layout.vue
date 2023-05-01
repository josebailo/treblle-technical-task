<script setup lang="ts">
  import { Link } from '@inertiajs/vue3'
  import { ref, watch } from 'vue'
  import { FlashMessages, User } from '../../types'
  import Alert from '../Alert.vue'

  const props = defineProps<{
    flash: FlashMessages
    user: User
  }>()

  const showSuccessMessage = ref(false)
  const showErrorMessage = ref(false)

  watch(() => props.flash.success, () => showSuccessMessage.value = true)
  watch(() => props.flash.error, () => showErrorMessage.value = true)
</script>

<template>
  <header class="bg-white shadow">
    <div class="container mx-auto py-3 flex justify-between items-center">
      <h1 class="text-blue-800 text-3xl font-bold">
        <Link href="/">Treblle Task</Link>
      </h1>
      <div class="flex items-center gap-4">
        <template v-if="user">
          <Link href="/profile">Profile</Link>
          <Link href="/password">Change password</Link>
          <Link href="/tokens">API Tokens</Link>
          <Link href="/signout" method="post" as="button">Sign out</Link>
        </template>
        <template v-else>
          <Link href="/signin">Sign in</Link>
          <Link href="/signup">Sign up</Link>
        </template>
      </div>
    </div>
  </header>

  <main class="container mx-auto mt-5">
    <Alert v-if="flash.success && showSuccessMessage" type="success" @close="showSuccessMessage = false">{{ flash.success }}</Alert>
    <Alert v-if="flash.error && showErrorMessage" type="error" @close="showErrorMessage = false">{{ flash.error }}</Alert>

    <slot />
  </main>
</template>
