<!--suppress JSUnresolvedReference -->
<script setup>
import { computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Button, InputText, Select, Message, Password } from 'primevue';

const props = defineProps ( {
  customer: {
    type: Object,
    default: null,
  },
  companies: {
    type: Array,
    default: []
  }
} );

const is_edit = computed ( () => !! props.customer );

const form = useForm ( {
  company_id: props.customer?.data.attributes?.company_id || null,
  title: props.customer?.data.attributes?.title || '',
  prefix: props.customer?.data.attributes?.prefix || '',
  first_name: props.customer?.data.attributes?.first_name || '',
  last_name: props.customer?.data.attributes?.last_name || '',
  suffix: props.customer?.data.attributes?.suffix || '',
  email: props.customer?.data.attributes?.email || '',
  password: '',
  password_confirmation: '',
} );

const companyOptions = computed ( () => {
  return props.companies.data.map ( company => ( {
    label: company.attributes.name,
    value: company.id
  } ) );
} );

const submit = () => {
  if ( is_edit.value ) {
    form.put ( route ( 'customers.update', props.customer.data.id ));
  } else {
    form.post ( route ( 'customers.store' ));
  }
};

const cancel = () => {
  router.visit ( route ( 'customers.index' ) );
};
</script>

<template>
  <AppLayout>
    <div class="px-8 py-4">
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-darker-900">
          {{ is_edit ? 'Edit Customer' : 'Create Customer' }}
        </h1>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <form
            @submit.prevent="submit"
            class="space-y-3 max-w-2xl"
        >
          <!-- Company -->
          <div class="flex flex-col gap-2">
            <label
                for="company_id"
                class="font-semibold"
            >Company</label>
            <Select
                id="company_id"
                v-model="form.company_id"
                :options="companyOptions"
                optionLabel="label"
                optionValue="value"
                :invalid="!!form.errors.company_id"
                placeholder="Select a company (optional)"
                class="w-full"
                showClear
            />
            <Message
                v-if="form.errors.company_id"
                severity="error"
                :closable="false"
            >
              {{ form.errors.company_id }}
            </Message>
          </div>

          <!-- Title -->
          <div class="flex flex-col gap-2">
            <label
                for="title"
                class="font-semibold"
            >Title</label>
            <InputText
                id="title"
                v-model="form.title"
                :invalid="!!form.errors.title"
                placeholder="Enter job title (optional)"
            />
            <Message
                v-if="form.errors.title"
                severity="error"
                :closable="false"
            >
              {{ form.errors.title }}
            </Message>
          </div>

          <!-- Prefix, First Name, Last Name, Suffix -->
          <div class="grid grid-cols-4 gap-4">
            <div class="flex flex-col gap-2">
              <label
                  for="prefix"
                  class="font-semibold"
              >Prefix</label>
              <InputText
                  id="prefix"
                  v-model="form.prefix"
                  :invalid="!!form.errors.prefix"
                  placeholder="Mr., Ms., Dr."
              />
              <Message
                  v-if="form.errors.prefix"
                  severity="error"
                  :closable="false"
              >
                {{ form.errors.prefix }}
              </Message>
            </div>

            <div class="flex flex-col gap-2">
              <label
                  for="first_name"
                  class="font-semibold"
              >First Name</label>
              <InputText
                  id="first_name"
                  v-model="form.first_name"
                  :invalid="!!form.errors.first_name"
                  placeholder="First name"
              />
              <Message
                  v-if="form.errors.first_name"
                  severity="error"
                  :closable="false"
              >
                {{ form.errors.first_name }}
              </Message>
            </div>

            <div class="flex flex-col gap-2">
              <label
                  for="last_name"
                  class="font-semibold"
              >Last Name</label>
              <InputText
                  id="last_name"
                  v-model="form.last_name"
                  :invalid="!!form.errors.last_name"
                  placeholder="Last name"
              />
              <Message
                  v-if="form.errors.last_name"
                  severity="error"
                  :closable="false"
              >
                {{ form.errors.last_name }}
              </Message>
            </div>

            <div class="flex flex-col gap-2">
              <label
                  for="suffix"
                  class="font-semibold"
              >Suffix</label>
              <InputText
                  id="suffix"
                  v-model="form.suffix"
                  :invalid="!!form.errors.suffix"
                  placeholder="Jr., Sr., III"
              />
              <Message
                  v-if="form.errors.suffix"
                  severity="error"
                  :closable="false"
              >
                {{ form.errors.suffix }}
              </Message>
            </div>
          </div>

          <!-- Email -->
          <div class="flex flex-col gap-2">
            <label
                for="email"
                class="font-semibold"
            >Email</label>
            <InputText
                id="email"
                v-model="form.email"
                type="email"
                :invalid="!!form.errors.email"
                placeholder="Enter email address"
            />
            <Message
                v-if="form.errors.email"
                severity="error"
                :closable="false"
            >
              {{ form.errors.email }}
            </Message>
          </div>

          <!-- Password Fields -->
          <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col gap-2">
              <label
                  for="password"
                  class="font-semibold"
              >Password {{ is_edit ? '(leave blank to keep current)' : '' }}</label>
              <Password
                  id="password"
                  v-model="form.password"
                  :invalid="!!form.errors.password"
                  :placeholder="is_edit ? 'Enter new password' : 'Enter password'"
                  toggleMask
                  :feedback="false"
                  class="w-full"
              />
              <Message
                  v-if="form.errors.password"
                  severity="error"
                  :closable="false"
              >
                {{ form.errors.password }}
              </Message>
            </div>

            <div class="flex flex-col gap-2">
              <label
                  for="password_confirmation"
                  class="font-semibold"
              >Confirm Password</label>
              <Password
                  id="password_confirmation"
                  v-model="form.password_confirmation"
                  :invalid="!!form.errors.password_confirmation"
                  placeholder="Confirm password"
                  toggleMask
                  :feedback="false"
                  class="w-full"
              />
              <Message
                  v-if="form.errors.password_confirmation"
                  severity="error"
                  :closable="false"
              >
                {{ form.errors.password_confirmation }}
              </Message>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex gap-4 pt-4">
            <Button
                type="submit"
                :label="is_edit ? 'Update Customer' : 'Create Customer'"
                :loading="form.processing"
                icon="pi pi-check"
                severity="primary"
            />
            <Button
                type="button"
                label="Cancel"
                severity="secondary"
                outlined
                icon="pi pi-times"
                @click="cancel"
                :disabled="form.processing"
            />
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
