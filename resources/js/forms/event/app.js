import { createApp } from 'vue';
import ConferenceRegistration from './ConferenceRegistration.vue';
const app = createApp({});

app.component('conference-registration', ConferenceRegistration);

if (document.getElementById('app-forms')) {
  app.mount('#app-forms');
}
