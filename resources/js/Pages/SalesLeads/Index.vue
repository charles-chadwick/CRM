<!--suppress JSUnresolvedReference -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import { CreateButton } from '@/Components/ActionButtons.vue'
import { ConfirmDialog } from 'primevue'
import Status from "../../Components/Status.vue";
import Details from '@/Pages/Companies/Partials/Details.vue'
defineProps ( { sales_leads: Object } )


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

    <ul
        role="list"
        class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"
    >
      <li
          v-for="sales_lead in sales_leads.data"
          :key="sales_lead.id"
          class="col-span-1 divide-y divide-darker-200 rounded-lg bg-white shadow-sm"
      >
        <div class="flex w-full items-center justify-between space-x-6 p-6">
          <div class="flex-1 truncate">
            <div class="flex items-center space-x-3">
              <h3 class="truncate  font-semibold text-lg text-darker-900">{{ sales_lead.title }}</h3>
              <Status
                  :status="sales_lead.status"
                  type="sales_lead"
              />
            </div>
              {{  sales_lead.company.name }}
            <p class="mt-1 truncate  text-darker-500">{{ sales_lead.type }}</p>
          </div>
        </div>
        <div>
          <div class="-mt-px flex divide-x divide-darker-200">
            <div class="flex w-0 flex-1">
              <Link
                  :href="route('sales-leads.show', sales_lead.id)"
                  class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4  font-semibold text-darker-900"
              >
                View
              </Link>
            </div>
            <div class="flex w-0 flex-1">
              {{  sales_lead?.company?.contacts }}
              <a
                  :href="`mailto:${sales_lead?.email}`"
                  class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4  font-semibold text-darker-900"
              >
                Email
              </a>
            </div>
            <div class="-ml-px flex w-0 flex-1">
              <a
                  :href="`tel:${sales_lead.telephone}`"
                  class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4  font-semibold text-darker-900"
              >
                Call
              </a>
            </div>
          </div>
        </div>
      </li>
    </ul>
    <Pagination
        v-if="sales_leads.data?.length > 0"
        :pagination="sales_leads"
    />
  </AppLayout>
</template>
