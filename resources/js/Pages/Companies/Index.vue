<!--suppress JSUnresolvedReference -->
<script setup>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import { usePage } from '@inertiajs/vue3';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import { computed } from 'vue';

const props = defineProps ( { companies: Array | Object } )
const companies = props.companies.data;
const permissions = usePage ().props.auth.permissions;

const menuItems = computed ( () => [
  { label: 'Manage Customers', href: '#', permission: null },
  { label: 'Edit', href: '#', permission: 'edit_companies' },
  { label: 'Delete', href: '#', permission: 'delete_companies' }
].filter ( item => ! item.permission || permissions.includes ( item.permission ) ) );
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      Companies
    </template>
    <table class="w-full table-auto text-sm">
      <thead>
      <tr class="table-header">
        <td>Type</td>
        <td>Name</td>
        <td>Customers</td>
        <td>Created By</td>
        <td>Created Date</td>
        <td>Actions</td>
      </tr>
      </thead>
      <tbody>
      <tr
          class="table-row"
          v-for="company in companies"
          :key="company.id"
      >
        <td>{{ company.attributes.type }}</td>
        <td>{{ company.attributes.name }}</td>
        <td>{{ company.relationships.customers.length }}</td>
        <td>{{ company.relationships.created_by.attributes.full_name }}</td>
        <td>{{ company.attributes.created_at }}</td>
        <td>
          <Menu
              as="div"
              class="relative inline-block text-left"
          >
            <MenuButton class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-darker-700 bg-white border border-darker-300 rounded-md hover:bg-darker-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
              Actions
              <ChevronDownIcon
                  class="-mr-1 ml-2 h-5 w-5"
                  aria-hidden="true"
              />
            </MenuButton>
            <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-darker-300 ring-opacity-5 focus:outline-none">
              <div class="py-1">
                <MenuItem
                    v-for="item in menuItems"
                    :key="item.label"
                    v-slot="{ active }"
                >
                  <a

                      :href="item.href"
                      :class="[active ? 'bg-darker-100' : '', 'block px-4 py-2 text-sm text-darker-700']"
                  >
                    {{ item.label }}
                  </a>
                </MenuItem>
              </div>
            </MenuItems>
          </Menu>
        </td>
      </tr>
      </tbody>
    </table>
  </AuthenticatedLayout>
</template>
