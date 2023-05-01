<script setup lang="ts">
  import Button from '../Components/Forms/Button.vue'
  import Error from '../Components/Forms/Error.vue'
  import Form from '../Components/Forms/Form.vue'
  import Input from '../Components/Forms/Input.vue'
  import PageHeader from '../Components/PageHeader.vue'
  import { useForm } from '@inertiajs/vue3'

  const form = useForm({
    name: '',
  })

  const submit = () => {
    form.post('/tokens')
  }
</script>

<template>
  <Form @submit.prevent="submit">
    <PageHeader>Create token</PageHeader>
    <div class="mt-5">
      <label for="name" class="block">Name</label>
      <Input type="text" id="name" v-model="form.name" class="mt-2" required />
      <Error v-if="form.errors.name" class="mt-2">{{ form.errors.name }}</Error>
    </div>
    <div class="mt-5 text-right">
      <Button type="submit">Create</Button>
    </div>
  </Form>
</template>
