<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { InputText, Button, Checkbox, Message } from 'primevue';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => {
      form.reset('password');
    },
  });
};
</script>

<template>
  <Head title="Login" />

  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-500 to-primary-700">
    <div class="w-full max-w-md">
      <div class="bg-white rounded-2xl shadow-2xl p-8">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
          <h1 class="text-4xl font-bold text-primary-600 mb-2">CRM</h1>
          <p class="text-darker-600 text-sm">Sign in to your account</p>
        </div>

        <!-- Error Message -->
        <Message
            v-if="form.errors.email"
            severity="error"
            :closable="false"
            class="mb-4"
        >
          {{ form.errors.email }}
        </Message>

        <!-- Login Form -->
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Email Field -->
          <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-darker-700">
              Email Address
            </label>
            <InputText
                id="email"
                v-model="form.email"
                type="email"
                placeholder="Enter your email"
                class="w-full"
                :class="{ 'p-invalid': form.errors.email }"
                autofocus
                required
            />
            <small v-if="form.errors.email" class="text-red-500">
              {{ form.errors.email }}
            </small>
          </div>

          <!-- Password Field -->
          <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-darker-700">
              Password
            </label>
            <InputText
                id="password"
                v-model="form.password"
                type="password"
                placeholder="Enter your password"
                class="w-full"
                :class="{ 'p-invalid': form.errors.password }"
                required
            />
            <small v-if="form.errors.password" class="text-red-500">
              {{ form.errors.password }}
            </small>
          </div>

          <!-- Remember Me -->
          <div class="flex items-center">
            <Checkbox
                v-model="form.remember"
                inputId="remember"
                :binary="true"
                class="mr-2"
            />
            <label for="remember" class="text-sm text-darker-600 cursor-pointer">
              Remember me
            </label>
          </div>

          <!-- Submit Button -->
          <Button
              type="submit"
              label="Sign In"
              severity="primary"
              class="w-full justify-center"
              :loading="form.processing"
              :disabled="form.processing"
          />
        </form>

        <!-- Footer -->
        <div class="mt-6 text-center">
          <p class="text-xs text-darker-500">
            © {{ new Date ().getFullYear () }} CRM. All rights reserved.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Additional custom styling if needed */
</style>
