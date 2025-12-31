<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { CreateButton, EditButton, DeleteButton } from "../../Components/ActionButtons.vue";
import Pagination from "../../Components/Pagination.vue";
import { ConfirmDialog } from "primevue";
import { Head, Link } from "@inertiajs/vue3";
import CompanyDetails from '../Companies/Partials/Details.vue';
import Avatar from '../../Components/Avatar.vue';
import Search from "../../Components/Search.vue";
import Card from "@/Components/Card.vue";

const props = defineProps ( { customers: Object } );
</script>

<template>
  <Head title="Customers" />
  <AppLayout>

    <ConfirmDialog />

    <div class="px-8 md:py-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="page-header">Customers</h1>
        <CreateButton
            prefix="customers"
            message="Customer"
        />
      </div>

      <div class="mb-4">
        <Search
            route="customers.index"
            placeholder="Search Customers"
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
    </div>
  </AppLayout>
</template>

