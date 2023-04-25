<script setup lang="ts">
  import Error from '../Components/Forms/Error.vue'
  import Input from '../Components/Forms/Input.vue'
  import { useForm } from '@inertiajs/vue3'

  const form = useForm({
    password: '',
    new_password: '',
    new_password_confirmation: '',
  })

  const submit = () => {
    form.post('password')
  }
</script>

<template>
  <form @submit.prevent="submit" class="bg-white w-full max-w-sm m-auto p-5 rounded-md border border-gray-300 shadow-sm">
    <div>
      <label for="password" class="block">Password</label>
      <Input type="password" id="password" v-model="form.password" class="mt-2" required />
      <Error v-if="form.errors.password" class="mt-2">{{ form.errors.password }}</Error>
    </div>
    <div class="mt-5">
      <label for="new_password" class="block">New password</label>
      <Input type="password" id="new_password" v-model="form.new_password" class="mt-2" required />
      <Error v-if="form.errors.new_password" class="mt-2">{{ form.errors.new_password }}</Error>
    </div>
    <div class="mt-5">
      <label for="new_password_confirmation" class="block">Confirm new password</label>
      <Input type="password" id="new_password_confirmation" v-model="form.new_password_confirmation" class="mt-2" required />
      <Error v-if="form.errors.new_password_confirmation" class="mt-2">{{ form.errors.new_password_confirmation }}</Error>
    </div>
    <div class="mt-5 text-right">
      <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-2">Update</button>
    </div>
  </form>
</template>
