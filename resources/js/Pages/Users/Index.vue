<!--suppress NpmUsedModulesInstalled, JSUnresolvedReference, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "../../Components/Pagination.vue";
import { ConfirmDialog } from "primevue";
import { CreateButton, EditButton, DeleteButton } from "../../Components/ActionButtons.vue";
import { Head } from "@inertiajs/vue3";
import UserDetails from "./Partials/Details.vue";

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
        <CreateButton
            prefix="users"
            message="User"
        />
      </div>

      <table class="min-w-full border-collapse">
        <thead>
        <tr class="table-header">
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
          <td class="table-cell">{{ user.role }}</td>
          <td class="table-cell">{{ user.full_name }}</td>
          <td class="table-cell">
            <UserDetails :user="user.created_by" />
          </td>
          <td class="table-cell">{{ user.created_at }}</td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <EditButton
                  prefix="users"
                  :id="user.id"
              />
              <DeleteButton
                  prefix="users"
                  :id="user.id"
                  :message="user.full_name"
              />
            </div>
          </td>
        </tr>
        </tbody>
      </table>
      <Pagination :pagination="props.users" />
    </div>
  </AppLayout>
</template>
