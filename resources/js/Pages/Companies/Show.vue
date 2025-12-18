<!--suppress JSUnresolvedReference -->
<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import { Head } from '@inertiajs/vue3'
import Contacts from '../Contacts/Partials/Details.vue'

const props = defineProps ( {
  company: Object,
} )

const company = props.company;

</script>

<template>
  <AppLayout>
    <Head :title="company.name + ` Information`" />
    <!-- start banner -->
    <div class="px-8 py-4 text-left">
      <div class="bg-white rounded-lg shadow p-6 flex justify-between">

        <div class="flex gap-4">
          <div v-if="company.logo !== null">
            <img
                :src="company.logo"
                alt="Company Logo"
                class="size-32 rounded-xl border-2 border-darker-300 flex items-center justify-center"
            >
          </div>
          <div
              v-else
              class="size-32 rounded-xl border-2 border-darker-300 bg-darker-200 text-darker-400 font-semibold flex items-center justify-center"
          >
            <p>No Logo</p>
          </div>

          <div>
            <h1 class="text-3xl font-bold text-darker-900">
              {{ company.name }}
            </h1>
            <p>
              {{ company.type }}
            </p>
          </div>
        </div>

        <Contacts :contacts="company.contacts" :on_id="company.id" on_type="Company" />
      </div>
    </div>

    <!-- start banner -->

  </AppLayout>
</template>
