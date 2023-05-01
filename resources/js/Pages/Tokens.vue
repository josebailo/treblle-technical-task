<script setup lang="ts">
  import { Link, router } from '@inertiajs/vue3'
  import { Token } from '../types'
  import PageHeader from '../Components/PageHeader.vue'
  import Table from '../Components/Tables/Table.vue'
  import Th from '../Components/Tables/Th.vue'
  import Td from '../Components/Tables/Td.vue'
  import Tr from '../Components/Tables/Tr.vue'

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
    <div class="flex items-center justify-between gap-2">
      <PageHeader>API Tokens</PageHeader>
      <Link href="/tokens/new" class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-blue-600 text-sm text-white shadow-sm cursor-pointer hover:bg-blue-500 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 focus:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
          <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
        </svg>
        Create token
      </Link>
    </div>

    <div v-if="newToken" class="mt-5 flex items-center justify-between gap-2 p-3 rounded bg-emerald-200 text-emerald-900">
      <div>
        <p>Here is your new token. Please, copy it now, later it will not be possible.</p>
        <pre class="mt-2 font-bold">{{ newToken }}</pre>
      </div>
      <button type="button" title="Copy to clipboard" @click="copyToken">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
          <path fill-rule="evenodd" d="M15.988 3.012A2.25 2.25 0 0118 5.25v6.5A2.25 2.25 0 0115.75 14H13.5v-3.379a3 3 0 00-.879-2.121l-3.12-3.121a3 3 0 00-1.402-.791 2.252 2.252 0 011.913-1.576A2.25 2.25 0 0112.25 1h1.5a2.25 2.25 0 012.238 2.012zM11.5 3.25a.75.75 0 01.75-.75h1.5a.75.75 0 01.75.75v.25h-3v-.25z" clip-rule="evenodd" />
          <path d="M3.5 6A1.5 1.5 0 002 7.5v9A1.5 1.5 0 003.5 18h7a1.5 1.5 0 001.5-1.5v-5.879a1.5 1.5 0 00-.44-1.06L8.44 6.439A1.5 1.5 0 007.378 6H3.5z" />
        </svg>
      </button>
    </div>

    <div class="mt-5 -mx-5 -mb-5">
      <Table v-if="tokens.length > 0">
        <template v-slot:headers>
          <Th>Name</Th>
          <Th>Last use</Th>
          <Th>
            <span class="sr-only">Actions</span>
          </Th>
        </template>
        <Tr v-for="token in tokens" class="hover:bg-slate-50">
          <Td>{{ token.name }}</Td>
          <Td>{{ token.last_used_at || '-' }}</Td>
          <Td class="text-right">
            <button type="button" class="text-red-700 cursor-pointer" @click="deleteToken(token.id)">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
              </svg>
            </button>
          </Td>
        </Tr>
      </Table>
      <p v-else class="p-5">There are no tokens created.</p>
    </div>
  </div>
</template>
