<!--suppress JSUnresolvedReference -->
<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from "../../Layouts/AppLayout.vue";
import Card from "../../Components/Card.vue";
import Contacts from '../Contacts/Partials/Details.vue';

defineProps ( { customer: Object } )
</script>

<template>
  <AppLayout header="Customer">
    <Head title="Show" />
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
    </Card>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <Card class="mt-4">
        <Contacts
            :contacts="customer.contacts"
            :on_id="customer.id"
            on_type="Company"
        />

      </Card>
    </div>
  </AppLayout>
</template>
