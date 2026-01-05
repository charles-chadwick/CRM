<!--suppress JSUnresolvedReference -->
<script setup>
import { Head, router } from '@inertiajs/vue3'
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import Contacts from '@/Components/Contacts.vue';
import Header from "@/Components/Header.vue";
import ActionMenu from "@/Components/ActionMenu.vue";
import Discussions from "@/Pages/Discussions/Partials/List.vue";
import { ConfirmDialog } from 'primevue';

const props = defineProps ( { customer: Object } )
const customer = props.customer;

</script>

<template>
  <AppLayout header="Customer">
    <Head title="Show" />
    <ConfirmDialog />
    <Header header="Customer Profile" />
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

      <ActionMenu
          :edit-route="route('customers.edit', customer.id)"
          :delete-route="route('customers.destroy', customer.id)"
          :activity-params="{ on: 'Customer', id: customer.id }"
          model-name="customer"
      />

    </Card>

    <div class="flex gap-4">
      <Card class="mt-4 w-1/2">
        <Contacts
            v-if="customer?.contacts"
            :contacts="customer?.contacts"
            :on_id="customer.id"
            on_type="Customer"
        />

      </Card>
      <Card class="mt-4 w-1/2">
        <Discussions
            v-if="customer?.discussions"
            :discussions="customer?.discussions"
            :on_id="customer.id"
            on_type="Customer"
        />
      </Card>
    </div>
  </AppLayout>
</template>
