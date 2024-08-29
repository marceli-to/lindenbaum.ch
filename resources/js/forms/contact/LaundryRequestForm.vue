<template>
  <form @submit.prevent="submitForm">
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
import TextField from '../components/fields/text.vue';

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
    const response = await axios.post('/api/contact/laundry', {
      ...form.value,
    });
    // Handle success
  } catch (error) {
    // Handle errors
    if (typeof error.response.data.errors === 'object') {
      Object.keys(error.response.data.errors).forEach(key => {
        errors.value[key] = error.response.data.errors[key][0];
      });
    }
  }
}
</script>