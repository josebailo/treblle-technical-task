<script setup lang="ts">
  import { Link, router } from '@inertiajs/vue3'
  import { Token } from '../types'
  import PageHeader from '../Components/PageHeader.vue'
  import Table from '../Components/Tables/Table.vue'
  import Th from '../Components/Tables/Th.vue'
  import Td from '../Components/Tables/Td.vue'
  import Tr from '../Components/Tables/Tr.vue'
  import { ClipboardDocumentIcon, PlusIcon, TrashIcon } from '@heroicons/vue/20/solid'

  const props = defineProps<{
    newToken?: string
    tokens: Token[]
  }>()

  const copyToken = () => {
    if (props.newToken) {
      navigator.clipboard.writeText(props.newToken)
    }
  }

  const deleteToken = (id: number) => {
    if (confirm('Are you sure to delete the token?')) {
      router.delete(`/tokens/${id}`)
    }
  }
</script>

<template>
  <div class="bg-white p-5 rounded-md border border-gray-300 shadow-sm overflow-hidden">
    <div class="flex flex-col place-items-start gap-2 sm:flex-row sm:justify-between sm:items-center">
      <PageHeader>API Tokens</PageHeader>
      <Link href="/tokens/new" class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-blue-600 text-sm text-white shadow-sm cursor-pointer hover:bg-blue-500 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-2">
        <PlusIcon class="w-4 h-4" />
        Create token
      </Link>
    </div>

    <div v-if="newToken" class="mt-5 flex items-center justify-between gap-2 p-3 rounded bg-emerald-200 text-emerald-900">
      <div>
        <p>Here is your new token. Please, copy it now, later it will not be possible.</p>
        <p class="mt-2 font-bold break-all">{{ newToken }}</p>
      </div>
      <button type="button" title="Copy to clipboard" @click="copyToken">
        <ClipboardDocumentIcon class="w-5 h-5" />
      </button>
    </div>

    <div class="mt-5 -mx-5 -mb-5">
      <Table v-if="tokens.length > 0">
        <template v-slot:headers>
          <Th>Name</Th>
          <Th class="hidden sm:block">Last use</Th>
          <Th>
            <span class="sr-only">Actions</span>
          </Th>
        </template>
        <Tr v-for="token in tokens" class="hover:bg-slate-50">
          <Td>{{ token.name }}</Td>
          <Td class="hidden sm:block">{{ token.last_used_at || '-' }}</Td>
          <Td class="text-right">
            <button type="button" class="text-red-700 cursor-pointer" @click="deleteToken(token.id)">
              <TrashIcon class="w-6 h-6" />
            </button>
          </Td>
        </Tr>
      </Table>
      <p v-else class="p-5">There are no tokens created.</p>
    </div>
  </div>
</template>
