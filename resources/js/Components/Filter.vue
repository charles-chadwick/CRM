<script setup>
import { ref, watch } from 'vue';
import { MultiSelect } from 'primevue';

const props = defineProps ( {
  options: {
    type: Array,
    required: true,
    default: () => []
  }
} );

const selected_options = ref ( props.options.map ( option => option.value ) );

watch ( () => props.options, ( new_options ) => {
  selected_options.value = new_options.map ( option => option.value );
}, { immediate: true } );
</script>

<template>
  <MultiSelect
      v-model="selected_options"
      :options="options"
      optionLabel="label"
      optionValue="value"
      placeholder="Select filters"
  />
</template>

<style scoped>

</style>