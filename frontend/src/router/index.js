import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/LoginForm.vue'; 
import RegisterEstablishment from '../pages/establishment/RegisterEstablishment.vue'; 

const routes = [
  {
    path: '/',
    name: 'LoginForm',
    component: Login,
  },
  {
    path: '/registrar',
    name: 'RegisterEstablishment',
    component: RegisterEstablishment,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
