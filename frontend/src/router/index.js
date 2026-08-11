import { createRouter, createWebHistory } from 'vue-router';
import Login from '../pages/LoginForm.vue'; 
import RegisterEstablishment from '../pages/establishment/RegisterEstablishment.vue'; 
import HomePage from '../pages/establishment/HomePage.vue'; 
import IngredientPage from '../pages/establishment/IngredientPage.vue'
import CategoryPage from '../pages/establishment/CategoryPage.vue'
/* import LimitPizzaModal from '../components/LimitPizzaModal.vue'
 */
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
  /* {
    path: '/limit',
    name: 'LimitPizzaModal',
    component: LimitPizzaModal,
  }, */
  {
    path: '/ingredient',
    name: 'IngredientPage',
    component: IngredientPage,
  },
  {
    path: '/category',
    name: 'CategoryPage',
    component: CategoryPage,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
