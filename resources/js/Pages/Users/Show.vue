<!--suppress JSUnresolvedReference -->
<script setup>
import { Head, router } from '@inertiajs/vue3'
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import { ConfirmDialog } from 'primevue';
import Header from "@/Components/Header.vue";
import ActionMenu from "@/Components/ActionMenu.vue";

const props = defineProps ( { user: Object } )
</script>

<template>
  <AppLayout header="Customer">
    <Head title="Show" />
    <ConfirmDialog />
    <Header header="User Profile" />
    <Card class="flex justify-between gap-4">
      <div class="flex flex-start flex-row">
        <img
            :src="user?.avatar || '/images/default-user.png'"
            alt="Avatar"
            class=" rounded-xl size-32 border-2 border-darker-300"
        />
        <div class="pl-4">
          <h1 class="card-header">{{ user?.full_name_with_salutations }}</h1>
          <p class="mt-1">{{ user?.role }}</p>
          <p class="mt-1">{{ user?.email }}</p>
        </div>
      </div>
      <ActionMenu
          :edit-route="route('users.edit', user.id)"
          :delete-route="route('users.destroy', user.id)"
          :activity-params="{ on: 'User', id: user.id }"
          model-name="user"
      />
    </Card>
  </AppLayout>
</template>
