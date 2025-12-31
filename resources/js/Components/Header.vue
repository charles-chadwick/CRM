<script setup>

import { Button } from "primevue";
import { router } from '@inertiajs/vue3';

const props = defineProps({
  header: String,
  label: String,
  to_route: String
})

const cancel = () => {
  if ( props.to_route ) {
    router.visit ( route ( props.to_route ) );
  } else {
    window.history.back ();
  }
};

</script>

<template>
  <div class="mb-6 flex justify-between items-center">
    <h1 class="page-header">
      {{ props.header }}
    </h1>
    <Button
        type="button"
        :label="props.label"
        severity="secondary"
        outlined
        icon="pi pi-arrow-left"
        @click="cancel"
    />
  </div>
</template>

<style scoped>

</style>