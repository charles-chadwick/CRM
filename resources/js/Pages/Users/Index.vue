<!--suppress NpmUsedModulesInstalled, JSUnresolvedReference, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Button } from 'primevue';
import DeleteButton from "../../Components/ActionButtons.vue";
import EditButton from "../../Components/ActionButtons.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps ( {
  users: Object,
} );

</script>

<template>
  <AppLayout>

    <div class="px-8 py-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-darker-900">Users</h1>
        <Button
            label="Create User"
            icon="pi pi-plus"
            @click="$createRecord('users')"
            severity="primary"
        />
      </div>

      <table class="min-w-full border-collapse">
        <thead>
        <tr class="table-header">
          <th>Role</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Created At</th>
          <th>Created By</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="user in props.users.data"
            :key="user.id"
            class="table-row"
        >
          <td class="table-cell">{{ user.attributes.role }}</td>
          <td class="table-cell">{{ user.attributes.first_name }}</td>
          <td class="table-cell">{{ user.attributes.last_name }}</td>
          <td class="table-cell">{{ user.attributes.email }}</td>
          <td class="table-cell">{{ user.attributes.created_at }}</td>
          <td class="table-cell">{{ user.relationships.created_by.attributes.full_name }}</td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <DeleteButton
                  prefix="users"
                  :id="user.id"
                  :message="user.attributes.name"
              />
            </div>
          </td>
        </tr>
        </tbody>
      </table>

    </div>
  </AppLayout>
</template>
