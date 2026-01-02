<!--suppress NpmUsedModulesInstalled, JSValidateTypes, JSUnresolvedReference -->
<script setup>
import { Select, Dialog, Button, InputText, InputMask, Checkbox, Textarea, Message, ConfirmDialog } from "primevue";
import { onMounted, computed, ref } from "vue";
import { useForm, usePage } from '@inertiajs/vue3';
import { useConfirm } from 'primevue/useconfirm';

const selected_contact = ref ( null );
const showDialog = ref ( false );
const dialog_mode = ref ( 'create' );
const confirm = useConfirm ();

const props = defineProps ( {
  contacts: Object,
  on_id: Number,
  on_type: String,
} );

let contacts = props.contacts;

const page = usePage();

const form = useForm ( {
  id: null,
  on_type: props.on_type,
  on_id: props.on_id,
  type: page.props.contacts.types[ 0 ]?.value ?? 'Personal',
  is_primary: false,
  address_1: null,
  address_2: null,
  city: null,
  state: null,
  postal_code: null,
  country: null,
  phone: null,
  fax: null,
  notes: null,
} );

const toggleDialog = () => {
  dialog_mode.value = 'create';
  form.reset ();
  form.type = page.props.contacts.types[ 0 ]?.value ?? 'Personal';
  form.on_type = props.on_type;
  form.on_id = props.on_id;
  showDialog.value = ! showDialog.value;
};

const openEditDialog = () => {
  if ( ! current_contact.value ) return;

  dialog_mode.value = 'edit';
  form.id = current_contact.value.id;
  form.on_type = current_contact.value.on_type;
  form.on_id = current_contact.value.on_id;
  form.type = current_contact.value.type;
  form.is_primary = current_contact.value.is_primary;
  form.address_1 = current_contact.value.address_1;
  form.address_2 = current_contact.value.address_2;
  form.city = current_contact.value.city;
  form.state = current_contact.value.state;
  form.postal_code = current_contact.value.postal_code;
  form.country = current_contact.value.country;
  form.phone = current_contact.value.phone;
  form.fax = current_contact.value.fax;
  form.notes = current_contact.value.notes;
  showDialog.value = true;
};

const deleteContact = () => {
  if ( ! current_contact.value ) return;

  confirm.require ( {
    message: 'Are you sure you want to delete this contact?',
    header: 'Confirm Deletion',
    icon: 'pi pi-exclamation-triangle',
    rejectLabel: 'Cancel',
    acceptLabel: 'Delete',
    rejectClass: 'p-button-secondary p-button-outlined',
    acceptClass: 'p-button-danger',
    accept: () => {
      form.delete ( route ( 'contacts.destroy', current_contact.value.id ), {
        onSuccess: () => {
          const contactIndex = contacts.findIndex ( contact => contact.id === current_contact.value.id );
          if ( contactIndex !== - 1 ) {
            contacts.splice ( contactIndex, 1 );
          }
          selected_contact.value = null;
        },
      } );
    }
  } );
};

const submit = () => {
  if ( dialog_mode.value === 'edit' ) {
    form.put ( route ( 'contacts.update', form.id ), {
      onSuccess: ( response ) => {
        const contactIndex = contacts.findIndex ( contact => contact.id === form.id );
        if ( contactIndex !== - 1 ) {
          contacts.splice ( contactIndex, 1, response.props.contact );
        }
        selected_contact.value = `${ form.id }`;
        showDialog.value = false;
        form.reset ();
      },
    } );
    return;
  }

  form.post ( route ( 'contacts.store' ), {
    onSuccess: ( response ) => {
      console.log(response.props);
      // contacts.push ( response.props.contact );
      // selected_contact.value = `${ response.props.contact.id }`;
      showDialog.value = false;
      form.reset ();
    },
  } );
};

const contact_options = computed ( () => {
  return contacts.map ( contact => ( {
    label: `${ contact.type }`,
    value: `${ contact.id }`
  } ) );
} );

const primary_contact = computed ( () => {
  return contacts.find ( contact => contact.is_primary ) || contacts[ 0 ] || null;
} );

const current_contact = computed ( () => {
  if ( ! selected_contact.value ) return null;
  return contacts.find ( contact => `${ contact.id }` === selected_contact.value );
} );

onMounted ( () => {
  if ( primary_contact.value ) {
    selected_contact.value = `${ primary_contact.value.id }`;

  }
} );
</script>

<template>
  <ConfirmDialog />


    <div
        class="flex flex-col gap-4"
    >
      <div class="flex flex-col gap-2">
        <div class="flex justify-between">
          <label
              for="contact-select"
              class="font-semibold"
          >Contacts</label>
          <a
              @click.prevent="toggleDialog"
              href="#"
              class="text-primary-700 hover:underline"
          >Add New</a>
        </div>
        <Select
            id="contact-select"
            v-model="selected_contact"
            :options="contact_options"
            optionLabel="label"
            optionValue="value"
            placeholder="Select a contact"
            empty-filter-message="No contacts"
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
          <div class="flex gap-2">
            <a
                @click.prevent="openEditDialog"
                href="#"
                class="text-primary-700 hover:underline"
            >Edit</a>
            <a
                @click.prevent="deleteContact"
                href="#"
                class="text-red-700 hover:underline"
            >Delete</a>
          </div>

        </div>
      </div>
    </div>

    <Dialog
        v-model:visible="showDialog"
        modal
        :header="dialog_mode === 'edit' ? 'Edit Contact' : 'Create Contact'"
        class="w-full max-w-2xl"
    >
      <form
          class="space-y-6 pt-4"
          @submit.prevent="submit"
      >
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1 text-sm">Contact Type</label>
            <Select
                id="type"
                v-model="form.type"
                optionLabel="label"
                optionValue="value"
                :options="page.props.contacts.types"
                :invalid="!!form.errors.type"
                placeholder="Select contact type"
                class="w-full"
            />
            <Message
                v-if="form.errors.type"
                severity="error"
                size="small"
            >{{ form.errors.type }}
            </Message>
          </div>

          <div class="flex items-center gap-2 mt-6 md:mt-0">
            <Checkbox
                v-model="form.is_primary"
                :binary="true"
                inputId="is_primary"
            />
            <label
                for="is_primary"
                class="font-medium text-sm"
            >Primary Contact</label>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-medium mb-1 text-sm">Address 1</label>
            <InputText
                v-model="form.address_1"
                class="w-full"
            />
            <Message
                v-if="form.errors.address_1"
                severity="error"
                size="small"
            >{{ form.errors.address_1 }}
            </Message>
          </div>

          <div>
            <label class="block font-medium mb-1 text-sm">Address 2</label>
            <InputText
                v-model="form.address_2"
                class="w-full"
            />
            <Message
                v-if="form.errors.address_2"
                severity="error"
                size="small"
            >{{ form.errors.address_2 }}
            </Message>
          </div>

          <div>
            <label class="block font-medium mb-1 text-sm">City</label>
            <InputText
                v-model="form.city"
                class="w-full"
            />
            <Message
                v-if="form.errors.city"
                severity="error"
                size="small"
            >{{ form.errors.city }}
            </Message>
          </div>

          <div>
            <label class="block font-medium mb-1 text-sm">State</label>
            <InputText
                v-model="form.state"
                class="w-full"
            />
            <Message
                v-if="form.errors.state"
                severity="error"
                size="small"
            >{{ form.errors.state }}
            </Message>
          </div>

          <div>
            <label class="block font-medium mb-1 text-sm">Postal Code</label>
            <InputText
                v-model="form.postal_code"
                class="w-full"
            />
            <Message
                v-if="form.errors.postal_code"
                severity="error"
                size="small"
            >{{ form.errors.postal_code }}
            </Message>
          </div>

          <div>
            <label class="block font-medium mb-1 text-sm">Country</label>
            <InputText
                v-model="form.country"
                class="w-full"
            />
            <Message
                v-if="form.errors.country"
                severity="error"
                size="small"
            >{{ form.errors.country }}
            </Message>
          </div>


          <div>
            <label class="block font-medium mb-1 text-sm">Phone</label>
            <InputMask
                mask="999-999-9999"
                placeholder="123-456-7890"
                v-model="form.phone"
                class="w-full"
            />
            <Message
                v-if="form.errors.phone"
                severity="error"
                size="small"
            >{{ form.errors.phone }}
            </Message>
          </div>


          <div>
            <label class="block font-medium mb-1 text-sm">Fax</label>
            <InputMask
                placeholder="123-456-7890"
                mask="999-999-9999"
                v-model="form.fax"
                class="w-full"
            />
            <Message
                v-if="form.errors.fax"
                severity="error"
                size="small"
            >{{ form.errors.fax }}
            </Message>
          </div>
        </div>

        <div>
          <label class="block font-medium mb-1 text-sm">Notes</label>
          <Textarea
              v-model="form.notes"
              rows="3"
              class="w-full"
          />
          <Message
              v-if="form.errors.notes"
              severity="error"
              size="small"
          >{{ form.errors.notes }}
          </Message>
        </div>

        <div class="flex justify-end gap-2">
          <Button
              type="button"
              label="Cancel"
              severity="secondary"
              @click="showDialog = false"
          />
          <Button
              type="submit"
              :label="dialog_mode === 'edit' ? 'Update Contact' : 'Create Contact'"
              severity="primary"
              :loading="form.processing"
          />
        </div>
      </form>
    </Dialog>


</template>
