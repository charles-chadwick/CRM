<script setup>
import Details from "./Details.vue";
import ActionButtons from "../../../Components/ActionButtons.vue";

const props = defineProps ( { customers: Array | Object } )

</script>

<template>
  <div class="flex justify-between">
    <h2 class="font-semibold mb-4">Customers</h2>
    <p class="text-darker-700">({{ customers.length }} total)</p>
  </div>
  <ul>
    <li
        v-for="customer in customers"
        class="py-2 flex flex-row justify-between gap-2"
    >
      <Details :customer="customer" />
      <ActionButtons :customer="customer" />
    </li>
  </ul>

</template>

<style scoped>

</style>