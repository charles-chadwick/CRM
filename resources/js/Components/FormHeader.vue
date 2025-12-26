<script setup>

import { Button } from "primevue";
import { router } from '@inertiajs/vue3';

const props = defineProps({
  header: String,
  label: String,
  to_route: String
})

const cancel = () => {
  router.visit ( route ( props.to_route ) );
};

</script>

<template>
  <div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-darker-900">
      {{ props.header }}
    </h1>
    <Button
        type="button"
        :label="props.label"
        severity="secondary"
        outlined
        icon="pi pi-left-arrow"
        @click="cancel"
    />
  </div>
</template>

<style scoped>

</style>