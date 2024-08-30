<template>
  <form @submit.prevent="submitForm">
    <form-group>
      <form-label id="shares" label="Anzahl der Anteile" required />
      <form-text-field 
        type="number"
        v-model="form.shares" 
        :error="errors.shares"
        @update:error="errors.shares = $event"
        min="1"
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
      <form-label id="firstname" label="Vorname" required />
      <form-text-field 
        v-model="form.firstname" 
        :error="errors.firstname"
        @update:error="errors.firstname = $event"
      />
    </form-group>
    <form-group>
      <form-label id="date_of_birth" label="Geburtsdatum" required />
      <form-text-field 
        type="date"
        v-model="form.date_of_birth" 
        :error="errors.date_of_birth"
        @update:error="errors.date_of_birth = $event"
      />
    </form-group>
    <form-group>
      <form-label id="street" label="Straße" required />
      <form-text-field 
        v-model="form.street" 
        :error="errors.street"
        @update:error="errors.street = $event"
      />
    </form-group>
    <form-group>
      <form-label id="location" label="Ort" required />
      <form-text-field 
        v-model="form.location" 
        :error="errors.location"
        @update:error="errors.location = $event"
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
    <form-group>
      <form-label id="phone" label="Telefon" required />
      <form-text-field 
        type="tel"
        v-model="form.phone" 
        :error="errors.phone"
        @update:error="errors.phone = $event"
      />
    </form-group>
    <form-group>
      <form-label id="message" label="Ihre Nachricht" classes="!mb-10" required />
      <form-text-area 
        v-model="form.message" 
        :error="errors.message"
        @update:error="errors.message = $event"
      />
    </form-group>
    <form-group>
      <form-toc 
        id="toc" 
        label="Datenschutzerklärung" 
        v-model="form.toc"
        :error="errors.toc" 
        @update:error="errors.toc = $event"
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
import { ref } from 'vue';
import axios from 'axios';
import FormGroup from '../components/fields/group.vue';
import FormTextField from '../components/fields/text.vue';
import FormLabel from '../components/fields/label.vue';
import FormTextArea from '../components/fields/textarea.vue';
import FormButton from '../components/fields/button.vue';
import FormToc from '../components/fields/toc.vue';

const emit = defineEmits(['form-success', 'form-error', 'form-reset']);

const props = defineProps({
  service: {
    type: String,
    required: true
  }
});

const form = ref({
  shares: 1,
  name: '',
  firstname: '',
  street: '',
  location: '',
  email: '',
  phone: '',
  date_of_birth: '',
  message: '',
  toc: false,
});

const errors = ref({
  shares: '',
  name: '',
  firstname: '',
  street: '',
  location: '',
  email: '',
  phone: '',
  date_of_birth: '',
  message: '',
  toc: '',
});

const isSubmitting = ref(false);

async function submitForm() {
  isSubmitting.value = true;
  emit('form-reset');
  try {
    const response = await axios.post('/api/contact-request/cooperative', {
      ...form.value,
      service: props.service
    });
    handleSuccess();
    return true;
  } catch (error) {
    handleError(error);
    return false;
  }
}

function handleSuccess() {
  form.value = {
    shares: 1,
    name: '',
    firstname: '',
    street: '',
    location: '',
    email: '',
    phone: '',
    date_of_birth: '',
    message: '',
    toc: false,
  };
  errors.value = {
    shares: '',
    name: '',
    firstname: '',
    street: '',
    location: '',
    email: '',
    phone: '',
    date_of_birth: '',
    message: '',
    toc: '',
  };
  isSubmitting.value = false;

  emit('form-success');
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

    emit('form-error');
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
}
</script>