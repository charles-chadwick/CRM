<!--suppress NpmUsedModulesInstalled -->
<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { useConfirm } from 'primevue/useconfirm';
import { Button, DataTable, Column, ConfirmDialog } from 'primevue';
import AppLayout from '@/Layouts/AppLayout.vue';


const props = defineProps ( {
  users: Array,
} );

const page = usePage ();
const confirm = useConfirm ();

const format_date = ( date ) => {
  return new Date ( date ).toLocaleDateString ( 'en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  } );
};

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

      <DataTable
          :value="props.users"
          stripedRows
          :paginator="true"
          :rows="10"
          :rowsPerPageOptions="[5, 10, 20, 50]"
          tableStyle="min-width: 50rem"
      >
        <Column
            field="first_name"
            header="First Name"
            sortable
        ></Column>
        <Column
            field="last_name"
            header="Last Name"
            sortable
        ></Column>
        <Column
            field="email"
            header="Email"
            sortable
        ></Column>
        <Column
            field="role"
            header="Role"
            sortable
        ></Column>
        <Column
            field="created_at"
            header="Created"
            sortable
        >
          <template #body="slot_props">
            {{ format_date ( slot_props.data.created_at ) }}
          </template>
        </Column>
        <Column header="Actions">
          <template #body="slot_props">
            <div class="flex gap-2">
              <Button
                  icon="pi pi-pencil"
                  severity="secondary"
                  size="small"
                  @click="edit_user(slot_props.data.id)"
                  v-tooltip.top="'Edit'"
              />
              <Button
                  icon="pi pi-trash"
                  severity="danger"
                  size="small"
                  @click="delete_user(slot_props.data)"
                  :disabled="slot_props.data.id === page.props.auth.user.id"
                  v-tooltip.top="slot_props.data.id === page.props.auth.user.id ? 'Cannot delete yourself' : 'Delete'"
              />
            </div>
          </template>
        </Column>
      </DataTable>
    </div>
  </AppLayout>
</template>
