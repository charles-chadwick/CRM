<script setup>

import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { Select } from "primevue";

const sort_by = ref ()
const sort_direction = ref ()
const sort_directions = [
  { label: 'Ascending', value: 'asc' },
  { label: 'Descending', value: 'desc' },
]

const props = defineProps (
    {
      route: { type: String, required: true },
      sort_by_items: { type: Array, required: true },
    } )

watch ( sort_by, ( value ) => {
  router.get ( route ( props.route, { sort_by: value, sort_direction: sort_direction.value } ) )
} )

watch ( sort_direction, ( value ) => {
  router.get ( route ( props.route, { sort_by: sort_by.value, sort_direction: value } ) )
} )

</script>

<template>
  <div class="flex gap-2">
    <Select
        v-model="sort_by"
        :options="sort_by_items"
        optionLabel="label"
        placeholder="Sort By..,"
        optionValue="value"
    />

    <Select
        v-model="sort_direction"
        :options="sort_directions"
        optionLabel="label"
        placeholder="Direction"
        optionValue="value"
    />
  </div>
</template>

<style scoped>

</style>