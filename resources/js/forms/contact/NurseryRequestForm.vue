<template>
  <form @submit.prevent="submitForm">
    <form-group>
      <form-label id="name_parents" label="Name der Eltern" required />
      <form-text-field 
        v-model="form.name_parents" 
        :error="errors.name_parents"
        @update:error="errors.name_parents = $event"
      />
    </form-group>
    <form-group>
      <form-label id="street" label="Strasse" required />
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
      <form-label id="phone_business" label="Telefon Geschäft" />
      <form-text-field 
        type="tel"
        v-model="form.phone_business" 
        :error="errors.phone_business"
        @update:error="errors.phone_business = $event"
      />
    </form-group>
    <form-group>
      <form-label id="martial_status" label="Zivilstand" required />
      <form-select 
        v-model="form.martial_status" 
        :error="errors.martial_status"
        @update:error="errors.martial_status = $event"
        :options="maritalStatusOptions"
      />
    </form-group>
    <form-group>
      <form-label id="name_child" label="Name des Kindes" required />
      <form-text-field 
        v-model="form.name_child" 
        :error="errors.name_child"
        @update:error="errors.name_child = $event"
      />
    </form-group>
    <form-group>
      <form-label id="gender" label="Geschlecht" required />
      <form-select 
        v-model="form.gender" 
        :error="errors.gender"
        @update:error="errors.gender = $event"
        :options="genderOptions"
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
      <form-label id="citizenship" label="Nationalität" required />
      <form-text-field 
        v-model="form.citizenship" 
        :error="errors.citizenship"
        @update:error="errors.citizenship = $event"
      />
    </form-group>
    <form-group class="relative">
      <form-label id="care_days" label="Gewünschte Betreuung" required />
      <div class="sm:flex sm:flex-wrap sm:gap-y-20 pt-10">
        <form-checkbox
          v-for="option in careDaysOptions"
          :key="option.value"
          :id="'care_days_' + option.value"
          :name="'care_days[]'"
          :value="option.value"
          :label="option.label"
          classes="mb-15 sm:mb-0 sm:flex sm:w-[30%] sm:flex-shrink-0"
          :modelValue="form.care_days.includes(option.value)"
          @update:modelValue="updateCareDays(option.value, $event)"
        />
      </div>
      <form-error :error="errors.care_days" classes="!top-0" />

    </form-group>
    <form-group>
      <form-label id="care_days_flexible" label="Flexible (bitte angeben wie viele Tage pro Woche)" />
      <form-text-field 
        v-model="form.care_days_flexible" 
        :error="errors.care_days_flexible"
        @update:error="errors.care_days_flexible = $event"
      />
    </form-group>
    <form-group>
      <form-label id="justification_urgency" label="Begründung der Dringlichkeit" required />
      <form-text-area 
        v-model="form.justification_urgency" 
        :error="errors.justification_urgency"
        @update:error="errors.justification_urgency = $event"
      />
    </form-group>
    <form-group>
      <form-label id="previous_care_type" label="Bisherige Betreuungsart" required />
      <form-text-area 
        v-model="form.previous_care_type" 
        :error="errors.previous_care_type"
        @update:error="errors.previous_care_type = $event"
      />
    </form-group>
    <form-group>
      <form-label id="date_of_entry" label="Gewünschter Eintrittstermin" required />
      <form-text-field 
        type="date"
        :min="minDate"
        v-model="form.date_of_entry" 
        :error="errors.date_of_entry"
        @update:error="errors.date_of_entry = $event"
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
import FormCheckbox from '../components/fields/checkbox.vue';
import FormError from '../components/fields/error.vue';

const emit = defineEmits(['form-success', 'form-error', 'form-reset']);

const props = defineProps({
  service: {
    type: String,
    required: true
  }
});

const form = ref({
  name_parents: '',
  street: '',
  location: '',
  email: '',
  phone: '',
  phone_business: '',
  martial_status: '',
  name_child: '',
  gender: '',
  date_of_birth: '',
  citizenship: '',
  care_days: [],
  care_days_flexible: '',
  justification_urgency: '',
  previous_care_type: '',
  date_of_entry: '',
  toc: false,
});

const errors = ref({
  name_parents: '',
  street: '',
  location: '',
  email: '',
  phone: '',
  phone_business: '',
  martial_status: '',
  name_child: '',
  gender: '',
  date_of_birth: '',
  citizenship: '',
  care_days: '',
  care_days_flexible: '',
  justification_urgency: '',
  previous_care_type: '',
  date_of_entry: '',
  toc: '',
});

const maritalStatusOptions = ref([
  { value: 'Ledig', label: 'Ledig' },
  { value: 'Verheiratet', label: 'Verheiratet' },
  { value: 'Geschieden', label: 'Geschieden' },
  { value: 'Verwitwet', label: 'Verwitwet' },
]);

const genderOptions = ref([
  { value: 'Männlich', label: 'Männlich' },
  { value: 'Weiblich', label: 'Weiblich' },
  { value: 'Divers', label: 'Divers' },
]);

const careDaysOptions = ref([
  { value: 'Montag', label: 'Montag' },
  { value: 'Dienstag', label: 'Dienstag' },
  { value: 'Mittwoch', label: 'Mittwoch' },
  { value: 'Donnerstag', label: 'Donnerstag' },
  { value: 'Freitag', label: 'Freitag' },
]);

function updateCareDays(value, checked) {
  if (checked) {
    form.value.care_days.push(value);
  } else {
    form.value.care_days = form.value.care_days.filter(day => day !== value);
  }
}

const minDate = ref(new Date().toISOString().split('T')[0]);

const isSubmitting = ref(false);

async function submitForm() {
  isSubmitting.value = true;
  emit('form-reset');
  try {
    const response = await axios.post('/api/contact-request/nursery', {
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
    name_parents: '',
    street: '',
    location: '',
    email: '',
    phone: '',
    phone_business: '',
    martial_status: '',
    name_child: '',
    gender: '',
    date_of_birth: '',
    citizenship: '',
    care_days: [],
    care_days_flexible: false,
    justification_urgency: '',
    previous_care_type: '',
    date_of_entry: '',
    toc: false,
  };
  errors.value = {
    name_parents: '',
    street: '',
    location: '',
    email: '',
    phone: '',
    phone_business: '',
    martial_status: '',
    name_child: '',
    gender: '',
    date_of_birth: '',
    citizenship: '',
    care_days: '',
    care_days_flexible: '',
    justification_urgency: '',
    previous_care_type: '',
    date_of_entry: '',
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