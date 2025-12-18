<!--suppress JSUnresolvedReference -->
<script setup>
import { Popover, Button } from "primevue";
import Avatar from "../../../Components/Avatar.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps ( { company: Object } )
const op = ref (); // Reference to the OverlayPanel

const toggle = ( event ) => {
  op.value.toggle ( event ); // Toggle visibility using the ref
};

</script>

<template>
  <button
      class="flex text-left gap-2 hover:opacity-80 transition-opacity"
      @click="toggle"
  >
    <span>{{ company.name }}</span>
  </button>
  <Popover ref="op">

      <!-- I had to do the image up like this because the logo component was not working -->
      <div class="px-2 py-1 flex justify-between text-sm cursor-pointer">

        <div class="border-2 border-darker-300  rounded-2xl">
        <img
            v-if="company?.logo"
            :src="company?.logo"
            alt="Company Logo"
            class="size-32 hover:border-primary-600"
        />
          <p v-else class="size-32 text-center flex items-center justify-center font-bold bg-darker-200">
            No Logo
          </p>
        </div>

        <div class="pl-4">

          <h1 class="font-bold">{{ company.name }}</h1>
          <p>{{ company.type }}</p>
          <Link :href="route('companies.show', company.id)">

            <Button class="mt-2 font-bold">
              Go to Company
            </Button>
          </Link>
        </div>
      </div>

  </Popover>
</template>