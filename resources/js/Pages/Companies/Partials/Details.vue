<!--suppress JSUnresolvedReference -->
<script setup>
import { Popover, Button } from "primevue";
import Avatar from "../../../Components/Avatar.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps ( { company: Object } )
const company = props.company;
const op = ref (); // Reference to the OverlayPanel

const toggle = ( event ) => {
  op.value.toggle ( event ); // Toggle visibility using the ref
};

</script>

<template>
  <button
      class="flex items-center gap-2"
      @click="toggle"
  >
    <span>{{ company.name }}</span>
  </button>
  <Popover ref="op">
    <div class="px-2 py-1 flex justify-between text-sm">

      <!-- I had to do the image up like this because the avatar component was not working -->
      <div class="rounded-xl size-32 border-2 border-darker-300 hover:border-primary-600 ">
        <img
            v-if="company?.logo"
            :src="company?.logo"
            alt="Logo"
            class="cursor-pointer"
        />

        <p
            v-else
            class="font-bold flex items-center justify-center text-darker-600 text-lg"
        >No Logo</p>

      </div>

      <div class="pl-4">

        <h1 class="font-bold">{{ company.name }}</h1>
        <p>{{ company.type }}</p>
        <p>{{ company.email }}</p>
        <Link :href="route('companies.show', company.id)">

          <Button class="mt-2 font-bold">
            Go to company
          </Button>
        </Link>
      </div>

    </div>

  </Popover>
</template>