<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { CreateButton, EditButton, DeleteButton } from "../../Components/ActionButtons.vue";
import Pagination from "../../Components/Pagination.vue";
import { ConfirmDialog } from "primevue";
import { Head } from "@inertiajs/vue3";
import Search from "../../Components/Search.vue";

const props = defineProps({ company_types: Object });
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

      <div class="mb-4">
        <Search
            route="company-types.index"
            placeholder="Search Company Types"
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
            v-for="companyType in props.company_types.data"
            :key="companyType.id"
            class="table-row"
        >
          <td class="table-cell">{{ companyType.name }}</td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <EditButton
                  prefix="company-types"
                  :id="companyType.id"
              />
              <DeleteButton
                  prefix="company-types"
                  :id="companyType.id"
                  :message="companyType.name"
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
