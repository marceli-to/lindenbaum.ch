<template>
  <div :class="classes" class="mb-25 lg:mb-35">
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