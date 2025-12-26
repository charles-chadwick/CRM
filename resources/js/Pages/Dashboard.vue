<!--suppress NpmUsedModulesInstalled -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <Head title="Dashboard" />
    <AppLayout>
        <div class="px-8 py-4">
            <h1 class="text-3xl font-bold text-darker-900 mb-4">Welcome to the CRM</h1>
            <p class="text-darker-600">Your Customer Relationship Management system is ready.</p>
        </div>
    </AppLayout>
</template>
