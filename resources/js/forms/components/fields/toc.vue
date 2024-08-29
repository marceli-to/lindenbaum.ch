<template>
  <div class="relative">
    <div :class="['flex checkboxes', { 'has-error': error }]">
      <div class="flex items-start mr-15">
        <input id="toc" name="toc" type="checkbox" :checked="modelValue" @change="updateValue">
      </div>
      <label for="toc">
        Ich habe die&nbsp;<a href="/datenschutz">Datenschutzerklärung</a>&nbsp;gelesen und akzeptiere diese.
      </label>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({
  id: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  error: {
    type: String,
    default: null
  },
  required: {
    type: Boolean,
    default: false
  },
  modelValue: {
    type: Boolean,
    default: false
  },
})

const emit = defineEmits(['update:modelValue', 'update:error']);

const updateValue = (event) => {
  emit('update:modelValue', event.target.checked);
}
</script>