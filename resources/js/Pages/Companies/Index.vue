<!--suppress JSUnresolvedReference -->
<script setup>
import AuthenticatedLayout from "../AuthenticatedLayout.vue";

const props = defineProps ( { companies: Array | Object } )
const companies = props.companies.data;
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      Companies
    </template>
    <table class="w-full table-auto">
      <thead>
      <tr class="table-header">
        <td>Type</td>
        <td>Name</td>
        <td>Created</td>
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
        <td>{{ company.relationships.created_by.attributes.full_name }}</td>

      </tr>
      </tbody>
    </table>
  </AuthenticatedLayout>
</template>
