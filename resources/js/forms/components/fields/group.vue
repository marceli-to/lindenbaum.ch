<template>
  <div :class="classes" class="mb-25">
    <slot></slot>
  </div>
</template>

<script setup>
const props = defineProps({
  classes: {
    type: String,
    default: ''
  }
});
</script>