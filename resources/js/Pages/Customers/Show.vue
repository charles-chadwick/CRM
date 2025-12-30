<!--suppress JSUnresolvedReference -->
<script setup>
import { Head, router } from '@inertiajs/vue3'
import AppLayout from "../../Layouts/AppLayout.vue";
import Card from "../../Components/Card.vue";
import Contacts from '../Contacts/Partials/Details.vue';
import Header from "../../Components/Header.vue";
import { useConfirm } from "primevue/useconfirm";
import ActionMenu from "../../Components/ActionMenu.vue";
import Discussions from "../../Pages/Discuss/Partials/List.vue"
const props = defineProps ( { customer: Object } )
const customer = props.customer;

const confirm = useConfirm ();

const items = [
  {
    label: 'Edit',
    icon: 'pi pi-pencil',
    command: () => {
      router.visit ( route ( 'customers.edit', customer.id ) );
    }
  },
  {
    label: 'See Activity',
    icon: 'pi pi-history',
    command: () => {
      router.visit ( route ( 'activity.index', { on: 'Customer', id: customer.id } ) );
    }
  },
  {
    label: 'Delete',
    icon: 'pi pi-trash',
    command: () => {
      confirm.require ( {
        message: 'Are you sure you want to delete this customer?',
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
          router.delete ( route ( 'customers.destroy', customer.id ) );
        }
      } );
    }
  }
];
</script>

<template>
  <AppLayout header="Customer">
    <Head title="Show" />
    <Header header="Customer" label="Back to Company" />
    <Card class="flex justify-between gap-4">
      <div class="flex flex-start flex-row">
        <img
            :src="customer?.avatar || '/images/default-user.jpg'"
            alt="Avatar"
            class=" rounded-xl size-32 border-2 border-darker-300 hover:border-primary-600 cursor-pointer"
        />
        <div class="pl-4">
          <h1 class="card-header">{{ customer.full_name_with_salutations }}</h1>
          <p v-if="customer.title">{{ customer.title }}</p>
          <p>{{ customer.email }}</p>
        </div>

      </div>

      <ActionMenu :items="items" />

    </Card>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <Card class="mt-4">
        <Contacts
            :contacts="customer.contacts"
            :on_id="customer.id"
            on_type="Company"
        />

      </Card>
      <Card class="mt-4">
        <Discussions :discussions="customer.discussions" />
      </Card>
    </div>
  </AppLayout>
</template>
