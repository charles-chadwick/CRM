<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { Button, InputText, Select, Checkbox, Textarea } from 'primevue';

const props = defineProps({
  contact: { type: Object, default: null },
  contact_types: { type: Array, default: () => [] },
  on_types: { type: Array, default: () => [] },
});

const isEdit = !!props.contact?.id;

const form = useForm({
  on_type: props.contact?.on_type ?? 'Company',
  on_id: props.contact?.on_id ?? null,
  type: props.contact?.type ?? (props.contact_types[0] ?? 'Personal'),
  is_primary: props.contact?.is_primary ?? false,
  address_1: props.contact?.address_1 ?? null,
  address_2: props.contact?.address_2 ?? null,
  city: props.contact?.city ?? null,
  state: props.contact?.state ?? null,
  postal_code: props.contact?.postal_code ?? null,
  country: props.contact?.country ?? null,
  notes: props.contact?.notes ?? null,
});

function submit() {
  if (isEdit) {
    form.put(route('contacts.update', props.contact.id));
    return;
  }

  form.post(route('contacts.store'));
}
</script>

<template>
  <Head :title="isEdit ? 'Edit Contact' : 'Create Contact'" />

  <AppLayout>
    <div class="px-8 py-4 max-w-4xl">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-darker-900">
          {{ isEdit ? 'Edit Contact' : 'Create Contact' }}
        </h1>

        <Link class="text-primary-700 hover:underline" :href="route('contacts.index')">
          Back to Contacts
        </Link>
      </div>

      <form class="space-y-6" @submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <div>
            <label class="block font-medium mb-1">Contact Type</label>
            <Select
                id="type"
                v-model="form.type"
                optionLabel="label"
                optionValue="value"
                :options="props.contact_types"
                :invalid="!!form.errors.type"
                placeholder="Select company type"
                class="w-full"
            />
            <small v-if="form.errors.type" class="text-red-600">{{ form.errors.type }}</small>
          </div>

          <div class="flex items-center gap-2 mt-6 md:mt-0">
            <Checkbox v-model="form.is_primary" :binary="true" inputId="is_primary" />
            <label for="is_primary" class="font-medium">Primary</label>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1">Address 1</label>
            <InputText v-model="form.address_1" class="w-full" />
            <small v-if="form.errors.address_1" class="text-red-600">{{ form.errors.address_1 }}</small>
          </div>

          <div>
            <label class="block font-medium mb-1">Address 2</label>
            <InputText v-model="form.address_2" class="w-full" />
            <small v-if="form.errors.address_2" class="text-red-600">{{ form.errors.address_2 }}</small>
          </div>

          <div>
            <label class="block font-medium mb-1">City</label>
            <InputText v-model="form.city" class="w-full" />
            <small v-if="form.errors.city" class="text-red-600">{{ form.errors.city }}</small>
          </div>

          <div>
            <label class="block font-medium mb-1">State</label>
            <InputText v-model="form.state" class="w-full" />
            <small v-if="form.errors.state" class="text-red-600">{{ form.errors.state }}</small>
          </div>

          <div>
            <label class="block font-medium mb-1">Postal Code</label>
            <InputText v-model="form.postal_code" class="w-full" />
            <small v-if="form.errors.postal_code" class="text-red-600">{{ form.errors.postal_code }}</small>
          </div>

          <div>
            <label class="block font-medium mb-1">Country</label>
            <InputText v-model="form.country" class="w-full" />
            <small v-if="form.errors.country" class="text-red-600">{{ form.errors.country }}</small>
          </div>
        </div>

        <div>
          <label class="block font-medium mb-1">Notes</label>
          <Textarea v-model="form.notes" rows="5" class="w-full" />
          <small v-if="form.errors.notes" class="text-red-600">{{ form.errors.notes }}</small>
        </div>

        <div class="flex gap-2">
          <Button
            type="submit"
            severity="primary"
            :loading="form.processing"
            :label="isEdit ? 'Update Contact' : 'Create Contact'"
          />
          <Button
            as="a"
            :href="route('contacts.index')"
            severity="secondary"
            label="Cancel"
          />
        </div>
      </form>
    </div>
  </AppLayout>
</template>
