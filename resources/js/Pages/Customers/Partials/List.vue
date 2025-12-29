<script setup>
import Details from "./Details.vue";
import Avatar from "../../../Components/Avatar.vue";
const props = defineProps({customers: Array|Object})

</script>

<template>
  <h2 class="font-semibold mb-4">Customers</h2>

  <ul>
    <li v-for="customer in customers">
<Details :customer="customer" />
    </li>
  </ul>

</template>

<style scoped>

</style>