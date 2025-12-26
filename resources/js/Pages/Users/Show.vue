<!--suppress JSUnresolvedReference -->
<script setup>
import { Head, router } from '@inertiajs/vue3'
import AppLayout from "../../Layouts/AppLayout.vue";
import Card from "../../Components/Card.vue";
import { Menu, Button, ConfirmDialog } from 'primevue';
import { ref } from 'vue';
import { useConfirm } from 'primevue/useconfirm';

const props = defineProps ( { user: Object } )

const menu = ref ();
const confirm = useConfirm ();

const items = [
  {
    label: 'Edit',
    icon: 'pi pi-pencil',
    command: () => {
      router.visit ( route ( 'users.edit', props.user.id ) );
    }
  },
  {
    label: 'Delete',
    icon: 'pi pi-trash',
    command: () => {
      confirm.require ( {
        message: 'Are you sure you want to delete this user?',
        header: 'Delete Confirmation',
        icon: 'pi pi-exclamation-triangle',
        rejectLabel: 'Cancel',
        acceptLabel: 'Delete',
        rejectProps: {
          severity: 'secondary'
        },
        acceptProps: {
          severity: 'danger'
        },
        accept: () => {
          router.delete ( route ( 'users.destroy', props.user.id ) );
        }
      } );
    }
  }
];

const toggle = ( event ) => {
  menu.value.toggle ( event );
};
</script>

<template>
  <AppLayout header="Customer">
    <Head title="Show" />
    <ConfirmDialog />
    <Card class="flex justify-between gap-4">
      <div class="flex flex-start flex-row">
        <img
            :src="user.avatar"
            alt="Avatar"
            class=" rounded-xl size-32 border-2 border-darker-300 hover:border-primary-600 cursor-pointer"
        />
        <div class="pl-4">
          <h1 class="card-header">{{ user.full_name_with_salutations }}</h1>
          <p class="mt-1">{{ user.role }}</p>
          <p class="mt-1">{{ user.email }}</p>
        </div>
      </div>
      <div>
        <Button
            icon="pi pi-ellipsis-v"
            severity="secondary"
            @click="toggle"
            aria-haspopup="true"
            aria-controls="overlay_menu"
        />
        <Menu
            ref="menu"
            id="overlay_menu"
            :model="items"
            :popup="true"
        />
      </div>
    </Card>
  </AppLayout>
</template>
