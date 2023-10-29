import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/LoginForm.vue'; 
import RegisterEstablishment from '../pages/establishment/RegisterEstablishment.vue'; 
import HomePage from '../pages/establishment/HomePage.vue'; 
import IngredientPage from '../pages/establishment/IngredientPage.vue'
import CategoryPage from '../pages/establishment/CategoryPage.vue'
import MenuPageVue from '@/pages/establishment/MenuPage.vue';
import PromotionPage from '../pages/establishment/PromotionPage.vue'
/* import LimitPizzaModal from '../components/LimitPizzaModal.vue'
 */
const routes = [
  { 
    path: '/', 
    redirect: { name: 'homePage' } 
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      auth: false,
    }
  },
  {
    path: '/registrar',
    name: 'RegisterEstablishment',
    component: RegisterEstablishment,
    meta: {
      auth: true,
    }
  },
  {
    path: '/home',
    name: 'homePage',
    component: HomePage,
  },
  {
    path: '/cardapio',
    name: 'MenuPage',
    component: MenuPageVue,
  },
  /* {
    path: '/limit',
    name: 'LimitPizzaModal',
    component: LimitPizzaModal,
  }, */
  {
    path: '/ingredient',
    name: 'IngredientPage',
    component: IngredientPage,
    meta: {
      auth: true,
    }
  },
  {
    path: '/category',
    name: 'CategoryPage',
    component: CategoryPage,
    meta: {
      auth: true,
    }
  },
  {
    path: '/promotion',
    name: 'PromotionPage',
    component: PromotionPage,
    meta: {
      auth: true,
    }
  },
  {
    path: '/404',
    redirect: { name: 'homePage' },
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
