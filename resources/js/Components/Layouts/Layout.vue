<script setup lang="ts">
  import { Link } from '@inertiajs/vue3'
  import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
  import { ChevronDownIcon } from '@heroicons/vue/20/solid'
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
    <div class="container mx-auto px-2 py-3 flex justify-between items-center">
      <h1 class="text-blue-800 text-3xl font-bold">
        <Link href="/">Treblle Task</Link>
      </h1>
      <div class="flex items-center gap-4">
        <template v-if="user">
          <Menu as="div" class="relative inline-block text-left">
            <MenuButton
              class="inline-flex items-center gap-1 w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-500 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-2"
            >
              Menu
              <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
            </MenuButton>

            <transition
              enter-active-class="transition duration-100 ease-out"
              enter-from-class="transform scale-95 opacity-0"
              enter-to-class="transform scale-100 opacity-100"
              leave-active-class="transition duration-75 ease-in"
              leave-from-class="transform scale-100 opacity-100"
              leave-to-class="transform scale-95 opacity-0"
            >
              <MenuItems
                class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-md ring-1 ring-black ring-opacity-5 focus:outline-none"
              >
                <div class="px-1 py-1">
                  <MenuItem v-slot="{ active }">
                    <Link href="/profile" :class="[active ? 'bg-blue-500 text-white' : 'text-gray-900', 'group flex w-full items-center rounded-md px-2 py-2 text-sm']">
                      Update profile
                    </Link>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <Link href="/password" :class="[active ? 'bg-blue-500 text-white' : 'text-gray-900', 'group flex w-full items-center rounded-md px-2 py-2 text-sm']">
                      Update password
                    </Link>
                  </MenuItem>
                </div>
                <div class="px-1 py-1">
                  <MenuItem v-slot="{ active }">
                    <Link href="/tokens" :class="[active ? 'bg-blue-500 text-white' : 'text-gray-900', 'group flex w-full items-center rounded-md px-2 py-2 text-sm']">
                      API Tokens
                    </Link>
                  </MenuItem>
                </div>
                <div class="px-1 py-1">
                  <MenuItem v-slot="{ active }">
                    <Link href="/signout" method="post" as="button" :class="[active ? 'bg-blue-500 text-white' : 'text-gray-900', 'group flex w-full items-center rounded-md px-2 py-2 text-sm']">
                      Sign out
                    </Link>
                  </MenuItem>
                </div>
              </MenuItems>
            </transition>
          </Menu>
        </template>
        <template v-else>
          <Link href="/signin" class="hover:text-blue-700">Sign in</Link>
          <Link href="/signup" class="hover:text-blue-700">Sign up</Link>
        </template>
      </div>
    </div>
  </header>

  <main class="container mx-auto mt-5 px-2">
    <Alert v-if="flash.success && showSuccessMessage" type="success" @close="showSuccessMessage = false">{{ flash.success }}</Alert>
    <Alert v-if="flash.error && showErrorMessage" type="error" @close="showErrorMessage = false">{{ flash.error }}</Alert>

    <slot />
  </main>
</template>
