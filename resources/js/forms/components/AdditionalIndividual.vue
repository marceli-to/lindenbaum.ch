<template>
  <div>
    <form-group v-if="hasFirstname">
      <form-label id="firstname" :label="'Vorname'" :required="requiresFirstname" />
      <form-text-field 
        v-model="individual.firstname" 
        :error="errors.firstname"
        @update:error="errors.firstname = $event"
      />
    </form-group>
    <form-group v-if="hasName">
      <form-label id="name" :label="'Name'" :required="requiresName" />
      <form-text-field 
        v-model="individual.name" 
        :error="errors.name"
        @update:error="errors.name = $event"
      />
    </form-group>
    <form-group v-if="hasEmail">
      <form-label id="email" :label="'E-Mail'" :required="requiresEmail" />
      <form-text-field 
        v-model="individual.email" 
        :error="errors.email"
        @update:error="errors.email = $event"
      />
    </form-group>
    <template v-if="hasMealOptions">
      <form-group>
        <label class="block font-bold mb-10 xl:mb-15">Verpflegung</label>
        <div class="flex gap-x-20 lg:gap-x-30 items-center mt-3 lg:mt-10 relative">
          <form-radio-field 
            v-model="individual.wants_meal_options" 
            :id="'individual_wants_meal_options_yes'"
            :name="'individual_wants_meal_options'"
            :error="errors.wants_meal_options"
            @update:error="errors.wants_meal_options = $event"
            @update:modelValue="individual.wants_meal_options = $event"
            :value="'true'"
            :label="'Ja'"
          />
          <form-radio-field 
            v-model="individual.wants_meal_options" 
            :id="'individual_wants_meal_options_no'"
            :name="'individual_wants_meal_options'"
            :error="errors.wants_meal_options"
            @update:error="errors.wants_meal_options = $event"
            @update:modelValue="individual.wants_meal_options = $event"
            :value="'false'"
            :label="'Nein'"
          />
          <Error :error="errors.wants_meal_options" />
        </div>
      </form-group>
      <form-group v-if="individual.wants_meal_options == 'true'">
        <form-label id="meal_options" :label="'Verpflegungswunsch'" :required="requiresMealOptions" />
        <form-select-field 
          v-model="individual.meal_options" 
          :error="errors.meal_options"
          @update:error="errors.meal_options = $event"
          :options="mealOptions"
        />
      </form-group>
    </template>

  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import FormGroup from '@/forms/components/fields/group.vue';
import FormTextField from '@/forms/components/fields/text.vue';
import FormLabel from '@/forms/components/fields/label.vue';
import FormSelectField from '@/forms/components/fields/select.vue';
import FormRadioField from '@/forms/components/fields/radio.vue';
import Error from '@/forms/components/fields/error.vue';

const props = defineProps({
  hasName: Boolean,
  requiresName: Boolean,
  hasFirstname: Boolean,
  requiresFirstname: Boolean,
  hasMealOptions: Boolean,
  requiresMealOptions: Boolean,
  hasEmail: Boolean,
  requiresEmail: Boolean,
  mealOptions: Array,
  errors: {
    type: Object,
    default: () => ({})
  }
});

const emit = defineEmits(['update:individual']);
const individual = ref({
  email: null,
  name: null,
  firstname: null,
  wants_meal_options: null,
  meal_options: null,
});

// Watch for changes in the individual object and emit them to the parent
watch(individual, (newValue) => {
  emit('update:individual', newValue);
}, { deep: true });

// Watch for changes in wants_meal_options
watch(() => individual.value.wants_meal_options, (newValue) => {
  if (newValue === 'true') {
    individual.value.meal_options = props.mealOptions[0]?.value ?? null;
  } else {
    individual.value.meal_options = null;
  }
});
</script>