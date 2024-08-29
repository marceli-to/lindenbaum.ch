<template>
  <form @submit.prevent="submitForm" class="max-w-xl mx-auto">
    <div class="mb-10">
      <text-field 
        id="name" 
        label="Name" 
        v-model="form.name" 
        :error="errors.name"
        @update:error="errors.name = $event"
      />

    </div>
    <div>
      <text-field 
        id="email" 
        label="E-Mail" 
        v-model="form.email" 
        :error="errors.email"
        @update:error="errors.email = $event"
      />
    </div>
  <div>
    <button type="submit">Register</button>
  </div>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import TextField from './components/fields/text.vue';

const props = defineProps(['eventId']);

const form = ref({
  name: '',
  email: '',
});

const errors = ref({
  name: '',
  email: '',
});

async function submitForm() {
  try {
    const response = await axios.post('/api/register-conference', {
      ...form.value,
      event_id: props.eventId
    });
    // Handle success
  } catch (error) {
    // Handle errors

    console.log(error.response.data.errors);
    // TypeError: error.response.data.errors.forEach is not a function
    // so we need to check if the error.response.data.errors is an object
    if (typeof error.response.data.errors === 'object') {
      Object.keys(error.response.data.errors).forEach(key => {
        errors.value[key] = error.response.data.errors[key][0];
      });
    }



  }
}
</script>