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
            :src="customer.avatar"
            alt="Avatar"
            class=" rounded-xl size-32 border-2 border-darker-300 hover:border-primary-600 cursor-pointer"
        />
        <h1 class="card-header pl-4">{{ customer.full_name_with_salutations }}</h1>
      </div>
      <div>
        <Contacts
            :contacts="customer.contacts"
            :on_id="customer.id"
            on_type="Company"
        />
      </div>
    </Card>

  </AppLayout>
</template>
