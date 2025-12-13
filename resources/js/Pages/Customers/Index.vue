<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Select, ConfirmDialog } from 'primevue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { CreateButton, EditButton, DeleteButton} from "../../Components/ActionButtons.vue";
import Pagination from "../../Components/Pagination.vue";

const props = defineProps({ customers: Object });
const customers = props.customers;

const sortByOptions = [
  { label: 'Name', value: 'first_name' },
  { label: 'Company', value: 'company' },
  { label: 'Created Date', value: 'created_at' }
];

const sortDirectionOptions = [
  { label: 'Ascending', value: 'asc' },
  { label: 'Descending', value: 'desc' }
];

const selected_sorted_by = ref ( null );
const selected_sort_direction = ref ( null );

const handleSortChange = () => {
  if ( selected_sorted_by.value && selected_sort_direction.value ) {
    router.get ( route ( 'customers.index' ), {
      sort_by: selected_sorted_by.value,
      sort_direction: selected_sort_direction.value
    }, { preserveState: true } );
  }
};
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

      <div class="flex justify-start mb-4 gap-4">
        <Select
            v-model="selected_sorted_by"
            :options="sortByOptions"
            optionLabel="label"
            optionValue="value"
            placeholder="Sort by..."
            @change="handleSortChange"
            class="w-64"
        />
        <Select
            v-model="selected_sort_direction"
            :options="sortDirectionOptions"
            optionLabel="label"
            optionValue="value"
            placeholder="Direction..."
            @change="handleSortChange"
            class="w-64"
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
      <Pagination
          :pagination="customers.meta"
      />
    </div>
  </AppLayout>
</template>
