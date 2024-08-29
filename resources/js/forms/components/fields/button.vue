<template>
  <button :type="type" :class="classes">{{ label }}</button>
</template>
<script setup>
const props = defineProps({
  type: {
    type: String,
    default: 'submit'
  },
  label: {
    type: String,
    required: true
  },
  classes: {
    type: String,
    default: 'btn-outline border border-steel inline-flex items-center justify-center font-bold text-steel uppercase text-xs !leading-none tracking-wide px-20 lg:px-30 py-2 pt-4 min-h-28 transition-colors'
  }
});
</script>