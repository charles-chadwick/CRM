<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

// Layout component
const main_nav = [
  { name: 'Companies', href: '#', icon: 'pi pi-building' },
  { name: 'Customers', href: '#', icon: 'pi pi-users' },
  { name: 'Contacts', href: '#', icon: 'pi pi-user' },
  { name: 'Discussions', href: '#', icon: 'pi pi-comments' }
];

const is_admin = computed(() => page.props.auth?.user?.role === 'Admin');
</script>
<template>
  <div class="flex h-screen bg-darker-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-primary-600 border-r border-b-primary-500 flex flex-col">
      <div class="p-6 border-b border-b-primary-500">
        <h1 class="text-xl font-semibold text-white">CRM</h1>
      </div>
      <nav class="flex-1 p-4 space-y-2">
        <a
            v-for="nav_item in main_nav"
            :key="nav_item.name"
            :href="nav_item.href"
            class="block px-4 py-2 text-white font-bold hover:bg-primary-500 hover:rounded-md flex items-center gap-2"
        >
          <i :class="nav_item.icon"></i>
          {{ nav_item.name }}
        </a>
        <a
            v-if="is_admin"
            :href="route('users.index')"
            class="block px-4 py-2 text-white font-bold hover:bg-primary-500 hover:rounded-md flex items-center gap-2"
        >
          <i class="pi pi-user-edit"></i>
          Users
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto">
      <slot />
    </main>
  </div>
</template>

