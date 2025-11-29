<!--suppress JSUnresolvedReference -->
<script setup>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import { provide } from 'vue';
import { usePermissions } from "../../directives/permission.js";

const props = defineProps ( { companies: Array | Object } )
const companies = props.companies.data;
provide ( 'can', usePermissions().can );
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      Companies
    </template>
    <table class="w-full table-auto text-sm">
      <thead>
      <tr class="table-header">
        <td>Type</td>
        <td>Name</td>
        <td>Customers</td>
        <td>Created By</td>
        <td>Created Date</td>
        <td>Actions</td>
      </tr>
      </thead>
      <tbody>
      <tr
          class="table-row"
          v-for="company in companies"
          :key="company.id"
      >
        <td>{{ company.attributes.type }}</td>
        <td>{{ company.attributes.name }}</td>
        <td>{{ company.relationships.customers.length }}</td>
        <td>{{ company.relationships.created_by.attributes.full_name }}</td>
        <td>{{ company.attributes.created_at }}</td>
        <td>
          <a
              v-if="can('companies.edit')"
              href="#"
          >Edit</a>
        </td>
      </tr>
      </tbody>
    </table>
  </AuthenticatedLayout>
</template>
