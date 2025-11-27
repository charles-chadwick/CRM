<!--suppress JSUnresolvedReference -->
<script setup>
import { ref, onMounted } from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {
  Bars3Icon,
  CalendarIcon,
  ChartPieIcon,
  DocumentDuplicateIcon,
  FolderIcon,
  HomeIcon,
  BookOpenIcon,
  XMarkIcon,
} from '@heroicons/vue/24/outline'
import { usePage } from "@inertiajs/vue3";
import Message from 'primevue/message';

const navigation = [
  { name: 'Dashboard', href: route ( 'dashboard' ), icon: HomeIcon, current: true },
  { name: 'Companies', href: route ( 'companies.index' ), icon: BookOpenIcon, current: false },
  { name: 'Customers', href: '#', icon: FolderIcon, current: false },
  { name: 'Calendar', href: '#', icon: CalendarIcon, current: false },
  { name: 'Documents', href: '#', icon: DocumentDuplicateIcon, current: false },
  { name: 'Reports', href: '#', icon: ChartPieIcon, current: false },
]
const teams = [
  { id: 1, name: 'Heroicons', href: '#', initial: 'H', current: false },
  { id: 2, name: 'Tailwind Labs', href: '#', initial: 'T', current: false },
  { id: 3, name: 'Workcation', href: '#', initial: 'W', current: false },
]

const sidebarOpen = ref ( false )
const user = usePage ().props.auth.user.data;
const show_flash_message = ref ( false );
const flash_message = ref ( '' );
const flash_type = ref ( '' );

const page = usePage ();

onMounted ( () => {
  if ( page.props.flash.message ) {
    show_flash_message.value = true;
    flash_message.value = page.props.flash.message;
    flash_type.value = page.props.flash.type;
  }
} );
</script>
<template>
  <div>
    <TransitionRoot
        as="template"
        :show="sidebarOpen"
    >
      <Dialog
          class="relative z-50 lg:hidden"
          @close="sidebarOpen = false"
      >
        <TransitionChild
            as="template"
            enter="transition-opacity ease-linear duration-300"
            enter-from="opacity-0"
            enter-to=""
            leave="transition-opacity ease-linear duration-300"
            leave-from=""
            leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-darker-900/80"></div>
        </TransitionChild>

        <div class="fixed inset-0 flex">
          <TransitionChild
              as="template"
              enter="transition ease-in-out duration-300 transform"
              enter-from="-translate-x-full"
              enter-to="translate-x-0"
              leave="transition ease-in-out duration-300 transform"
              leave-from="translate-x-0"
              leave-to="-translate-x-full"
          >
            <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
              <TransitionChild
                  as="template"
                  enter="ease-in-out duration-300"
                  enter-from="opacity-0"
                  enter-to=""
                  leave="ease-in-out duration-300"
                  leave-from=""
                  leave-to="opacity-0"
              >
                <div class="absolute top-0 left-full flex w-16 justify-center pt-5">
                  <button
                      type="button"
                      class="-m-2.5 p-2.5"
                      @click="sidebarOpen = false"
                  >
                    <span class="sr-only">Close sidebar</span>
                    <XMarkIcon
                        class="size-6 text-white"
                        aria-hidden="true"
                    />
                  </button>
                </div>
              </TransitionChild>

              <!-- Sidebar component, swap this element with another sidebar if you like -->
              <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-primary-800 px-6 pb-2 ring-1 ring-white/10">
                <div class="flex h-16 shrink-0 justify-center items-center">
                  <h1 class="font-bold text-primary-300 text-2xl text-center truncate">
                    {{ page.props.header }}
                  </h1>
                </div>
                <nav class="flex flex-1 flex-col">
                  <ul
                      role="list"
                      class="flex flex-1 flex-col gap-y-7"
                  >
                    <li>
                      <ul
                          role="list"
                          class="-mx-2 space-y-1"
                      >
                        <li
                            v-for="item in navigation"
                            :key="item.name"
                        >
                          <a
                              :href="item.href"
                              :class="[item.current ? 'bg-primary-950/25 text-white' : 'text-primary-100 hover:bg-primary-950/25 hover:text-white', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']"
                          >
                            <component
                                :is="item.icon"
                                :class="[item.current ? 'text-white' : 'text-primary-100 group-hover:text-white', 'size-6 shrink-0']"
                                aria-hidden="true"
                            />
                            {{ item.name }}
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li>
                      <div class="text-xs/6 font-semibold text-primary-100">Your teams</div>
                      <ul
                          role="list"
                          class="-mx-2 mt-2 space-y-1"
                      >
                        <li
                            v-for="team in teams"
                            :key="team.name"
                        >
                          <a
                              :href="team.href"
                              :class="[team.current ? 'bg-primary-950/25 text-white' : 'text-primary-100 hover:bg-primary-950/25 hover:text-white', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']"
                          >
                            <span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-primary-500/50 bg-primary-700 text-[0.625rem] font-medium text-white">{{
                                team.initial
                                                                                                                                                                                         }}</span>
                            <span class="truncate">{{ team.name }}</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </nav>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
      <div class="relative flex grow flex-col gap-y-5 overflow-y-auto bg-primary-800 px-6 after:pointer-events-none after:absolute after:inset-y-0 after:right-0 after:w-px after:bg-white/10">
        <div class="flex h-16 shrink-0 justify-center items-center">
          <h1 class="font-bold text-primary-300 text-2xl text-center truncate">
            {{ page.props.header }}
          </h1>
        </div>
        <nav class="flex flex-1 flex-col">
          <ul
              role="list"
              class="flex flex-1 flex-col gap-y-7"
          >
            <li>
              <ul
                  role="list"
                  class="-mx-2 space-y-1"
              >
                <li
                    v-for="item in navigation"
                    :key="item.name"
                >
                  <a
                      :href="item.href"
                      :class="[item.current ? 'bg-primary-950/25 text-white' : 'text-primary-100 hover:bg-primary-950/25 hover:text-white', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']"
                  >
                    <component
                        :is="item.icon"
                        :class="[item.current ? 'text-white' : 'text-primary-100 group-hover:text-white', 'size-6 shrink-0']"
                        aria-hidden="true"
                    />
                    {{ item.name }}
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <div class="text-xs/6 font-semibold text-primary-100">Your teams</div>
              <ul
                  role="list"
                  class="-mx-2 mt-2 space-y-1"
              >
                <li
                    v-for="team in teams"
                    :key="team.name"
                >
                  <a
                      :href="team.href"
                      :class="[team.current ? 'bg-primary-950/25 text-white' : 'text-primary-100 hover:bg-primary-950/25 hover:text-white', 'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold']"
                  >
                    <span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-primary-500/50 bg-primary-700 text-[0.625rem] font-medium text-white">{{
                        team.initial
                                                                                                                                                                                 }}</span>
                    <span class="truncate">{{ team.name }}</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="-mx-6 mt-auto">
              <a
                  href="#"
                  class="flex items-center gap-x-4 px-6 py-3 text-sm/6 font-semibold text-white hover:bg-primary-950/25"
              >
                <img
                    class="size-8 rounded-full bg-primary-800 outline -outline-offset-1 outline-white/10"
                    :src="user.attributes.avatar_url"
                    alt=""
                />
                <span class="sr-only">Your profile</span>
                <span aria-hidden="true">{{ user.attributes.full_name }}</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-primary-800 px-4 py-4 shadow-xs after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10 sm:px-6 lg:hidden">
      <button
          type="button"
          class="-m-2.5 p-2.5 text-primary-200 hover:text-white lg:hidden"
          @click="sidebarOpen = true"
      >
        <span class="sr-only">Open sidebar</span>
        <Bars3Icon
            class="size-6"
            aria-hidden="true"
        />
      </button>
      <div class="flex-1 text-sm/6 font-semibold text-white">Dashboard</div>
      <a href="#">
        <span class="sr-only">Your profile</span>
        <img
            class="size-8 rounded-full bg-primary-800 outline -outline-offset-1 outline-white/10"
            :src="user.attributes.avatar_url"
            alt=""
        />
      </a>
    </div>

    <main class="py-4 lg:pl-72">

      <Message
          v-if="show_flash_message"
          :severity="flash_type"
          :life="3000"
      >{{ flash_message }}
      </Message>

      <div class="px-4 sm:px-6 lg:px-8">
        <h1 class="font-bold text-2xl text-darker-800">
          <slot name="header" />
        </h1>
        <slot />
      </div>
    </main>
  </div>
</template>
