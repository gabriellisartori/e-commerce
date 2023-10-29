<script>
import LimitPizzaModal from "../limitPizza/LimitPizzaModal.vue";
import OpeningHoursModal from "../openingHours/OpeningHoursModal.vue";
import SideBar from "../generics/SideBar.vue";

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
      configOptions: [
        {
          name: "Horário",
          route: "OpeningHours",
        },
        {
          name: "Limite de Pizzas",
          route: "LimitPizza",
        },
        {
          name: "Ingredientes",
          route: "IngredientPage",
        },
        {
          name: "Categorias",
          route: "CategoryPage",
        },
        {
          name: "Promoções",
          route: "PromotionPage",
        },
      ],
    };
  },
  computed: {
    isLoged() {
      return this.$auth.check();
    },
    hasPermission() {
      return (
        this.$auth.user() &&
        (this.$auth.user().is_admin ||
          this.$auth.user().establishment_id !== null)
      );
    },
  },
  methods: {
    toggleSideBar() {
      this.showSubmenu = false;
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
    },
    route(option) {
      this.showSubmenu = false;
      if (option === "OpeningHours" || option === "LimitPizza") {
        this.openModal(option);
      } else {
        this.$router.push({ name: option });
      }
    },
  },
};
</script>

<template>
  <header class="page-header">
    <nav class="menu">
      <ul>
        <div class="menu-icon" @click="toggleSideBar" v-if="isLoged">
          <div class="menu-bar"></div>
          <div class="menu-bar"></div>
          <div class="menu-bar"></div>
        </div>
        <li>
          <button @click="route('homePage')" class="text-uppercase">
            Home
          </button>
        </li>
        <li>
          <button @click="route('MenuPage')" class="text-uppercase">
            Cardápio
          </button>
        </li>
        <li v-if="! hasPermission">
          <button @click="route('MenuPage')" class="text-uppercase">
            Sobre nós
          </button>
        </li>
        <li v-if="! hasPermission">
          <button @click="route('MenuPage')" class="text-uppercase">
            Contato
          </button>
        </li>
        <li v-if="hasPermission" @click="showSubmenu = !showSubmenu">
          <button class="text-uppercase">Configurações</button>
          <ul class="submenu" v-if="showSubmenu">
            <li v-for="(link, index) in configOptions" :key="index">
              <button @click="route(link.route)">{{ link.name }}</button>
            </li>
          </ul>
        </li>
        <li class="logo">
          <img src="@/assets/logo-pizza.png" alt="Pizzaria Basileus" />
        </li>
      </ul>
    </nav>
  </header>

  <SideBar />

  <OpeningHoursModal
    v-if="showModal && modalType === 'OpeningHours'"
    @close="closeModal"
  ></OpeningHoursModal>
  <LimitPizzaModal
    v-if="showModal && modalType === 'LimitPizza'"
    @close="closeModal"
  ></LimitPizzaModal>
</template>



<style scoped lang="scss">
.page-header {
  padding: 10px 70px;
  color: #000000;
  width: 50%;

  .menu {
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
      align-items: center;

      li {
        margin-right: 20px;
        white-space: nowrap;

        button {
          text-decoration: none;
          color: #000000;
          font-weight: bold;
          transition: color 0.3s;
          background-color: transparent;
          border: none;
          cursor: pointer;

          &:hover {
            color: var(--cor-secundaria);
          }
        }
      }

      ul,
      li:last-child {
        width: -webkit-fill-available;
        text-align: end;
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

  .logo {
    img {
      width: 150px;
    }
  }
}
</style>
