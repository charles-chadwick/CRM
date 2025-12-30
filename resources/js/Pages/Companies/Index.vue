<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { CreateButton, EditButton, DeleteButton } from "../../Components/ActionButtons.vue";
import Pagination from "../../Components/Pagination.vue";
import { ConfirmDialog } from "primevue";
import { Head } from "@inertiajs/vue3";
import CompanyDetails from "./Partials/Details.vue"
import Search from "../../Components/Search.vue";
import Card from '@/Components/Card.vue'
const props = defineProps ( { companies: Object } );

</script>

<template>
  <Head title="Companies" />
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

      <div class="mb-4">
        <Search
            route="companies.index"
            placeholder="Search Companies"
        />
      </div>
      <Card>
      <table class="min-w-full border-collapse">
        <thead>
        <tr class="table-header">
          <th>Type</th>
          <th>Name</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="company in props.companies.data"
            :key="company.id"
            class="table-row"
        >
          <td class="table-cell">{{ company.company_type.name }}</td>
          <td class="table-cell click">
            <CompanyDetails :company="company" />
          </td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <EditButton
                  prefix="companies"
                  :id="company.id"
              />
              <DeleteButton
                  prefix="companies"
                  :id="company.id"
                  :message="company.name"
              />
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <Pagination
          :pagination="props.companies"
      />
      </Card>
    </div>
  </AppLayout>
</template>

