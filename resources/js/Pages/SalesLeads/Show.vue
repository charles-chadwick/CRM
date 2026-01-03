<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from '@inertiajs/vue3'
import Card from '@/Components/Card.vue'
import Header from "@/Components/Header.vue";
import UserDetails from "@/Pages/Users/Partials/Details.vue"
import CompanyDetails from "@/Pages/Companies/Partials/Details.vue"

defineProps ( { sales_lead: Object } )
</script>

<template>
  <AppLayout>
    <Head title="Show" />
    <Header
        header="Sales Lead"
    />
    <Card>
      <div class="flex justify-between gap-2">
        <h1 class="card-header">
          {{ sales_lead.title }}
        </h1>
        <div>
          <UserDetails :user="sales_lead.created_by" />
          <p><span class="font-bold">Created:</span> {{ sales_lead.created_at }}</p>
        </div>
      </div>

      <div>
        <h2 class="font-bold">Company:</h2>
        <CompanyDetails :company="sales_lead.company" />
      </div>
    </Card>
  </AppLayout>
</template>
