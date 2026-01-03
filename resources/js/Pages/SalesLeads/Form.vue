<script setup>
import { computed } from 'vue';
import AppLayout from "../../Layouts/AppLayout.vue";
import { Head, router, useForm } from '@inertiajs/vue3'
import { Button, DatePicker, InputText, Message, Select } from "primevue";
import Editor from 'primevue/editor';
import Card from "../../Components/Card.vue";
import Header from "../../Components/Header.vue";

const props = defineProps ( {
  sales_lead: Object,
  companies: Array | Object,
  sales_lead_types: Array,
  sales_lead_statuses: Array }
)
const is_edit = computed ( () => !! props.sales_lead );
const form = useForm ( {
  company_id: props.sales_lead?.company_id || null,
  title: props.sales_lead?.title || '',
  status: props.sales_lead?.status || '',
  type: props.sales_lead?.type || '',
  notes: props.sales_lead?.notes || '',
  contacted_at: props.sales_lead?.contacted_at || ''
} );

const submit = () => {
  if ( is_edit.value ) {
    form.put ( route ( 'sales-leads.update', props.sales_lead.id ) );
  } else {
    form.post ( route ( 'sales-leads.store' ) );
  }
};

const cancel = () => {
  router.visit ( route ( 'sales-leads.index' ) );
};

</script>

<template>
  <AppLayout>
    <Head title="Form" />
    <Header
        :header="is_edit ? 'Edit Sales Lead' : 'Create Sales Lead'"
        to_route="sales-leads.index"
        label="Back to Sales Leads"
    />
    <Card>
      <form
          @submit.prevent="submit"
          class="space-y-6"
      >

        <div class="flex flex-row gap-4">
          <div class="w-full sm:w-2/3">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
              <div class="flex flex-col gap-2">
                <label
                    for="company_id"
                    class="font-semibold"
                >Company</label>
                <Select
                    id="company_id"
                    v-model="form.company_id"
                    :options="companies"
                    optionLabel="label"
                    optionValue="value"
                    :invalid="!!form.errors.company_id"
                    placeholder="Select a company (optional)"
                    class="w-full"
                    showClear
                />
                <Message
                    v-if="form.errors.company_id"
                    severity="error"
                    :closable="false"
                >
                  {{ form.errors.company_id }}
                </Message>
              </div>

              <div class="flex flex-col gap-2">
                <label
                    for="status"
                    class="font-semibold"
                >Status</label>
                <Select
                    optionLabel="label"
                    optionValue="value"
                    :options="sales_lead_statuses"
                    id="status"
                    v-model="form.status"
                    :invalid="!!form.errors.status"
                    placeholder="Status"
                />
                <Message
                    v-if="form.errors.status"
                    severity="error"
                    :closable="false"
                >
                  {{ form.errors.status }}
                </Message>
              </div>

              <div class="flex flex-col gap-2">
                <label
                    for="type"
                    class="font-semibold"
                >Type</label>
                <Select
                    optionLabel="label"
                    optionValue="value"
                    :options="sales_lead_types"
                    id="type"
                    v-model="form.type"
                    :invalid="!!form.errors.type"
                    placeholder="Type"
                />
                <Message
                    v-if="form.errors.type"
                    severity="error"
                    :closable="false"
                >
                  {{ form.errors.type }}
                </Message>
              </div>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
            <div class="flex flex-col gap-2">
              <label
                  for="contacted_at"
                  class="font-semibold"
              >Date Contacted</label>
              <DatePicker
                  fluid
                  id="contacted_at"
                  v-model="form.contacted_at"
                  :invalid="!!form.errors.contacted_at"
                  placeholder="Date Contacted"
              />
              <Message
                  v-if="form.errors.contacted_at"
                  severity="error"
                  :closable="false"
              >
                {{ form.errors.contacted_at }}
              </Message>
            </div>

            <!-- Title -->
            <div class="flex flex-col col-span-2 gap-2">
              <label
                  for="title"
                  class="font-semibold"
              >Title</label>
              <InputText
                  id="title"
                  v-model="form.title"
                  :invalid="!!form.errors.title"
                  placeholder="Title of Sales Lead"
              />
              <Message
                  v-if="form.errors.title"
                  severity="error"
                  :closable="false"
              >
                {{ form.errors.title }}
              </Message>
            </div>
            </div>

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

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
              <Button
                  type="submit"
                  :label="is_edit ? 'Update Sales Lead' : 'Create Sales Lead'"
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
          </div>

        </div>
      </form>
    </Card>
  </AppLayout>
</template>
