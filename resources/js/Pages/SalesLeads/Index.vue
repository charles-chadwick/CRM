<!--suppress JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

  import { Head, Link } from '@inertiajs/vue3'
  import Card from '@/Components/Card.vue'
  import Pagination from '@/Components/Pagination.vue'
  import {CreateButton, EditButton, DeleteButton} from '@/Components/ActionButtons.vue'
  import { Button, ConfirmDialog } from 'primevue'

  defineProps({sales_leads: Object})
</script>

<template>
  <AppLayout>
    <Head title="Sales Leads" />
    <div class="flex justify-between items-center mb-6">
      <h1 class="page-header">Sales Leads</h1>
      <CreateButton
          prefix="sales-leads"
          message="Sales Lead"
      />
    </div>
    <ConfirmDialog />
    <Card>
      <table class="w-full">
        <thead>
        <tr class="table-header">
          <th>ID</th>
          <th>Name</th>
          <th>Company</th>
          <th>Status</th>
          <th>Value</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-if="sales_leads.data?.length !== 0"
            v-for="sales_lead in sales_leads.data"
            :key="sales_lead.id"
            class="table-row"
        >
          <td class="table-cell"># {{ sales_lead.id }}</td>
          <td class="table-cell">{{ sales_lead.name }}</td>
          <td class="table-cell">{{ sales_lead.company?.name }}</td>
          <td class="table-cell">{{ sales_lead.status }}</td>
          <td class="table-cell">{{ sales_lead.value }}</td>
          <td class="table-cell">{{ sales_lead.created_at }}</td>
          <td class="table-cell">
              <EditButton
                prefix="sales_leads"
                :id="sales_lead.id"
              />
              <DeleteButton
                  prefix="sales_leads"
                  :id="sales_lead.id"
                  message="Sales Lead"
              />
          </td>
        </tr>
        <tr v-else>
          <td class="table-cell text-center" colspan="8">No sales leads found.</td>
        </tr>
        </tbody>
      </table>
    </Card>
    <Pagination
        v-if="sales_leads.data?.length > 0"
        :pagination="sales_leads"
    />
  </AppLayout>
</template>
