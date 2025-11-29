<script setup>
import { useForm } from '@inertiajs/vue3'
import { Message } from 'primevue';
import Editor from 'primevue/editor';
import AuthenticatedLayout from "../AuthenticatedLayout.vue";


const props = defineProps ( { company: Object, action: String } )

const form = useForm ( {
  type: props.company.type || '',
  name: props.company.name || '',
  notes: props.company.notes || ''
} )

const submit = () => {
  if ( props.action === 'create' ) {
    form.post ( route ( 'companies.store' ) )
  } else {
    form.put ( route ( 'companies.update', props.company.id ) )
  }
}
</script>

<template>
  <AuthenticatedLayout>
    <form
        @submit.prevent="submit"
        class="mx-auto p-6"
    >
      <div class="space-y-6">
        <div>
          <label class="block text-sm font-medium ">Type</label>
          <input
              type="text"
              v-model="form.type"
              class="mt-1 block w-full rounded-md p-2 shadow-sm focus:border-primary-500 focus:ring-primary-500"
          >
          <Message
              v-if="form.errors.type"
              severity="error"
              :text="form.errors.type"
              class="mt-2"
          >{{ form.errors.type }}
          </Message>
        </div>

        <div>
          <label class="block text-sm font-medium ">Name</label>
          <input
              type="text"
              v-model="form.name"
              class="mt-1 block w-full rounded-md p-2  border-darker-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
          >
          <Message
              v-if="form.errors.name"
              severity="error"
              class="mt-2"
          >{{ form.errors.name }}
          </Message>
        </div>

        <div>
          <label class="block text-sm font-medium ">Notes</label>
          <Editor
              v-model="form.notes"
              editorStyle="height: 250px"
              class="mt-1"
          />

        </div>

        <div class="flex justify-center">
          <button
              type="submit"
              :disabled="form.processing"
              class="btn"
          >
            {{ action === 'create' ? 'Create' : 'Update' }} Company
          </button>
        </div>
      </div>
    </form>
  </AuthenticatedLayout>
</template>
