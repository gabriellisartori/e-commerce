<script>
import SideBar from "../generics/SideBar.vue";

export default {
  components: {
    SideBar,
  },
  data() {
    return {
      showSidebar: false,
      hasItemsInCart: false,
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
    currentRoute() {
      return this.$route.name;
    },
  },
  methods: {
    toggleSideBar() {
      this.showSidebar = true;
    },
    closeSidebar() {
      this.showSidebar = false;
    },
    checkCartItems() {
      const cartItems = JSON.parse(localStorage.getItem('selectedPizzas')) || [];
      this.hasItemsInCart = cartItems.length > 0;
      console.log('tem itens??', this.hasItemsInCart)
    },
    goToCarrinho() {
      if (this.$auth.check()) {
        this.$router.push({ name: 'ShoppingPage' });
      } else {
        this.$router.push({ name: 'login' });
      }

      this.checkCartItems();
    },
  },
  mounted() {
    this.checkCartItems();
  },
};
</script>

<template>
  <header class="page-header" :class="{ 'is-home': $route.name === 'homePage' }">
    <nav class="menu">
      <ul>
        <div class="menu-icon" @click="toggleSideBar" v-if="isLoged">
          <div class="menu-bar"></div>
          <div class="menu-bar"></div>
          <div class="menu-bar"></div>
        </div>
        <li>
          <button @click="$router.push({ name: 'homePage' })" class="text-uppercase">
            Home
          </button>
        </li>
        <li v-if="hasPermission">
          <button @click="$router.push({ name: 'MenuPage' })" class="text-uppercase">
            Cardápio
          </button>
        </li>
        <li v-if="!hasPermission">
          <button @click="$router.push({ name: 'MenuPageClient' })" class="text-uppercase">
            Cardápio
          </button>
        </li>
        <li v-if="!hasPermission">
          <button @click="$router.push({ name: 'AboutPage' })" class="text-uppercase">
            Sobre nós
          </button>
        </li>
        <li v-if="!hasPermission">
          <button @click="$router.push({ name: 'ContactPage' })" class="text-uppercase">
            Contato
          </button>
        </li>
        <li v-if="hasPermission">
          <button @click="$router.push({ name: 'OrdersPage' })" class="text-uppercase">Pedidos</button>
        </li>
        <li class="logo">
          <img @click="$router.push({ name: 'homePage' })" src="@/assets/logo-pizza.png" alt="Pizzaria Basileus" />
        </li>
        <li v-if="$route.name !== 'homePage'" class="carrinho">
          <img @click="goToCarrinho" class="icon-carrinho" src="@/assets/icons/carrinho-icon.png" alt="Carrinho" />
          <div class="bolinha-verde" v-if="hasItemsInCart"></div>
        </li>
      </ul>
    </nav>
  </header>

  <SideBar v-if="showSidebar" @close="closeSidebar" />
</template>



<style scoped lang="scss">
.page-header {
  padding: 10px 70px;
  color: #000000;
  margin-top: 20px;

  @media screen and (max-width: 560px) {
    margin-bottom: 35px;
    padding: 10px 23px;
  }

  &.is-home {
    width: 50%;
  }

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
          font-size: 16px;

          &:hover {
            color: var(--cor-secundaria);
          }
        }
      }

      ul,
      li:last-child {
        width: 100%;
        text-align: end;
      }
    }

    @media screen and (max-width: 425px) {
      ul {
        li {
          margin-right: 10px;

          button {
            font-size: 14px;
          }
        }
      }
    }

    @media screen and (max-width: 375px) {
      ul {
        li {
          margin-right: 7px;
        }
      }
    }
  }

  .logo {
    img {
      width: 150px;

      @media screen and (max-width: 425px) {
        width: 72px;
      }
    }
  }

  .carrinho {
    position: relative;
    top: 0px;
    margin-top: 14px;
    cursor: pointer;
    z-index: 1;

    .icon-carrinho {
      width: 50px;
      height: 50px;
      transition: all 0.3s;

      &:hover {
        transform: scale(1.1);
      }
    }

    .bolinha-verde {
      position: absolute;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      top: 2px;
      right: -7px;
      background-color: var(--cor-primaria);
    }


    @media screen and (max-width: 425px) {
      display: none;
    }
  }
}
</style>
