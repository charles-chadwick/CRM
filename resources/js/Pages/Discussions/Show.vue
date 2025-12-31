<!--suppress JSUnresolvedReference -->
<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from "../../Layouts/AppLayout.vue";
import Card from "../../Components/Card.vue";

defineProps ( { discussion: Object } )
</script>

<template>
  <AppLayout>
    <Head title="Show" />
    <Card>
      <h1 class="page-header">{{ discussion.title }}</h1>
    </Card>
  </AppLayout>
</template>
