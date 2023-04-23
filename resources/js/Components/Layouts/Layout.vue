<script setup lang="ts">
  import { Link, usePage } from '@inertiajs/vue3'
  import { computed } from 'vue'

  const user = computed(() => usePage()?.props?.auth?.user)
</script>

<template>
  <header class="bg-white shadow">
    <div class="container mx-auto py-3 flex justify-between items-center">
      <h1 class="text-blue-800 text-3xl font-bold">
        <Link href="/">Treblle Task</Link>
      </h1>
      <div class="flex items-center gap-4">
        <template v-if="user">
          <Link href="/logout" method="post" as="button">Logout</Link>
        </template>
        <template v-else>
          <Link href="/login">Login</Link>
          <Link href="/register">Sign up</Link>
        </template>
      </div>
    </div>
  </header>
  <main class="container mx-auto mt-5">
    <slot />
  </main>
</template>
