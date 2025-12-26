<script setup>
defineProps ( {
  object: Object,
  type: {
    type: String,
    validator: ( value ) => [ 'created', 'updated', 'deleted' ].includes ( value ),
    required: false,
    default: 'created'
  }
} )
</script>

<template>
  <p class="text-sm">

    <template v-if="type === 'created' && object?.created_by">
      Created by: {{ object.created_by.full_name }}
      on {{ object.created_at }}
    </template>

  </p>
</template>

<style scoped>

</style>