<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from "../../Layouts/AppLayout.vue";

defineProps ( { activities: Array | Object } )

const formatDate = ( dateString ) => {
  const date = new Date ( dateString )
  const month = String ( date.getMonth () + 1 ).padStart ( 2, '0' )
  const day = String ( date.getDate () ).padStart ( 2, '0' )
  const year = date.getFullYear ()
  let hours = date.getHours ()
  const minutes = String ( date.getMinutes () ).padStart ( 2, '0' )
  const ampm = hours >= 12 ? 'PM' : 'AM'
  hours = hours % 12 || 12
  const formattedHours = String ( hours ).padStart ( 2, '0' )

  return `${ month }/${ day }/${ year } at ${ formattedHours }:${ minutes } ${ ampm }`
}
</script>

<template>
  <Head title="Activities" />
  <AppLayout>
    <div v-for="activity in activities">
      {{ activity.description }} by {{ activity.causer.full_name }} on {{ formatDate ( activity.created_at ) }}
    </div>

  </AppLayout>
</template>
