<script setup lang="ts">
  import Button from '../Components/Forms/Button.vue'
  import Error from '../Components/Forms/Error.vue'
  import Form from '../Components/Forms/Form.vue'
  import Input from '../Components/Forms/Input.vue'
  import PageHeader from '../Components/PageHeader.vue'
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
  <Form @submit.prevent="submit">
    <PageHeader>Update profile</PageHeader>
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
    <div class="mt-5 text-right">
      <Button type="submit">Update</Button>
    </div>
  </Form>
</template>
