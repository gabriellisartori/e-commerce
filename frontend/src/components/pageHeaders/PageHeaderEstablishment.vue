<script>
import LimitPizzaModal from '../limitPizza/LimitPizzaModal.vue';
import OpeningHoursModal from '../openingHours/OpeningHoursModal.vue';
import SideBar from '../generics/SideBar.vue'

export default {
  components: {
    SideBar,
    LimitPizzaModal,
    OpeningHoursModal,
  },
  data() {
    return {
      showSubmenu: false,
      showModal: false,
      modalType: null,
      configuracoes: [
        { nome: 'Horário', modal: 'OpeningHours' },
        { nome: 'Limite de Pizzas', modal: 'LimitPizza' },
        { nome: 'Ingredientes', rota: 'IngredientPage' },
        { nome: 'Promoções', rota: 'PromotionPage' },
        { nome: 'Categorias', rota: 'CategoryPage' }
      ]
    }
  },
  methods: {
    toggleSideBar() {
      const sideBarElement = document.getElementById("mySideBar");

      if (sideBarElement.style.width === "200px") {
        sideBarElement.style.width = "0";
      } else {
        sideBarElement.style.width = "200px";
      }
    },
    showSubMenu() {
      this.showSubmenu = true;
    },
    hideSubMenu() {
      this.showSubmenu = false;
    },
    openModal(modalType) {
      this.modalType = modalType;
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    }
  }
}
</script>

<template>
  <header class="page-header">

    <nav class="menu">
      <div class="menu-icon" @click="toggleSideBar">
        <div class="menu-bar"></div>
        <div class="menu-bar"></div>
        <div class="menu-bar"></div>
      </div>
      <ul>
        <li><button @click="$router.push({ name: 'HomePage'})">HOME</button></li>
        <li><button @click="$router.push({ name: 'MenuPage'})">CARDÁPIO</button></li>
        <!-- <li @mouseover="showSubMenu" @mouseleave="hideSubMenu">
          <a class="settings" href="#">CONFIGURAÇÕES</a>
          <ul class="submenu" v-if="showSubmenu">
            <li @click="openModal('OpeningHours')"><a href="#">HORÁRIO</a></li>
            <li @click="openModal('LimitPizza')"><a href="#">LIMITE DE PIZZAS</a></li>
            <li><button @click="$router.push({ name: 'IngredientPage'})">INGREDIENTES</button></li>
            <li><button @click="$router.push({ name: 'PromotionPage' })">PROMOÇÕES</button></li>
            <li><button @click="$router.push({ name: 'CategoryPage' })">CATEGORIAS</button></li>
          </ul>
        </li> -->
        <li @mouseover="showSubMenu" @mouseleave="hideSubMenu">
          <a class="settings" href="#">CONFIGURAÇÕES</a>
          <ul class="submenu" v-if="showSubmenu">
            <li v-for="config in configuracoes" :key="config.nome">
              <template v-if="config.modal">
                <button @click="openModal(config.modal)">{{ config.nome }}</button>
              </template>
              <template v-else>
                <button @click="$router.push({ name: config.rota })">{{ config.nome }}</button>
              </template>
            </li>

          </ul>
        </li>
      </ul>
    </nav>
    <div class="logo">
      <img src="@/assets/logo-pizza.png" alt="Pizzaria Basileus" />
    </div>
  </header>

  <SideBar />

  <OpeningHoursModal v-if="showModal && modalType === 'OpeningHours'" @close="closeModal"></OpeningHoursModal>
  <LimitPizzaModal v-if="showModal && modalType === 'LimitPizza'" @close="closeModal"></LimitPizzaModal>
</template>



<style scoped lang="scss">
.page-header {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  padding: 10px 70px;
  color: #000000;
  width: 50%;

  .menu {
    display: flex;
    align-items: center;

    .menu-icon {
      cursor: pointer;
      display: flex;
      flex-direction: column;
      margin-right: 20px;
    }

    .menu-bar {
      width: 6px;
      height: 6px;
      background-color: #000000;
      margin: 2px 0;
      border-radius: 16px;
    }

    ul {
      list-style-type: none;
      padding: 0;
      display: flex;

      li {
        margin-right: 20px;

        a,
        button {
          text-decoration: none;
          color: #000000;
          font-weight: bold;
          transition: color 0.3s;
          background-color: transparent;
          border: none;

          &:hover {
            color: var(--cor-secundaria);
          }
        }

      }
    }

    .submenu {
      display: flex;
      flex-direction: column;
      margin-top: 10px;
      padding: 15px;
      border-radius: 16px;
      position: absolute;
      background-color: var(--cor-primaria);
      border: none;
      line-height: 1.8;
      font-size: 14px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;

      &:before {
        content: "▲";
        position: absolute;
        top: -30px;
        left: 3px;
        font-size: 33px;
        color: #5f8a17;
      }

      li {
        display: block;

        a,
        button {
          color: var(--cor-site);
          padding: 10px 16px;
          text-decoration: none;
        }
      }
    }
  }

  .logo img {
    width: 150px;
  }
}
</style>
