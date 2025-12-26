<!--suppress JSUnresolvedReference -->
<script setup>
import { computed } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Button, InputText, Select, Message, Password } from 'primevue';
import Image from "../../Components/Image.vue";
import Card from "../../Components/Card.vue";
import FormHeader from "../../Components/FormHeader.vue";

const props = defineProps ( {
  customer: {
    type: Object,
    default: null,
  },
  companies: {
    type: Object,
    default: []
  }
} );

const is_edit = computed ( () => !! props.customer );

const form = useForm ( {
  company_id: props.customer?.company_id || null,
  title: props.customer?.title || '',
  prefix: props.customer?.prefix || '',
  first_name: props.customer?.first_name || '',
  last_name: props.customer?.last_name || '',
  suffix: props.customer?.suffix || '',
  email: props.customer?.email || '',
  password: '',
  password_confirmation: '',
} );

const company_options = computed ( () => {
  return props.companies.map ( company => ( {
    label: company.name,
    value: company.id
  } ) );
} );

const submit = () => {
  if ( is_edit.value ) {
    form.put ( route ( 'customers.update', props.customer.id ) );
  } else {
    form.post ( route ( 'customers.store' ) );
  }
};

const cancel = () => {
  router.visit ( route ( 'customers.index' ) );
};
</script>

<template>
  <Head title="Customers" />
  <AppLayout header="hi">
    <div class="px-8 py-4">
      <FormHeader
          :header="is_edit ? 'Edit Customer' : 'Create Customer'"
          to_route="customers.index"
          label="Back to Customers"w
      />
      <Card>
        <form
            @submit.prevent="submit"
            class="space-y-6"
        >

          <div class="flex flex-row gap-4">
            <div class="w-2/3">
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mb-4">

                <!-- Company -->
                <div class="flex flex-col gap-2">
                  <label
                      for="company_id"
                      class="font-semibold"
                  >Company</label>
                  <Select
                      id="company_id"
                      v-model="form.company_id"
                      :options="company_options"
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
              </div>

              <!-- Prefix, First Name, Last Name, Suffix -->
              <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-4">
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
              <div class="flex flex-col gap-2 mb-4">
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
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div class="flex flex-col gap-2">
                  <label
                      for="password"
                      class="font-semibold"
                  >Password</label>
                  <Password
                      id="password"
                      v-model="form.password"
                      :invalid="!!form.errors.password"
                      :placeholder="is_edit ? 'Enter new password' : 'Enter password'"
                      toggleMask
                      fluid
                      :feedback="false"
                  />
                  <p v-if="is_edit">(leave blank to keep current)</p>
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
                      fluid
                      :feedback="false"
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
              <div class="flex flex-col sm:flex-row gap-4 pt-4">
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
            </div>
            <div class="w-1/3 pl-4">
              <label
                  for="notes"
                  class="font-semibold"
              >Avatar</label>
              <Image
                  v-if="is_edit"
                  image_type="avatars"
                  on_type="Customer"
                  size="lg"
                  :on_id="props.customer.id"
                  :image="props.customer.avatar"
              />
              <p
                  class="text-darker-600"
                  v-else
              >You will be able to add an avatar once the customer is created.</p>
            </div>
          </div>
        </form>
      </Card>
    </div>
  </AppLayout>
</template>
