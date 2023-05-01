<script setup lang="ts">
  import Button from '../Components/Forms/Button.vue'
  import Error from '../Components/Forms/Error.vue'
  import Form from '../Components/Forms/Form.vue'
  import Input from '../Components/Forms/Input.vue'
  import PageHeader from '../Components/PageHeader.vue'
  import { useForm } from '@inertiajs/vue3'

  const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  })

  const submit = () => {
    form.post('signup')
  }
</script>

<template>
  <Form @submit.prevent="submit">
    <PageHeader>Sign up</PageHeader>
    <div class="mt-5">
      <label for="name" class="block">Name</label>
      <Input type="text" id="name" v-model="form.name" class="mt-2" required />
      <Error v-if="form.errors.name" class="mt-2">{{ form.errors.name }}</Error>
    </div>
    <div class="mt-5">
      <label for="email" class="block">Email</label>
      <Input type="email" id="email" v-model="form.email" class="mt-2" required />
      <Error v-if="form.errors.email" class="mt-2">{{ form.errors.email }}</Error>
    </div>
    <div class="mt-5">
      <label for="password" class="block">Password</label>
      <Input type="password" id="password" v-model="form.password" class="mt-2" required />
      <Error v-if="form.errors.password" class="mt-2">{{ form.errors.password }}</Error>
    </div>
    <div class="mt-5">
      <label for="password_confirmation" class="block">Confirm password</label>
      <Input type="password" id="password_confirmation" v-model="form.password_confirmation" class="mt-2" required />
      <Error v-if="form.errors.password_confirmation" class="mt-2">{{ form.errors.password_confirmation }}</Error>
    </div>
    <div class="mt-5 text-right">
      <Button type="submit">Sign up</Button>
    </div>
  </Form>
</template>
