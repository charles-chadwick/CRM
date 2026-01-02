<!--suppress JSUnresolvedReference -->
<script setup>
import { computed } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from "@/Components/Card.vue";
import { Button, InputText, Message } from 'primevue';
import Header from "@/Components/Header.vue";

const props = defineProps({
  company_type: {
    type: Object,
    default: null,
  }
});

const is_edit = computed(() => !!props.company_type);

const form = useForm({
  name: props.company_type?.name || '',
});

const submit = () => {
  if (is_edit.value) {
    form.put(route('company-types.update', props.company_type.id));
  } else {
    form.post(route('company-types.store'));
  }
};

const cancel = () => {
  router.visit(route('company-types.index'));
};
</script>

<template>
  <Head title="Company Types" />
  <AppLayout>
    <div class="px-8 md:py-4">
      <Header
          :header="is_edit ? 'Edit Company Type' : 'Create Company Type'"
          to_route="company-types.index"
          label="Back to Company Types"
      />

      <Card>
        <form
            @submit.prevent="submit"
            class="space-y-3"
        >
          <!-- Name -->
          <div class="flex flex-col gap-2">
            <label
                for="name"
                class="font-semibold"
            >Name</label>
            <InputText
                id="name"
                v-model="form.name"
                :invalid="!!form.errors.name"
                placeholder="Enter company type name"
            />
            <Message
                v-if="form.errors.name"
                severity="error"
                :closable="false"
            >
              {{ form.errors.name }}
            </Message>
          </div>

          <!-- Form Actions -->
          <div class="flex gap-4 pt-4">
            <Button
                type="submit"
                :label="is_edit ? 'Update Company Type' : 'Create Company Type'"
                :loading="form.processing"
                icon="pi pi-check"
                severity="primary"
            />
            <Button
                type="button"
                label="Cancel"
                severity="secondary"
                outlined
                icon="pi pi-times"
                @click="cancel"
                :disabled="form.processing"
            />
          </div>
        </form>
      </Card>
    </div>
  </AppLayout>
</template>
