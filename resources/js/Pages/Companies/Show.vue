<!--suppress JSUnresolvedReference -->
<script setup>
import { ref, computed, onMounted } from 'vue';
import AppLayout from "../../Layouts/AppLayout.vue";
import { Head } from '@inertiajs/vue3'
import { Select } from 'primevue';

const props = defineProps ( {
  company: Object,
} )

const company = props.company;

const selected_contact = ref ( null );

const contact_options = computed ( () => {
  return props.company?.contacts.map ( contact => ( {
    label: `${ contact.type }`,
    value: contact.id
  } ) );
} );

const primary_contact = computed ( () => {
  return props.company?.contacts.find ( contact => contact.is_primary ) || props.company?.contacts[ 0 ] || null;
} );

const current_contact = computed ( () => {
  if ( ! selected_contact.value ) return null;
  return props.company?.contacts.find ( contact => contact.id === selected_contact.value );
} );

onMounted ( () => {
  if ( primary_contact.value ) {
    selected_contact.value = primary_contact.value.id;
  }
} );
</script>

<template>
  <AppLayout>
    <Head :title="company.name + ` Information`" />
    <div class="px-8 py-4 text-left">
      <div class="bg-white rounded-lg shadow p-6 flex justify-between">

        <div class="flex gap-4">
          <div v-if="company.logo !== null">
            <img
                :src="company.logo"
                alt="Company Logo"
                class="size-32 rounded-xl border-2 border-darker-300 flex items-center justify-center"
            >
          </div>
          <div
              v-else
              class="size-32 rounded-xl border-2 border-darker-300 flex items-center justify-center"
          >
            <p>No Logo</p>
          </div>

          <div>
            <h1 class="text-3xl font-bold text-darker-900">
              {{ company.name }}
            </h1>
            <p>
              {{ company.type }}
            </p>
          </div>
        </div>

        <div class="w-80">
          <div
              v-if="props.company?.contacts.length === 0"
              class="text-darker-500"
          >
            No Contacts. Add One
          </div>
          <div
              v-else
              class="flex flex-col gap-4"
          >
            <div class="flex flex-col gap-2">
              <label
                  for="contact-select"
                  class="font-semibold"
              >Select Contact</label>
              <Select
                  id="contact-select"
                  v-model="selected_contact"
                  :options="contact_options"
                  optionLabel="label"
                  optionValue="value"
                  placeholder="Select a contact"
                  class="w-full"
              />
            </div>

            <div
                v-if="current_contact"
                class="bg-darker-50 p-4 rounded-lg"
            >
              <div class="flex justify-between">
                <h3 class="font-semibold text-lg mb-2">{{ current_contact.type }}</h3>
                <i
                    class="pi pi-star-fill text-accent-500"
                    v-if="current_contact.is_primary"
                />
              </div>

              <div class="space-y-1 text-sm">

                <p v-if="current_contact.address_1 && current_contact.address_2">
                  {{ current_contact.address_1 }} {{ current_contact.address_2 }}
                </p>

                <p v-if="current_contact.city || current_contact.state">
                  {{ current_contact.city }}, {{ current_contact.state }} {{ current_contact.postal_code }}
                </p>

                <p v-if="current_contact.phone">Phone: {{ current_contact.phone }}</p>
                <p v-if="current_contact.fax">Fax: {{ current_contact.fax }}</p>

              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </AppLayout>
</template>
