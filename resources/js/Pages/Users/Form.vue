<script setup>
import { computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Button, InputText, Password, Select, Message } from 'primevue';

const props = defineProps({
  user: {
    type: Object,
    default: null,
  },
  roles: {
    type: Array,
    required: true,
  },
});

const is_edit = computed(() => !!props.user);

const form = useForm({
  first_name: props.user?.first_name || '',
  last_name: props.user?.last_name || '',
  email: props.user?.email || '',
  role: props.user?.role || '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  if (is_edit.value) {
    form.put(route('users.update', props.user.id), {
      preserveScroll: true,
    });
  } else {
    form.post(route('users.store'), {
      preserveScroll: true,
    });
  }
};

const cancel = () => {
  router.visit(route('users.index'));
};
</script>

<template>
  <AppLayout>
    <div class="px-8 py-4">
      <div class="mb-6">
        <h1 class="text-3xl font-bold text-darker-900">
          {{ is_edit ? 'Edit User' : 'Create User' }}
        </h1>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <form @submit.prevent="submit" class="space-y-6  max-w-xl">
          <!-- First Name and Last Name -->
          <div class="grid grid-cols-2 gap-4">
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
          <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col gap-2">
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

            <div class="flex flex-col gap-2">
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
          <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col gap-2">
              <label
                  for="password"
                  class="font-semibold"
              >
                Password {{ is_edit ? '(leave blank to keep current)' : '' }}
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
            </div>

            <div class="flex flex-col gap-2">
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
      </div>
    </div>
  </AppLayout>
</template>
