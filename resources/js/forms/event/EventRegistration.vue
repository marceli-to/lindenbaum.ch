<template>
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
  <form @submit.prevent="submitForm" v-if="isLoaded">
    <form-group>
      <form-label id="firstname" label="Vorname" required />
      <form-text-field 
        v-model="form.firstname" 
        :error="errors.firstname"
        @update:error="errors.firstname = $event"
      />
    </form-group>
    <form-group>
      <form-label id="name" label="Name" required />
      <form-text-field 
        v-model="form.name" 
        :error="errors.name"
        @update:error="errors.name = $event"
      />
    </form-group>
    <form-group>
      <form-label id="email" label="E-Mail" required />
      <form-text-field 
        type="email"
        v-model="form.email" 
        :error="errors.email"
        @update:error="errors.email = $event"
      />
    </form-group>
    <form-group classes="mt-30">
      <form-button 
        type="submit" 
        label="Anfrage senden" 
        :disabled="isSubmitting"
      />
    </form-group>
  </form>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import FormGroup from '../components/fields/group.vue';
import FormTextField from '../components/fields/text.vue';
import FormLabel from '../components/fields/label.vue';
import FormButton from '../components/fields/button.vue';
import SuccessAlert from '../components/alerts/success.vue';
import ErrorAlert from '../components/alerts/error.vue';

const props = defineProps({
  eventId: {
    type: String,
    required: true,
  },
});

const isLoaded = ref(false);
const isSubmitting = ref(false);
const formSuccess = ref(false);
const formError = ref(false);

const form = ref({
  event_id: props.eventId,
  name: '',
  firstname: '',
  email: '',
});

const errors = ref({
  name: '',
  firstname: '',
  email: '',
});

onMounted(async () => {
  try {
    const response = await axios.get(`/api/event/${props.eventId}`);
    isLoaded.value = true;
  } catch (error) {
    console.error(error);
  }
});

async function submitForm() {
  isSubmitting.value = true;
  formSuccess.value = false;
  formError.value = false;
  try {
    const response = await axios.post('/api/event/register', {
      ...form.value,
    });
    handleSuccess();
  } catch (error) {
    handleError(error);
  }
}

function handleSuccess() {
  form.value = {
    event_id: props.eventId,
    name: '',
    firstname: '',
    email: '',
  };
  errors.value = {
    name: '',
    firstname: '',
    email: '',
  };
  isSubmitting.value = false;
  formSuccess.value = true;
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}

function handleError(error) {
  if (error.response && error.response.data && typeof error.response.data.errors === 'object') {
    Object.keys(error.response.data.errors).forEach(key => {
      errors.value[key] = error.response.data.errors[key][0];
    });
    isSubmitting.value = false;
    formError.value = true;
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
}
</script>