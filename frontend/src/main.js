import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

import './assets/css/resset.css';

const app = createApp(App).use(router);

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
app.component('VueDatePicker', VueDatePicker);

import VCalendar from 'v-calendar';
import 'v-calendar/style.css';
app.use(VCalendar, {})

import BaseButton from './components/generics/BaseButton.vue';
app.component('base-button', BaseButton);

import BaseChipCheckbox from './components/generics/BaseChipCheckbox.vue';
app.component('base-chip-checkbox', BaseChipCheckbox);

import BaseButtonGroup from './components/generics/BaseButtonGroup.vue';
app.component('base-button-group', BaseButtonGroup);

import BaseCard from './components/generics/BaseCard.vue';
app.component('base-card', BaseCard);

import BaseModal from './components/generics/BaseModal.vue';
app.component('base-modal', BaseModal);

import BaseInput from './components/generics/BaseInput.vue';
app.component('base-input', BaseInput);

import BaseDate from './components/generics/BaseDatePicker.vue';
app.component('base-date', BaseDate);

import BaseTime from './components/generics/BaseTimePicker.vue';
app.component('base-time', BaseTime);

import BaseSwitch from './components/generics/BaseSwitch.vue';
app.component('base-switch', BaseSwitch);

import BaseSelect from './components/generics/BaseSelect.vue'
app.component('base-select', BaseSelect);

import BaseMessage from './components/generics/BaseMessage.vue';
app.component('base-message', BaseMessage);

import BaseSpecialeCard from './components/generics/BaseSpecialeCard.vue';
app.component('base-speciale', BaseSpecialeCard);

import BasePizzaCardClient from './components/generics/BasePizzaCardClient.vue';
app.component('base-pizza-card-client', BasePizzaCardClient);

// Font Awesome
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
/* import specific icons */
import { faUserSecret, faXmark, faPenToSquare, faTrash, faUser, faArrowRightFromBracket, faPlus, faClock, faPizzaSlice, faTag, faDollarSign, faMitten, faTriangleExclamation } from '@fortawesome/free-solid-svg-icons'
/* add icons to the library */
library.add(faUserSecret, faXmark, faPenToSquare, faTrash, faUser, faArrowRightFromBracket, faPlus, faClock, faPizzaSlice, faTag, faDollarSign, faMitten, faTriangleExclamation)
app.component('font-awesome-icon', FontAwesomeIcon);

// Vue3 Toastify
import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
app.use(Vue3Toasity, {
  autoClose: 3000,
});

// Vue Sweetalert2 Dialog
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const options = {
  confirmButtonColor: '#5F8A17',
  cancelButtonColor: '#7A7373',
  iconColor: '#5F8A17',
  focusConfirm: false,
};
app.use(VueSweetalert2, options);


// add axios
import axios from "axios";

const axiosInstance = axios.create({
  baseURL: 'http://localhost:8000/api',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
  },
});

app.config.globalProperties.$http = axiosInstance;

/**
 * Vue Auth
 */
import { createAuth } from '@websanova/vue-auth';
import driverAuthBearer from '@websanova/vue-auth/src/drivers/auth/bearer.js';
import driverHttpAxios from '@websanova/vue-auth/src/drivers/http/axios.1.x.js';
import driverRouterVueRouter from '@websanova/vue-auth/src/drivers/router/vue-router.2.x.js';

var auth = createAuth({
  plugins: {
    http: axiosInstance,
    router: router
  },
  drivers: {
    http: driverHttpAxios,
    auth: driverAuthBearer,
    router: driverRouterVueRouter,
  },
  options: {
    loginData: { url: 'auth/login', method: 'POST', fetchUser: true, staySignedIn: false },
    logoutData: { url: 'auth/logout', method: 'POST', redirect: { name: 'login' }, makeRequest: true },
    refreshData: { enabled: false },
    tokenDefaultKey: 'token',
    forbiddenRedirect: { path: '/403' },
    notFoundRedirect: { path: '/404' },
    stores: ['storage'],
    parseUserData ({ user }) {
      try {
        app.config.globalProperties.$user = user;
      } catch (error) {
        console.error(error);
      }
      return user;
    }
  }
});

app.use(auth);

app.mount('#app');