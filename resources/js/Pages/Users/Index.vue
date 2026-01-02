<!--suppress NpmUsedModulesInstalled, JSUnresolvedReference, JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "../../Components/Pagination.vue";
import { ConfirmDialog } from 'primevue';
import { CreateButton, EditButton, DeleteButton } from "../../Components/ActionButtons.vue";
import { Head, Link } from "@inertiajs/vue3";
import Search from "../../Components/Search.vue";
import Card from "../../Components/Card.vue";
import Sort from "../../Components/Sort.vue";

const props = defineProps ( {
  users: Object,
} );

const sort_by_items = [
  { label: 'First Name', value: 'first_name' },
  { label: 'Last Name', value: 'last_name' },
  { label: 'Role', value: 'role' }
]

</script>

<template>
  <Head title="Users" />
  <AppLayout>
    <ConfirmDialog />

      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-darker-900">Users</h1>
        <CreateButton
            prefix="users"
            message="User"
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
        <table class="min-w-full border-collapse">
          <thead>
          <tr class="table-header">
            <th>Role</th>
            <th>Name</th>
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
            <td class="table-cell">
              <Link
                  :href="route('users.show', user.id)"
                  target="_blank"
                  class="click"
              >
                {{ user.full_name }}
              </Link>
            </td>
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
        <Pagination
            :pagination="props.users"
            v-if="props.users.data.length > 0"
        />
        <p
            v-else
            class="p-4 text-center"
        >No users found.</p>
      </Card>

  </AppLayout>
</template>
