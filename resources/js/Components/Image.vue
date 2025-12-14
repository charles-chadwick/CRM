<script setup>
import { useForm } from "@inertiajs/vue3";
import { Dialog, Button, FileUpload } from "primevue";
import { ref } from "vue";

const props = defineProps ( {
  image: String,
  on_type: String,
  on_id: [ String, Number ],
  size: String,
  show_form: {
    type: Boolean,
    default: false
  },
  upload_endpoint: {
    type: String,
    default: '/image/upload'
  },
  remove_endpoint: {
    type: String,
    default: '/image/remove'
  },
  alt_text: {
    type: String,
    default: 'Image'
  },
  remove_label: {
    type: String,
    default: 'Remove This Image'
  },
  placeholder_text: {
    type: String,
    default: 'Drag and drop image here to upload.'
  },
  image_type: {
    type: String,
    default: "logo"
  }
} )
const size = props.size;
let image = props.image;

const sizes = {
  sm: 'size-16',
  md: 'size-24',
  lg: 'size-32',
}

const form = useForm ( {
  on_type: props.on_type,
  on_id: props.on_id,
  image: null,
  image_type: props.image_type
} )

const uploadImage = () => {
  form.post ( props.upload_endpoint )
}

const removeImage = () => {
  form.post ( props.remove_endpoint )
  image = null;
}

const showDialog = ref ( false )

const handleShowDialog = () => {
  showDialog.value = true;
}

const handleCloseDialog = () => {
  showDialog.value = false;
}

</script>

<template>
  <div>
    <div v-if="image">
      <img
          @click="handleShowDialog"
          :alt="alt_text"
          :class="['rounded-2xl mx-auto my-2 border-2 border-darker-300 hover:border-primary-600', sizes[size]]"
          :src="image"
      />
      <Button
          v-if="!show_form"
          @click="removeImage"
          class="flex-none cursor-pointer rounded-2xl"
      >
        {{ remove_label }}
      </Button>
    </div>
    <div v-else>
      <FileUpload
          :maxFileSize="2000000"
          accept="image/*"
          :customUpload="true"
          @uploader="uploadImage"
          @select="(e) => form.image = e.files[0]"
      >
        <template #empty>
          <p>{{ placeholder_text }}</p>
        </template>

      </FileUpload>
    </div>
  </div>
  <Dialog
      modal
      :dismissableMask="true"
      v-model:visible="showDialog"
  >
    <template #container>
      <img
          @click="handleCloseDialog"
          :src="image"
          class="rounded-xl border-2 border-darker-300 hover:border-primary-600"
          :alt="alt_text"
      />

    </template>
  </Dialog>
</template>

<style scoped>

</style>