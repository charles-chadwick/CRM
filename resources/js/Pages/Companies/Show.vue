<!--suppress JSUnresolvedReference -->
<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import { Head } from '@inertiajs/vue3'

defineProps ( { company: Object } )
</script>

<template>
  <AppLayout>
    <Head title="Show" />
    <h1 class="font-bold">{{ company.name }}</h1>
  </AppLayout>
</template>
