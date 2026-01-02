<!--suppress JSUnresolvedReference -->
<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import Header from "@/Components/Header.vue";
import UserDetails from "@/Pages/Users/Partials/Details.vue"
import { ref } from 'vue'


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

const toggle_changes = ( activity_id ) => {
  expanded_activities.value[ activity_id ] = ! expanded_activities.value[ activity_id ]
}

const formatPropertyName = ( property ) => {
  return property
      .split ( '_' )
      .map ( word => word.charAt ( 0 ).toUpperCase () + word.slice ( 1 ) )
      .join ( ' ' )
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
      <div
          v-for="activity in activities"
          :key="activity.id"
          class="flex justify-between gap-4 border-b border-darker-200 py-2"
      >
        <div>
          <div  class="flex justify-start py-2 gap-1">
          {{ activity.description }} by

          <UserDetails :show_avatar="false" :user="activity.causer" />

          on {{ format_date ( activity.created_at ) }}
          </div>
          <div
              v-if="expanded_activities[activity.id]"
              class="mt-2.5 pl-5 flex-none"
          >
            <div
                v-for="( new_value, property ) in activity.properties.attributes"
                :key="property"
            >
              <template v-if="property !== 'created_at' && property !== 'updated_at' && property !== 'updated_by_id'">
                <strong>{{ formatPropertyName ( property ) }}:</strong>
                <div class="pl-2.5">
                  <div>Old: <span
                      class="text-red-500"
                      v-html="activity.properties.old?.[ property ] ?? 'N/A'"
                  ></span></div>
                  <div>New: <span
                      class="text-lime-700"
                      v-html="new_value"
                  ></span></div>
                </div>
              </template>
            </div>
          </div>
        </div>
        <div>

          <a
              v-if="activity.log_name === 'Database' && activity.description === 'Updated'"
              href="#"
              @click.prevent="toggle_changes ( activity.id )"
              class="ml-2.5"
          >
            See Changes
          </a>


        </div>
      </div>
    </Card>
  </AppLayout>
</template>
