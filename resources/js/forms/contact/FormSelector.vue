<template>
  <div>
    <template v-if="formSuccess">
      <success-alert>
        Vielen Dank für Ihre Anfrage!
      </success-alert>
    </template>
    <template v-if="formError">
      <error-alert>
        Bitte überprüfen Sie die eingegebenen Daten.
      </error-alert>
    </template>
    <form-group>
      <form-label id="form-selector" label="Dienstleistung" required />
      <select id="form-selector" v-model="service">
        <option value="Allgemein" selected>Allgemein</option>
        <option value="Wohnen">Wohnen</option>
        <option value="Wäscherei">Wäscherei</option>
        <option value="Raumvermietung">Raumvermietung und Catering</option>
        <option value="Chinderhuus">Chinderhuus Anmeldung</option>
        <option value="Genossenschaft">Genossenschaft</option>
      </select>
    </form-group>
    <component 
      :is="currentFormComponent" 
      v-if="currentFormComponent" 
      :key="service"
      :service="service"
      @form-success="formSuccess = true"
      @form-error="formError = true"
      @form-reset="formSuccess = false; formError = false"
    >
    </component>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import GeneralRequestForm from './GeneralRequestForm.vue';
import FormGroup from '../components/fields/group.vue';
import FormLabel from '../components/fields/label.vue';
import SuccessAlert from '../components/alerts/success.vue';
import ErrorAlert from '../components/alerts/error.vue';
import RoomRequestForm from './RoomRequestForm.vue';
import NurseryRequestForm from './NurseryRequestForm.vue';
import CooperativeRequestForm from './CooperativeRequestForm.vue';

const service = ref('Allgemein');

const currentFormComponent = computed(() => {
  switch (service.value) {
    case 'Wohnen':
      return GeneralRequestForm;
    case 'Wäscherei':
      return GeneralRequestForm;
    case 'Raumvermietung':
      return RoomRequestForm;
    case 'Chinderhuus':
      return NurseryRequestForm;
    case 'Genossenschaft':
      return CooperativeRequestForm;
    default:
      return GeneralRequestForm;
  }
});

const formSuccess = ref(false);
const formError = ref(false);

const updateFormFromHash = () => {
  const hash = window.location.hash.slice(1);
  if (['Allgemein', 'Wohnen', 'Wäscherei', 'Raumvermietung', 'Chinderhuus', 'Cooperative'].includes(hash)) {
    service.value = hash;
  }
};

onMounted(() => {
  updateFormFromHash();
  window.addEventListener('hashchange', updateFormFromHash);
});

watch(service, (newValue) => {
  window.location.hash = newValue;
  formSuccess.value = false;
  formError.value = false;
});
</script>
