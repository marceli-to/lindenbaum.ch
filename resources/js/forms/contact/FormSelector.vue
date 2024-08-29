<template>
  <form-group>
    <form-label id="form-selector" label="Dienstleistung" required />
    <select id="form-selector" v-model="selectedForm">
      <option value="allgemein" selected>Allgemein</option>
      <option value="wohnen">Wohnen</option>
      <option value="waescherei">Wäscherei</option>
    </select>
  </form-group>
  <component :is="currentFormComponent" v-if="currentFormComponent"></component>
</template>
<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import GeneralRequestForm from './GeneralRequestForm.vue';
import LivingRequestForm from './LivingRequestForm.vue';
import LaundryRequestForm from './LaundryRequestForm.vue';
import FormGroup from '../components/fields/group.vue';
import FormLabel from '../components/fields/label.vue';

const selectedForm = ref('allgemein');

const currentFormComponent = computed(() => {
  switch (selectedForm.value) {
    case 'wohnen':
      return LivingRequestForm;
    case 'waescherei':
      return LaundryRequestForm;
    default:
      return GeneralRequestForm;
  }
});

const updateFormFromHash = () => {
  const hash = window.location.hash.slice(1);
  if (['allgemein', 'wohnen', 'waescherei'].includes(hash)) {
    selectedForm.value = hash;
  }
};

onMounted(() => {
  updateFormFromHash();
  window.addEventListener('hashchange', updateFormFromHash);
});

watch(selectedForm, (newValue) => {
  window.location.hash = newValue;
});
</script>
