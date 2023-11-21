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
  },
  mounted() {
    this.checkCartItems();
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
          <button class="text-uppercase">Pedidos</button>
        </li>
        <li class="logo">
          <img @click="$router.push({ name: 'homePage' })" src="@/assets/logo-pizza.png" alt="Pizzaria Basileus" />
        </li>
        <li v-if="$route.name === 'MenuPageClient' || $route.name === 'ShoppingPage'" class="carrinho">
          <img @click="$router.push({ name: 'ShoppingPage' })" class="icon-carrinho"
            :class="{ 'has-items': hasItemsInCart }" src="@/assets/icons/carrinho-icon.png" alt="Carrinho" />
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
  width: 50%;
  margin-top: 20px;

  @media screen and (max-width: 560px) {
    margin-bottom: 35px;
    padding: 10px 23px;
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
        width: -webkit-fill-available;
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
    position: absolute;
    top: 0px;
    margin-top: 14px;
    cursor: pointer;
    z-index: 1;

    .icon-carrinho {
      width: 4%;
    }

    .has-items::after {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 10px;
      height: 10px;
      background-color: green!important;
      border-radius: 50%;
    }


    @media screen and (max-width: 425px){
      display: none;
    } 
  }
}
</style>
