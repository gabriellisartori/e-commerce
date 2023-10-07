import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; 

import './assets/css/resset.css';

const app = createApp(App).use(router)

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
app.component('VueDatePicker', VueDatePicker);

import VueTimepicker from 'vue3-timepicker'
import 'vue3-timepicker/dist/VueTimepicker.css'
app.component('VueTimepicker', VueTimepicker);

import BaseButton from './components/generics/BaseButton.vue';
app.component('base-button', BaseButton);

import BaseChipCheckbox from './components/generics/BaseChipCheckbox.vue';
app.component('base-chip-checkbox', BaseChipCheckbox);


// Font Awesome
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
/* import specific icons */
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
/* add icons to the library */
library.add(faUserSecret)
app.component('font-awesome-icon', FontAwesomeIcon);

app.mount('#app');