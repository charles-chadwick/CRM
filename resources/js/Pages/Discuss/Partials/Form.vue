<!--suppress RequiredAttributes -->
<script setup>
import { Message, Textarea } from "primevue";
import { useForm} from "@inertiajs/vue3";
import Editor from 'primevue/editor'
const props = defineProps({
  discussion: {
    type: Object,
    required: true
  },
  on_id: {
    type: Number,
    required: true
  },
  on_type: {
    type: String,
    required: true
  }
})

const form = useForm({
  content: ''
})


</script>
<template>

  <form
      class="space-y-6 pt-4"
      @submit.prevent="submit"
  >
    <div>
      <label
          for="notes"
          class="font-semibold"
      >Notes</label>
      <Editor
          id="notes"
          v-model="form.content"
          :invalid="!!form.errors.content"
          placeholder="Enter notes (optional)"
          editorStyle="height: 200px"
          class="w-full"
      />
      <Message
          v-if="form.errors.content"
          severity="error"
          :closable="false"
      >
        {{ form.errors.content }}
      </Message>
    </div>
  </form>

</template>