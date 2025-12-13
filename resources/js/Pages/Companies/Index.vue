<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ConfirmDialog, Paginator } from 'primevue';
import { CreateButton, EditButton, DeleteButton} from "../../Components/ActionButtons.vue";

const props = defineProps ( { companies: Object } );
const companies = props.companies;
</script>

<template>
  <AppLayout>
    <ConfirmDialog />

    <div class="px-8 py-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-darker-900">Companies</h1>
        <CreateButton
            prefix="companies"
            message="Company"
        />
      </div>

      <table class="min-w-full border-collapse">
        <thead>
        <tr class="table-header">
          <th>Type</th>
          <th>Name</th>
          <th>Created At</th>
          <th>Created By</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="company in companies.data"
            :key="company.id"
            class="table-row"
        >
          <td class="table-cell">{{ company.attributes.type }}</td>
          <td class="table-cell">{{ company.attributes.name }}</td>
          <td class="table-cell">{{ company.relationships.created_by?.attributes?.full_name }}</td>
          <td class="table-cell">{{ company.attributes.created_at }}</td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <EditButton
                  prefix="companies"
                  :id="company.id"
              />
              <DeleteButton
                  prefix="companies"
                  :id="company.id"
                  :message="company.attributes.name"
              />
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <Paginator
          :totalRecords="companies.meta.total"
          :rowsPerPageOptions="[10, 20, 30]"
      />
    </div>
  </AppLayout>
</template>

