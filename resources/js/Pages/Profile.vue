<script setup lang="ts">
  import Error from '../Components/Forms/Error.vue'
  import Input from '../Components/Forms/Input.vue'
  import { useForm } from '@inertiajs/vue3'
  import { User } from '../types'

  const { user } = defineProps<{
    user: User
  }>()

  const form = useForm({
    name: user.name,
    email: user.email,
  })

  const submit = () => {
    form.post('profile')
  }
</script>

<template>
  <form @submit.prevent="submit" class="bg-white w-full max-w-sm m-auto p-5 rounded-md border border-gray-300 shadow-sm">
    <div>
      <label for="name" class="block">Name</label>
      <Input type="text" id="name" v-model="form.name" class="mt-2" required />
      <Error v-if="form.errors.name" class="mt-2">{{ form.errors.name }}</Error>
    </div>
    <div class="mt-5">
      <label for="email" class="block">Email</label>
      <Input type="email" id="email" v-model="form.email" class="mt-2" required />
      <Error v-if="form.errors.email" class="mt-2">{{ form.errors.email }}</Error>
    </div>
    <div class="mt-5 text-right">
      <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-2">Update</button>
    </div>
  </form>
</template>
