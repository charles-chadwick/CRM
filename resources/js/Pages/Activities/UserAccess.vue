<!--suppress JSUnresolvedReference -->
<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import Header from "@/Components/Header.vue";
import UserDetails from "@/Pages/Users/Partials/Details.vue"
import { ref } from 'vue'
import Pagination from "../../Components/Pagination.vue";


defineProps ( { activities: Array | Object } )

const expanded_activities = ref ( {} )

const format_date = ( date_string ) => {
  const date = new Date ( date_string )
  const month = String ( date.getMonth () + 1 ).padStart ( 2, '0' )
  const day = String ( date.getDate () ).padStart ( 2, '0' )
  const year = date.getFullYear ()
  let hours = date.getHours ()
  const minutes = String ( date.getMinutes () ).padStart ( 2, '0' )
  const am_pm = hours >= 12 ? 'PM' : 'AM'
  hours = hours % 12 || 12
  const formatted_hours = String ( hours ).padStart ( 2, '0' )

  return `${ month }/${ day }/${ year } at ${ formatted_hours }:${ minutes } ${ am_pm }`
}

</script>

<template>
  <Head title="Activities" />
  <AppLayout>
    <Header
        header="Activities"
        label="Back"
    />

    <Card>
      <h2 class="card-header">Database</h2>
      <div
          v-for="activity in activities.data"
          :key="activity.id"
          class="flex justify-between gap-4 border-b border-darker-200 py-2"
      >
        <div>
          <div class="inline-flex justify-start items-center py-2 gap-1">
            <UserDetails :user="activity.causer" />
            <a
                class="click  underline"
                target="_blank"
                :href="activity.properties.url">{{ activity.properties.url }}
            </a>
            on {{ format_date ( activity.created_at ) }}
          </div>

        </div>

      </div>
      <Pagination
          :pagination="activities"
          v-if="activities.data.length > 0"
      />
      <p
          class="p-4 text-center"
          v-else
      >No companies found.</p>
    </Card>


  </AppLayout>
</template>
