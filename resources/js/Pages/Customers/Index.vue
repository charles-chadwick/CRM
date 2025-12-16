<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { CreateButton, EditButton, DeleteButton } from "../../Components/ActionButtons.vue";
import Pagination from "../../Components/Pagination.vue";
import { ConfirmDialog} from "primevue";
import { Head } from "@inertiajs/vue3";
import UserDetails from "../Users/Partials/UserDetails.vue";

const props = defineProps ( { customers: Object } );
</script>

<template>
  <Head title="Customers" />
  <AppLayout>
    <ConfirmDialog />

    <div class="px-8 py-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-darker-900">Customers</h1>
        <CreateButton
            prefix="customers"
            message="Customer"
        />
      </div>

      <table class="min-w-full border-collapse">
        <thead>
        <tr class="table-header">
          <th>Name</th>
          <th>Job Title</th>
          <th>Company</th>
          <th>Created By</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="customer in props.customers.data"
            :key="customer.id"
            class="table-row"
        >
          <td class="table-cell">{{ customer.attributes.full_name_salutations }}</td>
          <td class="table-cell">{{ customer.attributes.title }}</td>
          <td class="table-cell">
            {{ customer.relationships.company?.attributes?.name }}
          </td>
          <td class="table-cell">
            <UserDetails :user="customer.relationships.created_by" />
          </td>
          <td class="table-cell">{{ customer.attributes.created_at }}</td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <EditButton
                  prefix="customers"
                  :id="customer.id"
              />
              <DeleteButton
                  prefix="customers"
                  :id="customer.id"
                  :message="customer.attributes.full_name"
              />
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <Pagination
          :pagination="props.customers.meta"
      />
    </div>
  </AppLayout>
</template>

