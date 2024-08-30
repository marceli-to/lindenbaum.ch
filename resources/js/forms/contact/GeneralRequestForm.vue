<template>
  <form>
    <form-group>
      <form-label id="name" label="Name" required />
      <form-text-field 
        id="name" 
        label="Name" 
        v-model="form.name" 
        :error="errors.name"
        @update:error="errors.name = $event"
      />
    </form-group>
    <form-group>
      <form-label id="firstname" label="Vorname" required />
      <form-text-field 
        id="firstname" 
        label="Vorname" 
        v-model="form.firstname" 
        :error="errors.firstname"
        @update:error="errors.firstname = $event"
      />
    </form-group>
    <form-group>
      <form-label id="email" label="E-Mail" required />
      <form-text-field 
        id="email" 
        label="E-Mail" 
        type="email"
        v-model="form.email" 
        :error="errors.email"
        @update:error="errors.email = $event"
      />
    </form-group>
    <form-group>
      <form-label id="phone" label="Telefon" required />
      <form-text-field 
        id="phone" 
        label="Telefon" 
        type="tel"
        v-model="form.phone" 
        :error="errors.phone"
        @update:error="errors.phone = $event"
      />
    </form-group>
    <form-group>
      <form-label id="message" label="Ihre Nachricht" classes="!mb-10" required />
      <form-text-area 
        id="message" 
        label="Ihre Nachricht" 
        type="textarea"
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
        @click="handleSubmit"
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
  name: '',
  firstname: '',
  email: '',
  phone: '',
  message: '',
  toc: false,
});

const errors = ref({
  name: '',
  firstname: '',
  email: '',
  phone: '',
  message: '',
  toc: '',
});

const isSubmitting = ref(false);

async function submitForm() {



  emit('form-reset');
  try {
    const response = await axios.post('/api/contact/general', {
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

function handleSubmit() {
  isSubmitting.value = true;
  submitForm();
  isSubmitting.value = false;
}

function handleSuccess() {
  form.value = {
    name: '',
    firstname: '',
    email: '',
    phone: '',
    message: '',
    toc: false,
  };
  errors.value = {
    name: '',
    firstname: '',
    email: '',
    phone: '',
    message: '',
    toc: '',
  };
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
    emit('form-error');
    // window.scrollTo({
    //   top: 0,
    //   behavior: 'smooth'
    // });
  }
}
</script>