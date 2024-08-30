<template>
  <form @submit.prevent="submitForm">
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
        :min="minDate"
        v-model="form.phone" 
        :error="errors.phone"
        @update:error="errors.phone = $event"
      />
    </form-group>
    <form-group>
      <form-label id="room" label="Raum" required />
      <form-select 
        v-model="form.room" 
        :error="errors.room"
        @update:error="errors.room = $event"
        :options="rooms"
      />
    </form-group>
    <form-group>
      <form-label id="date" label="Datum" required />
      <form-text-field 
        type="date"
        :min="minDate"
        v-model="form.date_start" 
        :error="errors.date_start"
        @update:error="errors.date = $event"
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
import FormSelect from '../components/fields/select.vue';

const emit = defineEmits(['form-success', 'form-error', 'form-reset']);

const props = defineProps({
  service: {
    type: String,
    required: true
  }
});

const form = ref({
  name: '',
  firstname: '',
  email: '',
  phone: '',
  message: '',
  room: 'room1',
  date: '',
  toc: false,
});

const errors = ref({
  name: '',
  firstname: '',
  email: '',
  phone: '',
  room: '',
  date: '',
  message: '',
  toc: '',
});

const rooms = ref([
  { value: 'room1', label: 'Raum 1' },
  { value: 'room2', label: 'Raum 2' },
  { value: 'room3', label: 'Raum 3' },
]);

const minDate = ref(new Date().toISOString().split('T')[0]);

const isSubmitting = ref(false);

async function submitForm() {
  isSubmitting.value = true;
  emit('form-reset');
  try {
    const response = await axios.post('/api/contact-request/room', {
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
    name: '',
    firstname: '',
    email: '',
    phone: '',
    message: '',
    room: 'room1',
    date_start: '',
    toc: false,
  };
  errors.value = {
    name: '',
    firstname: '',
    email: '',
    phone: '',
    message: '',
    room: '',
    date_start: '',
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