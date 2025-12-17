<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import UserDetails from '@/Components/UserDetails.vue';
import { Button } from 'primevue';

const props = defineProps({
  contact: Object,
});
</script>

<template>
  <Head title="Contact" />

  <AppLayout>
    <div class="px-8 py-4 max-w-4xl">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-darker-900">Contact #{{ props.contact.id }}</h1>

        <div class="flex gap-2">
          <Button
            as="a"
            :href="route('contacts.edit', props.contact.id)"
            severity="secondary"
            label="Edit"
          />
          <Button
            as="a"
            :href="route('contacts.index')"
            severity="secondary"
            label="Back"
          />
        </div>
      </div>

      <div class="space-y-3">
        <div><span class="font-medium">On:</span> {{ props.contact.on_type }} #{{ props.contact.on_id }}</div>
        <div><span class="font-medium">Type:</span> {{ props.contact.type }}</div>
        <div><span class="font-medium">Primary:</span> {{ props.contact.is_primary ? 'Yes' : 'No' }}</div>

        <div class="pt-2 border-t">
          <div><span class="font-medium">Address 1:</span> {{ props.contact.address_1 }}</div>
          <div><span class="font-medium">Address 2:</span> {{ props.contact.address_2 }}</div>
          <div><span class="font-medium">City:</span> {{ props.contact.city }}</div>
          <div><span class="font-medium">State:</span> {{ props.contact.state }}</div>
          <div><span class="font-medium">Postal Code:</span> {{ props.contact.postal_code }}</div>
          <div><span class="font-medium">Country:</span> {{ props.contact.country }}</div>
        </div>

        <div class="pt-2 border-t">
          <div class="font-medium mb-1">Notes</div>
          <div class="whitespace-pre-wrap">{{ props.contact.notes }}</div>
        </div>

        <div class="pt-2 border-t">
          <div class="font-medium mb-1">Created By</div>
          <UserDetails :user="props.contact.created_by" />
        </div>
      </div>

      <div class="mt-6">
        <Link class="text-primary-700 hover:underline" :href="route('contacts.index')">
          Back to Contacts
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
