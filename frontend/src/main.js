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

import BaseButtonGroup from './components/generics/BaseButtonGroup.vue';
app.component('base-button-group', BaseButtonGroup);

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

import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
app.use(Vue3Toasity, {
    autoClose: 3000,
});

app.mount('#app');