<!--suppress JSUnresolvedReference -->
<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  pagination: Object
})

const pagination = props.pagination;
console.log(pagination)
</script>

<template>
  <nav class="relative flex justify-center mt-4">
    <template v-for="link in pagination.links" :key="link.label">
      <Link
          preserve-scroll
          :href="link.url ?? ''"
          v-html="link.label"
          class="flex items-center justify-center px-4 py-2 rounded-full text-darker-600"
          :class="{ 'bg-darker-200': link.active, 'text-darker-700!': !link.route }"
      />
    </template>
  </nav>
</template>
