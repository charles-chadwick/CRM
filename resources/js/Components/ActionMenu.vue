<script setup>
import { ref } from 'vue';
import { Menu, Button } from 'primevue';

defineProps({
  items: {
    type: Array,
    required: true
  }
});

const menu = ref();

const toggle = (event) => {
  menu.value.toggle(event);
};
</script>

<template>
  <div>
    <Button
        icon="pi pi-ellipsis-v"
        severity="secondary"
        @click="toggle"
        aria-haspopup="true"
        aria-controls="overlay_menu"
    />
    <Menu
        ref="menu"
        id="overlay_menu"
        :model="items"
        :popup="true"
    >
      <template #item="{ item, props }">
        <a class="flex items-center" v-bind="props.action">
          <span :class="item.icon" />
          <span>{{ item.label }}</span>
          <span v-if="item.shortcut" class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1">{{ item.shortcut }}</span>
        </a>
      </template>
    </Menu>
  </div>
</template>
