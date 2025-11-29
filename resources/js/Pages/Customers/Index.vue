<script setup>
import { Head } from '@inertiajs/vue3'
  import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";

const props =  defineProps({customers: Object, company: Object})
const customers = props.customers.data;
const company = props.company.data;
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Index" />
    <table class="w-full table-auto text-sm">
      <thead>
      <tr class="table-header">
        <td>Name</td>
        <td>Email</td>
        <td>Phone</td>
        <td>Created By</td>
        <td>Created On</td>
      </tr>
      </thead>
      <tbody>
        <tr class="table-row" v-for="customer in customers" :key="customer.id">
          <td>{{ customer.attributes.full_name }}</td>
          <td>{{ customer.attributes.email }}</td>
          <td>{{ customer.attributes.phone }}</td>
          <td>{{ customer.relationships.created_by.attributes.full_name }}</td>
          <td>{{ customers.attributes.created_at }}</td>
        </tr>
      </tbody>
    </table>
  </AuthenticatedLayout>
</template>
