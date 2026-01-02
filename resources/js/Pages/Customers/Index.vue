<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { CreateButton, EditButton, DeleteButton } from "@/Components/ActionButtons.vue";
import Pagination from "@/Components/Pagination.vue";
import { ConfirmDialog } from "primevue";
import { Head, Link } from "@inertiajs/vue3";
import CompanyDetails from '@/Pages/Companies/Partials/Details.vue';
import Avatar from '@/Components/Avatar.vue';
import Search from "@/Components/Search.vue";
import Card from "@/Components/Card.vue";
import Sort from "@/Components/Sort.vue";

const props = defineProps ( { customers: Object } );

const sort_by_items = [
  { label: 'First Name', value: 'first_name' },
  { label: 'Last Name', value: 'last_name' },
  { label: 'Job Title', value: 'title' },
  { label: 'Company', value: 'company.name' },
]


</script>

<template>
  <Head title="Customers" />
  <AppLayout>

    <ConfirmDialog />

    <div class="flex justify-between items-center mb-6">
      <h1 class="page-header">Customers</h1>
      <CreateButton
          prefix="customers"
          message="Customer"
      />
    </div>

    <div class="flex justify-between items-center mb-6">
      <Search
          route="customers.index"
          placeholder="Search Customers"
          class="w-1/3"
      />
      <Sort
          :sort_by_items="sort_by_items"
          route="customers.index"
          class="w-1/3"
      />
    </div>


    <Card>
      <table class="min-w-full border-collapse table-auto">
        <thead>
        <tr class="table-header">
          <th>Name</th>
          <th>Job Title</th>
          <th>Company</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="customer in props.customers.data"
            :key="customer.id"
            class="table-row"
        >
          <td class="table-cell">
            <div class="flex justify-start gap-2 items-center">
              <Avatar :image="customer.avatar" />
              <Link :href="route('customers.show', customer.id)">{{ customer.full_name }}</Link>
            </div>
          </td>
          <td class="table-cell">{{ customer.title }}</td>
          <td class="table-cell click">
            <CompanyDetails
                v-if="customer?.company"
                :company="customer?.company"
            />
          </td>

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
          v-if="props.customers.data.length > 0"
      />
      <p
          class="p-4 text-center"
          v-else
      >No customers found.</p>
    </Card>
  </AppLayout>
</template>

