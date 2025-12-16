<!--suppress JSUnresolvedReference -->
<script setup>
import { Popover, Button } from "primevue";
import Avatar from "../../../Components/Avatar.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps ( { user: Object } )
const op = ref (); // Reference to the OverlayPanel

const toggle = ( event ) => {
  op.value.toggle ( event ); // Toggle visibility using the ref
};
</script>

<template>
  <button
      class="flex items-center gap-2 hover:opacity-80 transition-opacity"
      @click="toggle"
  >
    <Avatar :image="user.attributes.avatar" />
    <span>{{ user.attributes.full_name }}</span>
  </button>
  <Popover ref="op">
    <div class="px-2 py-1 flex justify-between text-sm">

      <!-- I had to do the image up like this because the avatar component was not working -->

      <img
          :src="user.attributes.avatar"
          alt="Avatar"
          class="rounded-xl size-32 border-2 border-darker-300 hover:border-primary-600 cursor-pointer"
      />

      <div class="pl-4">

        <h1 class="font-bold">{{ user.attributes.full_name }}</h1>
        <p>{{ user.attributes.role }}</p>
        <p>{{ user.attributes.email }}</p>
        <Link :href="route('users.show', user.id)">

          <Button class="mt-2 font-bold">
            Go to profile
          </Button>
        </Link>
      </div>

    </div>

  </Popover>
</template>

<style scoped>

</style>