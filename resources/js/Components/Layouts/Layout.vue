<script setup lang="ts">
  import { Link } from '@inertiajs/vue3'
  import { User } from '../../types'

  const { user } = defineProps<{
    user: User
  }>()
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
    <slot />
  </main>
</template>
