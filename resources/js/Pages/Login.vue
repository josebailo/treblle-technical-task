<script setup lang="ts">
  import Checkbox from '../Components/Forms/Checkbox.vue'
  import Error from '../Components/Forms/Error.vue'
  import Input from '../Components/Forms/Input.vue'
  import { useForm } from '@inertiajs/vue3'

  const form = useForm({
    email: '',
    password: '',
    remember: false,
  })

  const submit = () => {
    form.post('login')
  }
</script>

<template>
  <form @submit.prevent="submit" class="bg-white w-full max-w-sm m-auto p-5 rounded-md border border-gray-300 shadow-sm">
    <div>
      <label for="email" class="block">Email</label>
      <Input type="email" id="email" v-model="form.email" class="mt-2" required />
      <Error v-if="form.errors.email" class="mt-2">{{ form.errors.email }}</Error>
    </div>
    <div class="mt-5">
      <label for="password" class="block">Password</label>
      <Input type="password" id="password" v-model="form.password" class="mt-2" required />
      <Error v-if="form.errors.password" class="mt-2">{{ form.errors.password }}</Error>
    </div>
    <div class="mt-5 flex items-center gap-2">
      <Checkbox type="checkbox" id="remember" v-model="form.remember" />
      <label for="remember" class="block">Remember me</label>
    </div>
    <div class="mt-5 text-right">
      <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-2">Log in</button>
    </div>
  </form>
</template>
