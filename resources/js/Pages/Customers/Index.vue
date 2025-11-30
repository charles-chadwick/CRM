<!--suppress JSUnresolvedReference -->
<script setup>
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import { EllipsisVerticalIcon } from "@heroicons/vue/24/outline";
import { useConfirm } from "primevue/useconfirm";
import ConfirmDialog from 'primevue/confirmdialog';

const props = defineProps ( { customers: Object, company: Object } )
const customers = props.customers.data;
const company = props.company.data;
const confirm = useConfirm ();

import { router } from '@inertiajs/vue3'

const confirmDelete = ( customerId ) => {
  confirm.require ( {
    message: 'Are you sure you want to delete this customer?',
    header: 'Delete Confirmation',
    icon: 'pi pi-exclamation-triangle',
    accept: () => {
      router.delete ( route ( 'customers.destroy', customerId ) )
    }
  } );
};
</script>

<template>
  <AuthenticatedLayout>
    <ConfirmDialog />
    <template #header>
      Customers
    </template>
    <div class="text-center text-2xl font-bold mb-4">
      {{ company.attributes.name }}
    </div>
    <table class="w-full table-auto text-sm">
      <thead>
      <tr class="table-header">
        <td>Name</td>
        <td>Email</td>
        <td>Phone</td>
        <td>Created By</td>
        <td>Created On</td>
        <td>Actions</td>
      </tr>
      </thead>
      <tbody>
      <tr
          class="table-row"
          v-for="customer in customers"
          :key="customer.id"
      >
        <td>{{ customer.attributes.full_name }}</td>
        <td>{{ customer.attributes.email }}</td>
        <td>{{ customer.relationships.contact.attributes.phone }}</td>
        <td>{{ customer.relationships.created_by.attributes.full_name }}</td>
        <td>{{ customer.attributes.created_at }}</td>
        <td>
          <Menu
              as="div"
              class="relative inline-block text-left"
          >
            <MenuButton class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-darker-700 bg-white border border-darker-300 rounded-md hover:bg-darker-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            <EllipsisVerticalIcon
                  class="h-5 w-5"
                  aria-hidden="true"
              />
            </MenuButton>
            <MenuItems class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-darker-200 ring-opacity-5 focus:outline-none">
              <MenuItem v-slot="{ active }">
                <a
                    :href="route('customers.profile', customer.id)"
                    :class="[active ? 'bg-darker-100' : '', 'block px-4 py-2 text-sm text-darker-700']"
                >
                  Edit Customer
                </a>
              </MenuItem>
              <MenuItem v-slot="{ active }">
                <a
                    href="#"
                    @click.prevent="confirmDelete(customer.id)"
                    :class="[active ? 'bg-darker-100' : '', 'block px-4 py-2 text-sm text-darker-700']"
                >
                  Delete Customer
                </a>
              </MenuItem>
            </MenuItems>
          </Menu>
        </td>
      </tr>
      </tbody>
    </table>
  </AuthenticatedLayout>
</template>
