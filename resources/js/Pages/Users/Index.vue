<!--suppress NpmUsedModulesInstalled -->
<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { useConfirm } from 'primevue/useconfirm';
import { Button, ConfirmDialog } from 'primevue';
import AppLayout from '@/Layouts/AppLayout.vue';
const props = defineProps ( {
  users: Array,
} );

const page = usePage ();
const confirm = useConfirm ();

const create_user = () => {
  router.visit ( route ( 'users.create' ) );
};

const edit_user = ( user_id ) => {
  router.visit ( route ( 'users.edit', user_id ) );
};

const delete_user = ( user ) => {
  confirm.require ( {
    message: `Are you sure you want to delete ${ user.first_name } ${ user.last_name }?`,
    header: 'Confirm Deletion',
    icon: 'pi pi-exclamation-triangle',
    rejectLabel: 'Cancel',
    acceptLabel: 'Delete',
    rejectClass: 'p-button-secondary p-button-outlined',
    acceptClass: 'p-button-danger',
    accept: () => {
      router.delete ( route ( 'users.destroy', user.id ), {
        preserveScroll: true,
      } );
    }
  } );
};
</script>

<template>
  <AppLayout>
    <ConfirmDialog />
    <div class="px-8 py-4">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-darker-900">Users</h1>
        <Button
            label="Create User"
            icon="pi pi-plus"
            @click="create_user"
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
          <td class="table-cell">{{ user.attributes.type }}</td>
          <td class="table-cell">{{ user.attributes.name }}</td>
          <td class="table-cell">{{ user.attributes.created_at }}</td>
          <td class="table-cell">{{ user.relationships.created_by.attributes.full_name }}</td>
          <td class="table-cell">
            <div class="flex gap-2 justify-center items-center">
              <Button
                  icon="pi pi-pencil"
                  severity="secondary"
                  size="small"
                  @click="edit_user(user.id)"
                  v-tooltip.top="'Edit'"
              />
              <Button
                  icon="pi pi-trash"
                  severity="danger"
                  size="small"
                  @click="delete_user(user)"
                  v-tooltip.top="'Delete'"
              />
            </div>
          </td>
        </tr>
        </tbody>
      </table>

    </div>
  </AppLayout>
</template>
