<script setup lang="ts">
  import Button from '../Components/Forms/Button.vue'
  import Checkbox from '../Components/Forms/Checkbox.vue'
  import Error from '../Components/Forms/Error.vue'
  import Form from '../Components/Forms/Form.vue'
  import Input from '../Components/Forms/Input.vue'
  import PageHeader from '../Components/PageHeader.vue'
  import { useForm } from '@inertiajs/vue3'

  const form = useForm({
    email: '',
    password: '',
    remember: false,
  })

  const submit = () => {
    form.post('signin')
  }
</script>

<template>
  <Form @submit.prevent="submit">
    <PageHeader>Sign in</PageHeader>
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
    <div class="mt-5 flex items-center gap-2">
      <Checkbox type="checkbox" id="remember" v-model="form.remember" />
      <label for="remember" class="block">Remember me</label>
    </div>
    <div class="mt-5 text-right">
      <Button type="submit">Log in</Button>
    </div>
  </Form>
</template>
