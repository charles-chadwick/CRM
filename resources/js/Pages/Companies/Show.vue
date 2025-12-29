<!--suppress JSUnresolvedReference -->
<script setup>
import { computed, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import Contacts from '@/Pages/Contacts/Partials/Details.vue';
import Card from '@/Components/Card.vue';
import CustomerList from '@/Pages/Customers/Partials/List.vue';
import { Menu, Button, ConfirmDialog } from 'primevue';
import { useConfirm } from 'primevue/useconfirm';

const { company } = defineProps ( {
  company: {
    type: Object,
    required: true
  },
} );

const page_title = computed ( () => `${ company.name } Information` );

const menu = ref ();
const confirm = useConfirm ();

const items = [
  {
    label: 'Edit',
    icon: 'pi pi-pencil',
    command: () => {
      router.visit ( route ( 'companies.edit', company.id ) );
    }
  },
  {
    label: 'See Activity',
    icon: 'pi pi-history',
    command: () => {
      router.visit ( route ( 'activity.index', { on: 'Company', id: company.id } ) );
    }
  },
  {
    label: 'Delete',
    icon: 'pi pi-trash',
    command: () => {
      confirm.require ( {
        message: 'Are you sure you want to delete this company?',
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
          router.delete ( route ( 'companies.destroy', company.id ) );
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
  <AppLayout>
    <Head :title="page_title" />
    <ConfirmDialog />
    <Card class="flex justify-between">
      <div class="flex gap-4">
        <!-- Logo Section -->
        <div
            v-if="company.logo"
            class="size-32"
        >
          <img
              :src="company.logo"
              :alt="`${company.name} Logo`"
              class="rounded-xl size-32 border-2 border-darker-300 object-cover"
          >
        </div>
        <div
            v-else
            class="size-32 rounded-xl border-2 border-darker-300 bg-darker-200 text-darker-400 font-semibold flex items-center justify-center"
        >
          <p>No Logo</p>
        </div>

        <!-- Company Info -->
        <div>
          <h1 class="text-3xl font-bold text-darker-900">
            {{ company.name }}
          </h1>
          <p class="text-darker-600">
            {{ company.type }}
          </p>
        </div>
      </div>

      <!-- Menu Component -->
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
        >
          <template #item="{ item, props }">
            <a class="flex items-center" v-bind="props.action">
              <span :class="item.icon" />
              <span>{{ item.label }}</span>
              <span v-if="item.shortcut" class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1">{{ item.shortcut }}</span>
            </a>
          </template>
        </Menu>
      </div>
    </Card>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <Card class="mt-4">
        <Contacts
            :contacts="company.contacts"
            :on_id="company.id"
            on_type="Company"
        />
      </Card>
      <Card class="mt-4">
        <CustomerList
            :customers="company.customers"
        />
      </Card>
    </div>

  </AppLayout>
</template>
