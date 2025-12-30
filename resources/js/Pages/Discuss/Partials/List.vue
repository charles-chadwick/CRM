<script setup>
import { ref } from 'vue';
import { Dialog, Button } from 'primevue';
import Form from './Form.vue';

const props = defineProps ( {
  discussions: {
    type: Array,
    default: () => []
  },
  on_type: {
    type: String,
    required: true
  },
  on_id: {
    type: Number,
    required: true
  }
} );

const dialogVisible = ref ( false );
const selected_discussion = ref ( {
  on_id: null,
  on_type: null
} );

const handleDialog = ( discussion = null ) => {
  selected_discussion.value = discussion ? {
    on_id: discussion.on_id,
    on_type: discussion.on_type
  } : {
    on_id: props.on_id,
    on_type: props.on_type
  };
  dialogVisible.value = true;
};
</script>

<template>
  <div>
    <a
        href="#"
        @click.prevent="handleDialog()"
        class="mb-4"
    >Add New</a>

    <div
          v-for="discussion in discussions"
          :key="discussion.id"
      >

        <div>
          <a
              href="#"
              @click.prevent="handleDialog(discussion)"
              class="text-primary hover:underline"
          >
            {{ discussion.title }}
          </a>
        </div>
      </div>
    <Dialog
        v-model:visible="dialogVisible"
        modal
        header="Discussion Details"
        class="w-2xl"
    >
      <Form
          :on_id="selected_discussion.on_id"
          :on_type="selected_discussion.on_type"
      />
    </Dialog>
  </div>
</template>
