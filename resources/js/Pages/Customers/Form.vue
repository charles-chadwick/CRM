<!--suppress RequiredAttributes, JSUnresolvedReference -->
<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import {InputText, Button, Message} from 'primevue';

const props = defineProps ( {
  customer: {
    type: Object,
    required: true
  },
  action: {
    type: String,
    required: true
  }
} )

const customer = props.customer.data;

console.log(props);

const form = useForm ( {
  first_name: customer.attributes.first_name || '',
  last_name: customer.attributes.last_name || '',
  email: customer.attributes.email || '',
  phone: customer.relationships.contact.attributes.phone || '',
} )

const submit = () => {
  if ( props.action === 'create' ) {
    form.post ( route ( 'customers.store' ) )
  } else {
    form.put ( route ( 'customers.update', props.customer.id ) )
  }
}
</script>

<template>
  <AuthenticatedLayout>
    <Head :title="action === 'create' ? 'Create Customer' : action === 'show' ? 'View Customer' : 'Edit Customer'" />

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <form
          @submit.prevent="submit"
          class="space-y-6"
      >
        <div class="grid grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-darker-700">Name</label>
            <InputText
                v-model="form.first_name"
                :disabled="action === 'show'"
                class="mt-1 block w-full"
            />
            <Message
                v-if="form.errors.first_name"
                severity="error"
                :closable="false"
            >{{ form.errors.first_name }}
            </Message>
          </div>
          <div>
            <label class="block text-sm font-medium text-darker-700">Name</label>
            <InputText
                v-model="form.last_name"
                :disabled="action === 'show'"
                class="mt-1 block w-full"
            />
            <Message
                v-if="form.errors.last_name"
                severity="error"
                :closable="false"
            >{{ form.errors.last_name }}
            </Message>
          </div>

          <div>
            <label class="block text-sm font-medium text-darker-700">Email</label>
            <InputText
                v-model="form.email"
                :disabled="action === 'show'"
                class="mt-1 block w-full"
            />
            <Message
                v-if="form.errors.email"
                severity="error"
                :closable="false"
            >{{ form.errors.email }}
            </Message>
          </div>

          <div>
            <label class="block text-sm font-medium text-darker-700">Phone</label>
            <InputText
                v-model="form.phone"
                :disabled="action === 'show'"
                class="mt-1 block w-full"
            />
            <Message
                v-if="form.errors.phone"
                severity="error"
                :closable="false"
            >{{ form.errors.phone }}
            </Message>
          </div>

        </div>

        <div
            class="flex justify-end space-x-3"
            v-if="action !== 'show'"
        >
          <Button
              type="submit"
              :loading="form.processing"
              class="px-4 py-2"
          >
            {{ action === 'create' ? 'Create' : 'Update' }}
          </Button>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
