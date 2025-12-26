<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Message from 'primevue/message';

const page = usePage ();

// Layout component
const main_nav = [
  { name: 'Companies', href: route ( 'companies.index' ), icon: 'pi pi-building' },
  { name: 'Customers', href: route ( 'customers.index' ), icon: 'pi pi-warehouse' },
  { name: 'Discussions', href: '#', icon: 'pi pi-comments' }
];

const is_admin = computed ( () => page.props.auth?.user?.role === 'Admin' );
const flash = computed ( () => page.props.flash );
</script>
<template>
  <div class="flex h-screen bg-darker-50">
    <!-- Hamburger Toggle (hidden checkbox) -->
    <input
        type="checkbox"
        id="sidebar-toggle"
        class="peer hidden"
    />

    <!-- Hamburger Menu Icon -->
    <label
        for="sidebar-toggle"
        class="fixed top-4 left-4 z-50 md:hidden cursor-pointer bg-primary-600 p-3 rounded-md"
    >
      <div class="w-4 h-0.5 bg-white mb-1.5"></div>
      <div class="w-4 h-0.5 bg-white mb-1.5"></div>
      <div class="w-4 h-0.5 bg-white"></div>
    </label>

    <!-- Backdrop overlay for mobile -->
    <label
        for="sidebar-toggle"
        class="fixed inset-0 bg-darker-400/50 hidden peer-checked:block md:peer-checked:hidden"
    ></label>

    <!-- Sidebar -->
    <aside class="fixed md:relative top-0 left-0 h-full w-64 bg-primary-600 border-r border-b-primary-500 flex flex-col z-40 -translate-x-full md:translate-x-0 peer-checked:translate-x-0 transition-transform duration-300">
    <div class="p-6 border-b border-b-primary-500">
        <h1 class="text-xl font-semibold text-white pl-12 md:pl-0">
          <Link :href="route('dashboard')">CRM</Link>
        </h1>
      </div>
      <nav class="flex-1 p-4 space-y-2">
        <a
            v-for="nav_item in main_nav"
            :key="nav_item.name"
            :href="nav_item.href"
            class="px-4 py-2 text-white font-bold hover:bg-primary-500 hover:rounded-md flex items-center gap-2"
        >
          <i :class="nav_item.icon"></i>
          {{ nav_item.name }}
        </a>
        <a
            v-if="is_admin"
            :href="route('users.index')"
            class="px-4 py-2 text-white font-bold hover:bg-primary-500 hover:rounded-md flex items-center gap-2"
        >
          <i class="pi pi-user-edit"></i>
          Users
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto">
      <div
          v-if="flash?.message"
      >
        <Message
            :severity="flash.type === 'error' ? 'error' : 'success'"
            :closable="true"
            :life="3000"
            class="ml-16 mr-8 md:mx-8 mt-4"

        >
          {{ flash.message }}
        </Message>
      </div>
      <div class="px-8 py-4 mb-6">
        <slot name="header" />
        <slot />
      </div>
    </main>
  </div>
</template>

