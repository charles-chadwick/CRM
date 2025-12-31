<script setup>

import { Button, Select } from "primevue";

const sortOptions = [
  { label: 'Type', value: 'company_type_id' }
]
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps ( { route: { type: String, required: true } } )
const sort_by = ref ( '' )
const clearSort = () => {
  sort_by.value = ''
}

watch ( [ sort_by ], ( [ sort_by_value ] ) => {
  router.get (
      route ( props.route ),
      {
        sort_by: sort_by_value,
      },
      {
        preserveState: true,
        preserveScroll: true,
        replace: true,
      }
  )
} )
</script>

<template>
  <div class="flex gap-2">
    <Select
        v-model="sort_by"
        :options="sortOptions"
        optionLabel="label"
        optionValue="value"
        placeholder="Sort by..."
        class="w-full"
    />
    <Button
        v-bind:disabled="sort_by === ''"
        icon="pi pi-times"
        severity="secondary"
        @click="clearSort"
        aria-label="Clear sort_by"
    />
  </div>
</template>

<style scoped>

</style>