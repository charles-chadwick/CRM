<!--suppress JSUnresolvedReference -->
<script setup>

import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import ContactsList from "../Contacts/Partials/List.vue";

const props = defineProps ( { customer: Object|Array } )
const customer = props.customer.data;

</script>

<template>
  <AuthenticatedLayout>
    <div class="flex items-start justify-start space-y-4">
    <img
        :src="customer.attributes.avatar_url"
        alt="avatar"
        class="rounded-2xl shadow-sm h-24 w-24 mb-4 mr-4"
    >
      <div>
      <h1 class="text-xl font-bold">{{ customer.attributes.full_name }}</h1>
        <p>Title: {{ customer.attributes.title }}</p>
      <p>{{ customer.attributes.email }}</p>
      </div>
    </div>

  <ContactsList :contacts="customer.relationships.contacts" />
  </AuthenticatedLayout>
</template>

<style scoped>

</style>