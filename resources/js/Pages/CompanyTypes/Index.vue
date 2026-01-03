<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { CreateButton, EditButton, DeleteButton } from "../../Components/ActionButtons.vue";
import Pagination from "../../Components/Pagination.vue";
import { ConfirmDialog } from "primevue";
import { Head } from "@inertiajs/vue3";
import Search from "../../Components/Search.vue";
import Sort from "../../Components/Sort.vue";

const props = defineProps ( { company_types: Object } );
const sort_by_items = [
  { label: 'Name', value: 'name' },
]
</script>

<template>
  <Head title="Company Types" />
  <AppLayout>
    <ConfirmDialog />

    <div class="px-8 py-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-darker-900">Company Types</h1>
        <CreateButton
            prefix="company-types"
            message="Company Type"
        />
      </div>

      <div class="flex justify-between items-center mb-4">
        <Search
            route="company-types.index"
            placeholder="Search Company Types"
            class="w-1/3"
        />
        <Sort
            :sort_by_items="sort_by_items"
            route="company-types.index"
            class="w-1/3"
        />
      </div>

      <table class="min-w-full border-collapse">
        <thead>
        <tr class="table-header">
          <th>Name</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="company_type in props.company_types.data"
            :key="company_type.id"
            class="table-row"
        >
          <td class="table-cell">{{ company_type.name }}</td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <EditButton
                  prefix="company-types"
                  :id="company_type.id"
              />
              <DeleteButton
                  prefix="company-types"
                  :id="company_type.id"
                  :message="company_type.name"
              />
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <Pagination
          :pagination="props.company_types"
      />
    </div>
  </AppLayout>
</template>
