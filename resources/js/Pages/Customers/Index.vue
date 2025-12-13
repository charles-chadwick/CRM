<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ConfirmDialog, Paginator } from 'primevue';
import { CreateButton, EditButton, DeleteButton} from "../../Components/ActionButtons.vue";

const props = defineProps({ customers: Object });
const customers = props.customers;
</script>

<template>
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
          <th>Company</th>
          <th>Created At</th>
          <th>Created By</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-if="customers.data.length !== 0"
            v-for="customer in customers.data"
            :key="customer.id"
            class="table-row"
        >
          <td class="table-cell">{{ customer.attributes.full_name }}</td>
          <td class="table-cell">{{ customer.relationships.company?.attributes?.name || 'N/A' }}</td>
          <td class="table-cell">{{ customer.attributes.created_at }}</td>
          <td class="table-cell">{{ customer.relationships.created_by?.attributes?.full_name }}</td>
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
        <tr v-else>
          <td colspan="6" class="py-2 text-center">No customers found.</td>
        </tr>
        </tbody>
      </table>
      <Paginator
          v-if="customers.data.length > 15"
          :totalRecords="customers.meta.total"
          :rowsPerPageOptions="[10, 20, 30]"
      />
    </div>
  </AppLayout>
</template>
