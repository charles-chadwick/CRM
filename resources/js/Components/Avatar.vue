<script setup>
import { Dialog } from "primevue";
import { computed, ref } from "vue";

const props = defineProps ( {
  image: String,
  on: Object,
  size: { type: String, default: 'xs' },
  allow_popup: { type: Boolean, default: false }
} )
const image = props.image || '/images/default-user.png';
const size = props.size;

const sizes = {
  xs: 'size-8',
  sm: 'size-16',
  md: 'size-24',
  lg: 'size-32',
  xl: 'size-64',
}
const showDialog = ref ( false )
const handleShowDialog = () => {
  if ( props.allow_popup ) {
    showDialog.value = true;
  }
}
const handleCloseDialog = () => {
  showDialog.value = false;
}

const imageClass = computed ( () => {
  const baseClasses = 'border-2 border-darker-300 hover:border-primary-600 cursor-pointer';

  return {
    thumbnail: `rounded-full object-cover ${ sizes[ size ] } ${ baseClasses }`,
    large: `rounded-2xl size-64 ${ baseClasses }`
  };
} );
</script>

<template>
  <img
      @click="handleShowDialog"
      v-if="image !== null"
      :src="image"
      :alt="image"
      :class="imageClass.thumbnail"
  />
  <Dialog
      modal
      :dismissableMask="true"
      v-model:visible="showDialog"
  >
    <template #container>
      <div class="flex justify-center">
      <img
          @click="handleCloseDialog"
          :src="image"
          :class="imageClass.large"
          alt="Avatar"
      />
      </div>
    </template>
  </Dialog>
</template>

<style scoped>

</style>