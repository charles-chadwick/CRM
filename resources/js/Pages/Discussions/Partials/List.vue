<!--suppress JSUnresolvedReference -->
<script setup>
import { Link } from "@inertiajs/vue3";
const props = defineProps({ discussions: Array, on_type: String, on_id: Number })

</script>
<template>
  <div class="flex justify-between">
    <h2 class="font-semibold mb-4">Discussions</h2>
    <p class="text-darker-700">({{ discussions.length }} total)</p>
  </div>
  <ul>
    <li
        v-for="discussion in discussions"
        class="py-2 flex flex-row justify-between gap-2"
    >
      <Link :href="route('discussions.show', discussion.id)">
        {{ discussion.title }}
      </Link>
      <div class="text-sm text-right">
        <p>{{ discussion.created_at }}<br /> by {{ discussion.created_by.full_name }}</p>
      </div>

    </li>
  </ul>

</template>