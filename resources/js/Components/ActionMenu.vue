<script setup>
import { ref } from 'vue';
import { Menu, Button } from 'primevue';
import { router } from '@inertiajs/vue3';
import { useConfirm } from 'primevue/useconfirm';

const props = defineProps({
  items: {
    type: Array,
    default: () => []
  },
  // Convenience props for standard actions
  editRoute: String,
  deleteRoute: String,
  activityParams: Object, // e.g. { on: 'Company', id: 1 }
  modelName: {
    type: String,
    default: 'item'
  }
});

const menu = ref();
const confirm = useConfirm();

const toggle = (event) => {
  menu.value.toggle(event);
};

const menuItems = ref([...props.items]);

// Add Edit action if editRoute is provided
if (props.editRoute) {
  menuItems.value.push({
    label: 'Edit',
    icon: 'pi pi-pencil',
    command: () => router.visit(props.editRoute)
  });
}

// Add Activity action if activityParams is provided
if (props.activityParams) {
  menuItems.value.push({
    label: 'See Activity',
    icon: 'pi pi-history',
    command: () => router.visit(route('activity.database', props.activityParams))
  });
}

// Add Delete action if deleteRoute is provided
if (props.deleteRoute) {
  menuItems.value.push({
    label: 'Delete',
    icon: 'pi pi-trash',
    command: () => {
      confirm.require({
        message: `Are you sure you want to delete this ${props.modelName}?`,
        header: 'Delete Confirmation',
        icon: 'pi pi-exclamation-triangle',
        rejectLabel: 'Cancel',
        acceptLabel: 'Delete',
        rejectProps: { severity: 'secondary' },
        acceptProps: { severity: 'danger' },
        accept: () => router.delete(props.deleteRoute)
      });
    }
  });
}
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
        :model="menuItems"
        :popup="true"
    >
      <template #item="{ item, props }">
        <a class="flex items-center" v-bind="props.action">
          <span :class="item.icon" />
          <span class="ml-2">{{ item.label }}</span>
          <span v-if="item.shortcut" class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1">{{ item.shortcut }}</span>
        </a>
      </template>
    </Menu>
  </div>
</template>
