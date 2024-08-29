import { createApp } from 'vue';
import FormSelector from './FormSelector.vue';
const app = createApp({});
app.component('form-selector', FormSelector);
if (document.getElementById('app-forms')) {
  app.mount('#app-forms');
}