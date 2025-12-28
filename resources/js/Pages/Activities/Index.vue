<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from "../../Layouts/AppLayout.vue";

defineProps ( { activities: Array | Object } )
</script>

<template>
  <Head title="Activities" />
  <AppLayout>
    {{ activities }}
  </AppLayout>
</template>
