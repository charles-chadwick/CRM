<!--suppress JSUnresolvedReference -->
<script setup>
import { computed } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Image from "../../Components/Image.vue";
import Card from "../../Components/Card.vue";
import Editor from 'primevue/editor';
import { Button, InputText, Select, Message } from 'primevue';
import Header from "../../Components/Header.vue";

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
  company_type_id: props.company?.company_type_id || '',
  name: props.company?.name || '',
  notes: props.company?.notes || '',
  logo: null,
} );
const submit = () => {
  if ( is_edit.value ) {
    form.put ( route ( 'companies.update', props.company.id ) );
  } else {
    form.post ( route ( 'companies.store' ) );
  }
};

const cancel = () => {
  router.visit ( route ( 'companies.index' ) );
};
</script>

<template>
  <Head title="Companies" />
  <AppLayout>
    <div class="px-8 md:py-4">
      <Header
          :header="is_edit ? 'Edit Company' : 'Create Company'"
          to_route="companies.index"
          label="Back to Companies"
      />

      <Card>
        <form
            @submit.prevent="submit"
            class="space-y-3"
        >
          <!-- Type, Name and Logo -->
          <div class="flex md:flex-row flex-col justify-between gap-4">

            <div class="md:w-2/3 gap-4">

              <div class="grid md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                  <label
                      for="company_type_id"
                      class="font-semibold"
                  >Type</label>
                  <Select
                      id="company_type_id"
                      v-model="form.company_type_id"
                      optionLabel="label"
                      optionValue="value"
                      :options="props.company_types"
                      :invalid="!!form.errors.company_type_id"
                      placeholder="Select company type"
                      class="w-full"
                  />
                  <Message
                      v-if="form.errors.company_type_id"
                      severity="error"
                      :closable="false"
                  >
                    {{ form.errors.company_type_id }}
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
              <div class="flex flex-col gap-2 mt-4">
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

            <div class="md:w-1/3 gap-2">
              <div
                  class="font-semibold mb-2"
              >Logo</div>
              <Image
                  v-if="is_edit"
                  image_type="logo"
                  on_type="Company"
                  size="lg"
                  :on_id="props.company.id"
                  :image="props.company.logo"
              />
              <p
                  class="text-darker-600"
                  v-else
              >You will be able to add a logo once the user is created.</p>

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
      </Card>
    </div>
  </AppLayout>
</template>

