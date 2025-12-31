<!--suppress JSUnresolvedReference -->
<script setup>
import { Head } from '@inertiajs/vue3'
import AppLayout from "../../Layouts/AppLayout.vue";
import Card from "../../Components/Card.vue";
import Header from "../../Components/Header.vue";
import UserDetails from "../../Pages/Users/Partials/Details.vue"
const props = defineProps ( { discussion: Object } )
const discussion = props.discussion;
console.log(props.discussion);
</script>

<template>
  <AppLayout>
    <Head title="Show" />
    <Header header="Discussion" label="Back" />
    <Card>
      <div class="flex justify-between gap-4">
      <h1 class="card-header">{{ discussion.title }}</h1>
      <div class="text-sm text-right">
        <div v-for="user in discussion.users" :key="user.id">
          <UserDetails :user="user"/>
        </div>
      </div>
      </div>
    </Card>
  </AppLayout>
</template>
