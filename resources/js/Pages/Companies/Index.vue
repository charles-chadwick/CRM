<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import { Button, ConfirmDialog, Paginator } from 'primevue';
import {deleteRecord} from "../../utils/crudHelpers.js";
import AppLayout from '@/Layouts/AppLayout.vue';
import { useConfirm } from "primevue/useconfirm";

const props = defineProps ( {  companies: Object } );
const companies = props.companies;
const confirm = useConfirm ();

const confirmDelete = (id, message) => {
  confirm.require({
    message: `Are you sure you want to delete ${message}?`,
    header: 'Confirm Deletion',
    icon: 'pi pi-exclamation-triangle',
    rejectLabel: 'Cancel',
    acceptLabel: 'Delete',
    rejectClass: 'p-button-secondary p-button-outlined',
    acceptClass: 'p-button-danger',
    accept: () => {
      deleteRecord('companies', id);
    }
  });
}

</script>

<template>
  <AppLayout>
    <ConfirmDialog />

    <div class="px-8 py-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-darker-900">Companies</h1>
        <Button
            label="Create Company"
            icon="pi pi-plus"
            @click="$createRecord('companies')"
            severity="primary"
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
          <td class="table-cell">{{ company.attributes.created_at }}</td>
          <td class="table-cell">{{ company.relationships.created_by.attributes.full_name }}</td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <Button
                  icon="pi pi-pencil"
                  severity="secondary"
                  size="small"
                  @click="$editRecord('companies', company.id)"
                  v-tooltip.top="'Edit'"
              />
              <Button
                  icon="pi pi-trash"
                  severity="danger"
                  size="small"
                  @click="confirmDelete(company.id, company.attributes.name)"
                  v-tooltip.top="'Delete'"
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

