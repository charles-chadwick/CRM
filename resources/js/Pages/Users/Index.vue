<!--suppress NpmUsedModulesInstalled, JSUnresolvedReference, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import Pagination from "../../Components/Pagination.vue";
import { ConfirmDialog } from "primevue";
import { CreateButton, EditButton, DeleteButton } from "../../Components/ActionButtons.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps ( {
  users: Object,
} );

</script>

<template>
  <Head title="Users" />
  <AppLayout>
    <ConfirmDialog />

    <div class="px-8 py-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-darker-900">Users</h1>
        <CreateButton prefix="users" message="User" />
      </div>

      <table class="min-w-full border-collapse">
        <thead>
        <tr class="table-header">
          <th>ID</th>
          <th>Role</th>
          <th>Name</th>
          <th>Created By</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="user in props.users.data"
            :key="user.id"
            class="table-row"
        >
          <td class="table-cell">{{ user.attributes.id }}</td>
          <td class="table-cell">{{ user.attributes.role }}</td>
          <td class="table-cell">{{ user.attributes.full_name }}</td>
          <td class="table-cell">{{ user.relationships.created_by.attributes.full_name }}</td>
          <td class="table-cell">{{ user.attributes.created_at }}</td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <EditButton
                  prefix="users"
                  :id="user.id"
              />
              <DeleteButton
                  prefix="users"
                  :id="user.id"
                  :message="user.attributes.full_name"
              />
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <Pagination :pagination="props.users.meta" />
    </div>
  </AppLayout>
</template>
