<!--suppress JSUnresolvedReference -->
<script setup>
import { computed } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Image from "../../Components/Image.vue";
import Card from "../../Components/Card.vue";
import { Button, InputText, Password, Select, Message } from 'primevue';
import Header from "../../Components/Header.vue";

const props = defineProps ( {
  user: {
    type: Object,
    default: null,
  },
  roles: {
    type: Array,
    required: true,
  },
} );

const is_edit = computed ( () => !! props.user );

const form = useForm ( {
  first_name: props.user?.first_name || '',
  last_name: props.user?.last_name || '',
  email: props.user?.email || '',
  role: props.user?.role || '',
  password: '',
  password_confirmation: '',
} );

const submit = () => {
  if ( is_edit.value ) {
    form.put ( route ( 'users.update', props.user.id ) );
  } else {
    form.post ( route ( 'users.store' ) );
  }
};

const cancel = () => {
  router.visit ( route ( 'users.index' ) );
};
</script>

<template>
  <Head title="Users" />
  <AppLayout>
    <div class="px-8 py-4">
      <Header
          :header="is_edit ? 'Edit User' : 'Create User'"
          to_route="users.index"
          label="Back to Users"
      />

      <Card class="mb-4">
        <form
            @submit.prevent="submit"
            class="space-y-6"
            roles=""
        >

          <div class="flex md:flex-row flex-col justify-start gap-4">
            <div class="md:w-2/3">
              <!-- First Name and Last Name -->
              <div class="grid md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                  <label
                      for="first_name"
                      class="font-semibold"
                  >First Name</label>
                  <InputText
                      id="first_name"
                      v-model="form.first_name"
                      :invalid="!!form.errors.first_name"
                      placeholder="Enter first name"
                  />
                  <Message
                      v-if="form.errors.first_name"
                      severity="error"
                      :closable="false"
                  >
                    {{ form.errors.first_name }}
                  </Message>
                </div>

                <div class="flex flex-col gap-2">
                  <label
                      for="last_name"
                      class="font-semibold"
                  >Last Name</label>
                  <InputText
                      id="last_name"
                      v-model="form.last_name"
                      :invalid="!!form.errors.last_name"
                      placeholder="Enter last name"
                  />
                  <Message
                      v-if="form.errors.last_name"
                      severity="error"
                      :closable="false"
                  >
                    {{ form.errors.last_name }}
                  </Message>
                </div>
              </div>

              <!-- Email and Role -->
              <div class="grid md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-2 mt-4">
                  <label
                      for="email"
                      class="font-semibold"
                  >Email</label>
                  <InputText
                      id="email"
                      v-model="form.email"
                      type="email"
                      :invalid="!!form.errors.email"
                      placeholder="Enter email address"
                  />
                  <Message
                      v-if="form.errors.email"
                      severity="error"
                      :closable="false"
                  >
                    {{ form.errors.email }}
                  </Message>
                </div>

                <div class="flex flex-col gap-2 md:mt-4">
                  <label
                      for="role"
                      class="font-semibold"
                  >Role</label>
                  <Select
                      id="role"
                      v-model="form.role"
                      :options="roles"
                      :invalid="!!form.errors.role"
                      placeholder="Select a role"
                      class="w-full"
                  />
                  <Message
                      v-if="form.errors.role"
                      severity="error"
                      :closable="false"
                  >
                    {{ form.errors.role }}
                  </Message>
                </div>
              </div>

              <!-- Password and Password Confirmation -->
              <div class="grid md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-2 mt-4">
                  <label
                      for="password"
                      class="font-semibold"
                  >
                    Password
                  </label>
                  <Password
                      id="password"
                      v-model="form.password"
                      :invalid="!!form.errors.password"
                      :feedback="!is_edit"
                      toggleMask
                      placeholder="Enter password"
                      inputClass="w-full"
                      class="w-full"
                  />
                  <Message
                      v-if="form.errors.password"
                      severity="error"
                      :closable="false"
                  >
                    {{ form.errors.password }}
                  </Message>
                  <p
                      class="text-sm"
                      v-show="is_edit"
                  > (leave blank to keep current)</p>
                </div>

                <div class="flex flex-col gap-2 mt-4">
                  <label
                      for="password_confirmation"
                      class="font-semibold"
                  >Confirm Password</label>
                  <Password
                      id="password_confirmation"
                      v-model="form.password_confirmation"
                      :invalid="!!form.errors.password_confirmation"
                      :feedback="false"
                      toggleMask
                      placeholder="Confirm password"
                      inputClass="w-full"
                      class="w-full"
                  />
                  <Message
                      v-if="form.errors.password_confirmation"
                      severity="error"
                      :closable="false"
                  >
                    {{ form.errors.password_confirmation }}
                  </Message>
                </div>
              </div>
            </div>

            <div class="md:w-1/3 pl-4">
              <label
                  for="avatar"
                  class="font-semibold"
              >Avatar</label>
              <Image
                  v-if="is_edit"
                  image_type="avatars"
                  on_type="User"
                  size="lg"
                  :on_id="props.user.id"
                  :image="props.user.avatar"
              />
              <p
                  class="text-darker-600"
                  v-else
              >You will be able to add an avatar once the user is created.</p>
            </div>

          </div>
          <!-- Form Actions -->
          <div class="flex gap-4 pt-4">
            <Button
                type="submit"
                :label="is_edit ? 'Update User' : 'Create User'"
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
