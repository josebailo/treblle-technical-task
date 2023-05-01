<script setup lang="ts">
  import Button from '../Components/Forms/Button.vue'
  import Error from '../Components/Forms/Error.vue'
  import Form from '../Components/Forms/Form.vue'
  import Input from '../Components/Forms/Input.vue'
  import PageHeader from '../Components/PageHeader.vue'
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
  <Form @submit.prevent="submit">
    <PageHeader>Change password</PageHeader>
    <div class="mt-5">
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
      <Button type="submit">Update</Button>
    </div>
  </Form>
</template>
