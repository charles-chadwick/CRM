<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import UserDetails from "../Users/Partials/UserDetails.vue";
import { EditButton, DeleteButton } from '@/Components/ActionButtons.vue';
import { ConfirmDialog } from 'primevue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  contacts: Object,
});

</script>

<template>
  <Head title="Contacts" />
  <AppLayout>
    <ConfirmDialog />

    <div class="px-8 py-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-darker-900">Contacts</h1>
      </div>

      <table class="min-w-full border-collapse">
        <thead>
          <tr class="table-header">
            <th>Type</th>
            <th>Primary</th>
            <th>On</th>
            <th>City</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="contact in props.contacts.data"
            :key="contact.id"
            class="table-row"
          >
            <td class="table-cell">
              <Link
                class="text-primary-700 hover:underline"
                :href="route('contacts.show', contact.id)"
              >
                {{ contact.type }}
              </Link>
            </td>

            <td class="table-cell">
              {{ contact.is_primary ? 'Yes' : 'No' }}
            </td>

            <td class="table-cell">
              {{ contact.on_type }} #{{ contact.on_id }}
            </td>

            <td class="table-cell">
              {{ contact.city }}
            </td>

            <td class="table-cell">
              <UserDetails :user="contact.created_by" />
            </td>

            <td class="table-cell">
              {{ contact.created_at }}
            </td>

            <td class="table-cell">
              <div class="flex gap-2 justify-center items-center">
                <EditButton prefix="contacts" :id="contact.id" />
                <DeleteButton prefix="contacts" :id="contact.id" :message="`Contact #${contact.id}`" />
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <Pagination :pagination="props.contacts" />
    </div>
  </AppLayout>
</template>
