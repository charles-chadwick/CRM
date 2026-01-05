<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, router } from '@inertiajs/vue3'
import Card from '@/Components/Card.vue'
import Header from "@/Components/Header.vue";
import UserDetails from "@/Pages/Users/Partials/Details.vue"
import Discussions from "@/Pages/Discussions/Partials/List.vue";

import ActionMenu from "../../Components/ActionMenu.vue";
import Status from "../../Components/Status.vue";
import { ConfirmDialog } from 'primevue';
import Contacts from "../../Components/Contacts.vue";

const props = defineProps ( { sales_lead: Object } )
</script>

<template>
  <AppLayout>
    <Head title="Show" />
    <ConfirmDialog />
    <Header
        header="Sales Lead"
    />
    <Card>
      <div class="flex justify-between gap-2">
        <div>
          <h1 class="card-header">
            {{ sales_lead.title }}
            <Status
                :status="sales_lead.status"
                type="sales_lead"
            />
          </h1>
          <div>
            <p>{{ sales_lead.type }} lead</p>
            <p>Contacted: {{ sales_lead.contacted_at }}</p>
          </div>
        </div>
        <div class="flex justify-end gap-2">
          <div>
            <UserDetails :user="sales_lead.created_by" />
            <p><span class="font-bold">Created:</span> {{ sales_lead.created_at }}</p>
          </div>
          <ActionMenu
              :edit-route="route('sales-leads.edit', sales_lead.id)"
              :delete-route="route('sales-leads.destroy', sales_lead.id)"
              :activity-params="{ on: 'SalesLead', id: sales_lead.id }"
              model-name="sales lead"
          />
        </div>
      </div>
    </Card>

  </AppLayout>
</template>