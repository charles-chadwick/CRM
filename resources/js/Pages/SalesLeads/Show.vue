<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, router } from '@inertiajs/vue3'
import Card from '@/Components/Card.vue'
import Header from "@/Components/Header.vue";
import UserDetails from "@/Pages/Users/Partials/Details.vue"
import CompanyDetails from "@/Pages/Companies/Partials/Details.vue"
import ActionMenu from "../../Components/ActionMenu.vue";
import Status from "../../Components/Status.vue";

const props = defineProps ( { sales_lead: Object } )

const items = [
  {
    label: 'Edit',
    icon: 'pi pi-pencil',
    command: () => {
      router.visit ( route ( 'sales-leads.edit', props.sales_lead.id ) );
    }
  },
  {
    label: 'See Activity',
    icon: 'pi pi-history',
    command: () => {
      router.visit ( route ( 'activity.index', { on: 'SalesLead', id: props.sales_lead.id } ) );
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
          router.delete ( route ( 'sales-leads.destroy', props.sales_lead.id ) );
        }
      } );
    }
  }
];
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
          <Status
              :status="sales_lead.status"
              type="sales_lead"
          />
        </h1>
        <div class="flex justify-end gap-2">
          <div>
            <UserDetails :user="sales_lead.created_by" />
            <p><span class="font-bold">Created:</span> {{ sales_lead.created_at }}</p>
          </div>
          <ActionMenu :items="items" />
        </div>
      </div>

      <div>

        <p><span class="font-bold">Contacted:</span>
           {{  sales_lead.contacted_at }}
        </p>
        <p class="inline-flex"><span class="font-bold">Company:&nbsp;</span>
          <CompanyDetails :company="sales_lead.company" />
        </p>
      </div>
    </Card>
  </AppLayout>
</template>
