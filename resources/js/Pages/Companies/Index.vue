<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { CreateButton, EditButton, DeleteButton } from "../../Components/ActionButtons.vue";
import Pagination from "../../Components/Pagination.vue";
import { ConfirmDialog } from 'primevue';
import { Head, Link } from "@inertiajs/vue3";
import Search from "../../Components/Search.vue";
import Card from '@/Components/Card.vue'
import Sort from "../../Components/Sort.vue";

const props = defineProps ( { companies: Object } );
const sort_by_items = [
  { label: 'Type', value: 'companyType.name' },
  { label: 'Name', value: 'name' },
]

</script>

<template>
  <Head title="Companies" />
  <AppLayout>
    <ConfirmDialog />
    <!-- start header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="page-header">Companies</h1>
      <CreateButton
          prefix="companies"
          message="Company"
      />
    </div>
    <!-- end header -->

    <!-- start search and sort -->
    <div class="mb-4 flex justify-between gap-4 items-center">
      <Search
          route="companies.index"
          placeholder="Search Companies"
          class="w-1/3"
      />
      <Sort
          :sort_by_items="sort_by_items"
          route="companies.index"
          class="w-1/3"
      />
    </div>
    <!-- end search and sort -->

    <!-- start list -->
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
            <Link :href="route('companies.show', company.id)">{{ company.name }}</Link>
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
          v-if="props.companies.data.length > 0"
      />
      <p
          class="p-4 text-center"
          v-else
      >No companies found.</p>
    </Card>
    <!-- end list -->

  </AppLayout>
</template>

