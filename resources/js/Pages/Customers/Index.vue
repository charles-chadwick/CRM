<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { CreateButton, EditButton, DeleteButton } from "../../Components/ActionButtons.vue";
import Pagination from "../../Components/Pagination.vue";
import { ConfirmDialog } from "primevue";
import { Head } from "@inertiajs/vue3";
import UserDetails from "../Users/Partials/Details.vue";
import CompanyDetails from '../Companies/Partials/Details.vue';
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
          <td class="table-cell">{{ customer.full_name }}</td>
          <td class="table-cell">{{ customer.title }}</td>
          <td class="table-cell click">
            <CompanyDetails
                v-if="customer?.company"
                :company="customer?.company"
            />
          </td>

          <td class="table-cell click">
            <UserDetails :user="customer.created_by" />
          </td>
          <td class="table-cell">{{ customer.created_at }}</td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <EditButton
                  prefix="customers"
                  :id="customer.id"
              />
              <DeleteButton
                  prefix="customers"
                  :id="customer.id"
                  :message="customer.full_name"
              />
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <Pagination
          :pagination="props.customers"
      />
    </div>
  </AppLayout>
</template>

