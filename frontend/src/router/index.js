import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/LoginForm.vue'; 
import RegisterEstablishment from '../pages/establishment/RegisterEstablishment.vue'; 
import HomePage from '../pages/establishment/HomePage.vue'; 

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
  {
    path: '/home',
    name: 'HomePage',
    component: HomePage,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
