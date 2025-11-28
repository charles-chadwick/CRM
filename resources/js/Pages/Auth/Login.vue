<script setup>
import { useForm } from '@inertiajs/vue3';
import { Card, InputText, Password, Button, Checkbox, Message } from 'primevue';

const LOGIN_ROUTE_NAME = 'login';

const form = useForm ( {
  email: '',
  password: ''
} );

const handleLoginFinish = () => {
  form.reset ( 'password' );
};

const handleLoginSubmit = () => {
  form.post ( route ( LOGIN_ROUTE_NAME ), {
    onFinish: handleLoginFinish,
  } );
};
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-darker-100">
    <Card class="w-full max-w-md">
      <template #title>
        <h2 class="text-2xl font-bold text-center">CRM Platform Login</h2>
      </template>

      <template #content>
        <form @submit.prevent="handleLoginSubmit" class="space-y-4">
          <div>
            <label for="email" class="block text-sm font-medium mb-2">
              Email
            </label>
            <InputText
                id="email"
                v-model="form.email"
                type="email"
                fluid
                :invalid="!!form.errors.email"
                required
            />
            <Message v-if="form.errors.email" severity="error" class="mt-2">
              {{ form.errors.email }}
            </Message>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium mb-2">
              Password
            </label>
            <Password
                id="password"
                v-model="form.password"
                fluid
                :invalid="!!form.errors.password"
                :feedback="false"
                toggleMask
                required
            />
            <Message v-if="form.errors.password" severity="error" class="mt-2">
              {{ form.errors.password }}
            </Message>
          </div>

          <Button
              type="submit"
              label="Log in"
              :loading="form.processing"
              fluid
              severity="primary"
          />
        </form>
      </template>
    </Card>
  </div>
</template>