<!--suppress JSUnresolvedReference -->
<script setup>
import { computed } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Image from "../../Components/Image.vue";
import Editor from 'primevue/editor'
import { Button, InputText, Select, Message } from 'primevue';

const props = defineProps ( {
  company: {
    type: Object,
    default: null,
  },
  company_types: {
    type: Array,
    default: []
  }
} );

const is_edit = computed ( () => !! props.company );

const form = useForm ( {
  type: props.company?.type || '',
  name: props.company?.name || '',
  notes: props.company?.notes || '',
  logo: null,
} );

const onLogoSelect = ( event ) => {
  form.logo = event.files[ 0 ];
};

const submit = () => {
  if ( is_edit.value ) {
    form.put ( route ( 'companies.update', props.company/id ), {
      preserveScroll: true,
    } );
  } else {
    form.post ( route ( 'companies.store' ), {
      preserveScroll: true,
    } );
  }
};

const cancel = () => {
  router.visit ( route ( 'companies.index' ) );
};
</script>

<template>
  <Head title="Companies" />
  <AppLayout>
    <div class="px-8 py-4">
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-darker-900">
          {{ is_edit ? 'Edit Company' : 'Create Company' }}
        </h1>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <form
            @submit.prevent="submit"
            class="space-y-3"
        >
          <!-- Type, Name and Logo -->
          <div class="flex flex-row justify-between gap-4">

            <div class="w-2/3 gap-4">

              <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                  <label
                      for="type"
                      class="font-semibold"
                  >Type</label>
                  <Select
                      id="type"
                      v-model="form.type"
                      optionLabel="label"
                      optionValue="value"
                      :options="props.company_types"
                      :invalid="!!form.errors.type"
                      placeholder="Select company type"
                      class="w-full"
                  />
                  <Message
                      v-if="form.errors.type"
                      severity="error"
                      :closable="false"
                  >
                    {{ form.errors.type }}
                  </Message>
                </div>
                <div class="flex flex-col gap-2">
                  <label
                      for="name"
                      class="font-semibold"
                  >Name</label>
                  <InputText
                      id="name"
                      v-model="form.name"
                      :invalid="!!form.errors.name"
                      placeholder="Enter company name"
                  />
                  <Message
                      v-if="form.errors.name"
                      severity="error"
                      :closable="false"
                  >
                    {{ form.errors.name }}
                  </Message>
                </div>
              </div>

              <!-- Notes -->
              <div class="flex flex-col gap-2">
                <label
                    for="notes"
                    class="font-semibold"
                >Notes</label>
                <Editor
                    id="notes"
                    v-model="form.notes"
                    :invalid="!!form.errors.notes"
                    placeholder="Enter notes (optional)"
                    editorStyle="height: 200px"
                    class="w-full"
                />
                <Message
                    v-if="form.errors.notes"
                    severity="error"
                    :closable="false"
                >
                  {{ form.errors.notes }}
                </Message>
              </div>

            </div>

            <div class="max-w-1/3 gap-2">
              <label
                  for="notes"
                  class="font-semibold"
              >Logo</label>
              <Image
                  v-if="is_edit"
                  image_type="logo"
                  on_type="Company"
                  size="lg"
                  :on_id="props.company/id"
                  :image="props.company/logo"
              />
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex gap-4 pt-4">
            <Button
                type="submit"
                :label="is_edit ? 'Update Company' : 'Create Company'"
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
      </div>
    </div>
  </AppLayout>
</template>

