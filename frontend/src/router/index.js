import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/LoginForm.vue'; 
import RegisterEstablishment from '../pages/establishment/RegisterEstablishment.vue'; 
import HomePage from '../pages/establishment/HomePage.vue'; 
import IngredientPage from '../pages/establishment/IngredientPage.vue'
import CategoryPage from '../pages/establishment/CategoryPage.vue'
import MenuPageVue from '@/pages/establishment/MenuPage.vue';
import PromotionPage from '../pages/establishment/PromotionPage.vue'
import BusinessHoursModal from '../components/businessHours/BusinessHoursModal.vue'
import LimitPizzaPage from '../pages/establishment/LimitPizzaPage.vue'
import MenuPageClient from '../pages/client/MenuPageClient.vue'
import ShoppingPage from '../pages/client/ShoppingPage.vue'

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
    path: '/registrar-estabelecimento',
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
    path: '/menu',
    name: 'MenuPageClient',
    component: MenuPageClient,
  },
  {
    path: '/carrinho',
    name: 'ShoppingPage',
    component: ShoppingPage,
  },
  {
    path: '/cardapio',
    name: 'MenuPage',
    component: MenuPageVue,
    meta: {
      auth: true,
    }
  },
  {
    path: '/limite-diario-de-pizzas',
    name: 'LimitPizzaPage',
    component: LimitPizzaPage,
    meta: {
      auth: true,
    }
  },
  {
    path: '/ingredientes',
    name: 'IngredientPage',
    component: IngredientPage,
    meta: {
      auth: true,
    }
  },
  {
    path: '/categorias',
    name: 'CategoryPage',
    component: CategoryPage,
    meta: {
      auth: true,
    }
  },
  {
    path: '/promocoes',
    name: 'PromotionPage',
    component: PromotionPage,
    meta: {
      auth: true,
    }
  },
  {
    path: '/horario',
    name: 'BusinessHoursModal',
    component: BusinessHoursModal,
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
