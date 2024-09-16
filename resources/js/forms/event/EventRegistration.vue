<template>
  <template v-if="formSuccess">
    <success-alert>
      Vielen Dank für Ihre Anmeldung!
    </success-alert>
  </template>
  <template v-if="formError">
    <error-alert>
      Bitte überprüfen Sie die eingegebenen Daten.
    </error-alert>
  </template>
  <form @submit.prevent="submitForm" v-if="isLoaded" class="space-y-25 lg:space-y-35">
    <form-group v-if="hasFirstname">
      <form-label id="firstname" :label="'Vorname'" :required="requiresFirstname" />
      <form-text-field 
        v-model="form.firstname" 
        :error="errors.firstname"
        @update:error="errors.firstname = $event"
      />
    </form-group>
    <form-group v-if="hasName">
      <form-label id="name" :label="'Name'" :required="requiresName" />
      <form-text-field 
        v-model="form.name" 
        :error="errors.name"
        @update:error="errors.name = $event"
      />
    </form-group>
    <form-group v-if="hasEmail">
      <form-label id="email" :label="'E-Mail'" :required="requiresEmail" />
      <form-text-field 
        type="email"
        v-model="form.email" 
        :error="errors.email"
        @update:error="errors.email = $event"
      />
    </form-group>
    <form-group v-if="hasPhone">
      <form-label id="phone" :label="'Telefon'" :required="requiresPhone" />
      <form-text-field 
        v-model="form.phone" 
        :error="errors.phone"
        @update:error="errors.phone = $event"
      />
    </form-group>
    <template v-if="hasMealOptions">
      <form-group>
        <label class="block font-bold mb-10 xl:mb-15">Verpflegung</label>
        <div class="flex gap-x-20 lg:gap-x-30 items-center mt-3 lg:mt-10 relative">
          <form-radio-field 
            v-model="form.wants_meal_options" 
            :id="'wants_meal_options_yes'"
            :name="'wants_meal_options'"
            :error="errors.wants_meal_options"
            @update:error="errors.wants_meal_options = $event"
            @update:modelValue="form.wants_meal_options = $event"
            :value="'true'"
            :label="'Ja'"
          />
          <form-radio-field 
            v-model="form.wants_meal_options" 
            :id="'wants_meal_options_no'"
            :name="'wants_meal_options'"
            :error="errors.wants_meal_options"
            @update:error="errors.wants_meal_options = $event"
            @update:modelValue="form.wants_meal_options = $event"
            :value="'false'"
            :label="'Nein'"
          />
          <Error :error="errors.wants_meal_options" />
        </div>
      </form-group>
      <form-group v-if="form.wants_meal_options == 'true'">
        <form-label id="meal_options" :label="'Verpflegungswunsch'" :required="requiresMealOptions" />
        <form-select-field 
          v-model="form.meal_options" 
          :error="errors.meal_options"
          @update:error="errors.meal_options = $event"
          :options="mealOptions"
          />
      </form-group>
    </template>

    <template v-if="hasButtonAdditionalIndividuals">
      <div>
        <h3 class="mt-15 xl:mt-30 mb:15 xl:mb-25">Weitere Person(en)</h3>
        <form-group v-for="(individual, index) in additionalIndividuals" :key="index">
          <AdditionalIndividual
            :hasEmail="hasFieldAdditionalIndividualEmail"
            :requiresEmail="requiresEmail"
            :hasName="hasFieldAdditionalIndividualName"
            :requiresName="requiresName"
            :hasFirstname="hasFieldAdditionalIndividualFirstname"
            :requiresFirstname="requiresFirstname"
            :hasMealOptions="hasMealOptions"
            :requiresMealOptions="requiresMealOptions"
            :mealOptions="mealOptions"
            :errors="errors.additional_individuals ? errors.additional_individuals[index] : {}"
            @update:individual="updateAdditionalIndividual(index, $event)"
          />
          <div class="flex justify-start">
            <a 
              href="javascript:;" 
              @click.prevent="removeAdditionalIndividual(index)" 
              class="mt-10 xl:mt-20 inline-block text-xs xl:text-sm group">
              <span class="underline underline-offset-4 decoration-1 group-hover:no-underline">Person Entfernen</span>
            </a>
          </div>
        </form-group>
        <form-group>
          <a 
            href="javascript:;"
            @click.prevent="addAdditionalIndividual" 
            class="inline-block group"
          >
            + <span class="underline underline-offset-4 decoration-1 group-hover:no-underline">Weitere Person hinzufügen</span>
          </a>
        </form-group>
      </div>
    </template>

    <form-group v-if="hasRemarks">
      <form-label id="remarks" :label="'Bemerkungen'" />
      <form-textarea-field 
        v-model="form.remarks" 
        :error="errors.remarks"
        @update:error="errors.remarks = $event"
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
    <form-group classes="!mt-30">
      <form-button 
        type="submit" 
        :label="'Anmelden'"
        :disabled="isSubmitting"
        :submitting="isSubmitting"
      />
    </form-group>
  </form>
</template>
<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import FormGroup from '@/forms/components/fields/group.vue';
import FormTextField from '@/forms/components/fields/text.vue';
import FormTextareaField from '@/forms/components/fields/textarea.vue';
import FormLabel from '@/forms/components/fields/label.vue';
import FormButton from '@/forms/components/fields/button.vue';
import FormSelectField from '@/forms/components/fields/select.vue';
import FormRadioField from '@/forms/components/fields/radio.vue';
import FormToc from '@/forms/components/fields/toc.vue';
import Error from '@/forms/components/fields/error.vue';
import AdditionalIndividual from '@/forms/components/AdditionalIndividual.vue';
import SuccessAlert from '@/forms/components/alerts/success.vue';
import ErrorAlert from '@/forms/components/alerts/error.vue';

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
const hasName = ref(false);
const requiresName = ref(false);
const hasFirstname = ref(false);
const requiresFirstname = ref(false);
const hasEmail = ref(false);
const requiresEmail = ref(false);
const hasPhone = ref(false);
const requiresPhone = ref(false);
const hasMealOptions = ref(false);
const wantsMealOptions = ref(false);
const hasRemarks = ref(false);
const requiresMealOptions = ref(false);
const mealOptions = ref([]);
const hasButtonAdditionalIndividuals = ref(false);
const additionalIndividuals = ref([]);
const hasFieldAdditionalIndividualEmail = ref(false);
const hasFieldAdditionalIndividualName = ref(false);
const hasFieldAdditionalIndividualFirstname = ref(false);
const hasFieldAdditionalIndividualCostCenter = ref(false);

const form = ref({
  event_id: props.eventId,
  name: null  ,
  firstname: null,
  email: null,
  phone: null,
  remarks: null,
  wants_meal_options: null,
  meal_options: null,
  additional_individuals: [],
});

const errors = ref({
    name: '',
    firstname: '',
    email: '',
    phone: '',
    meal_options: '',
    additional_individuals: [],
  }
);

onMounted(async () => {
  try {
    const response = await axios.get(`/api/event/${props.eventId}`);
    isLoaded.value = true;
    hasName.value = response.data.has_name;
    requiresName.value = response.data.requires_name;
    hasFirstname.value = response.data.has_firstname;
    requiresFirstname.value = response.data.requires_firstname;
    hasEmail.value = response.data.has_email;
    requiresEmail.value = response.data.requires_email;
    hasPhone.value = response.data.has_phone;
    requiresPhone.value = response.data.requires_phone;
    hasRemarks.value = response.data.has_remarks;
    hasMealOptions.value = response.data.has_meal_options;
    if (hasMealOptions.value) {   
      
      if (response.data.meal_options) {
       Object.entries(response.data.meal_options).forEach(([key, value]) => {
         if (value) {
           mealOptions.value.push({ label: key, value: key });
         }
       });
       form.value.meal_options = mealOptions.value[0].value;
      }
    }

    hasButtonAdditionalIndividuals.value = response.data.has_button_additional_individuals;
    hasFieldAdditionalIndividualEmail.value = response.data.has_field_additional_individual_email;
    hasFieldAdditionalIndividualName.value = response.data.has_field_additional_individual_name;
    hasFieldAdditionalIndividualFirstname.value = response.data.has_field_additional_individual_firstname;
    hasFieldAdditionalIndividualCostCenter.value = response.data.has_field_additional_individual_cost_center;

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
      locale: locale.value,
    });
    handleSuccess();
  } catch (error) {
    handleError(error);
  }
}

function updateAdditionalIndividual(index, updatedIndividual) {
  additionalIndividuals.value[index] = updatedIndividual;
  form.value.additional_individuals = additionalIndividuals.value;
}

watch(additionalIndividuals, (newValue) => {
  form.value.additional_individuals = newValue;
}, { deep: true });

function addAdditionalIndividual() {
  additionalIndividuals.value.push({
    email: null,
    name: null,
    firstname: null,
    wants_meal_options: null,
    meal_options: null,
  });
  form.value.additional_individuals = additionalIndividuals.value;
}

function removeAdditionalIndividual(index) {
  additionalIndividuals.value.splice(index, 1);
  form.value.additional_individuals = additionalIndividuals.value;
}

function handleSuccess() {
  form.value = {
    event_id: props.eventId,
    name: null,
    firstname: null,
    email: null,
    phone: null,
    meal_options: null,
    additional_individuals: [],
  };

  // reset additional_individuals
  additionalIndividuals.value = [];
  form.value.additional_individuals = additionalIndividuals.value;
  
  errors.value = {
    name: '',
    firstname: '',
    email: '',
    phone: '',
    meal_options: '',
    additional_individuals: [],
  };
  
  isSubmitting.value = false;
  formSuccess.value = true;
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
}

function handleError(error) {
  isSubmitting.value = false;
  formError.value = true;

  if (error.response && error.response.data && typeof error.response.data.errors === 'object') {
    Object.keys(error.response.data.errors).forEach(key => {
      errors.value[key] = error.response.data.errors[key];
    });

    // handle additional_individuals errors
    if (error.response.data.errors.additional_individuals) {
      error.response.data.errors.additional_individuals.forEach(individualError => {
        Object.keys(individualError).forEach(key => {
          errors.value.additional_individuals[key] = individualError[key];
        });
      });
    }


    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
}
</script>