<script>
import SideBar from "../generics/SideBar.vue";

export default {
  components: {
    SideBar,
  },
  data() {
    return {
      showSidebar: false,
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
      this.showSidebar = true;
    },
    closeSidebar () {
      this.showSidebar = false;
    }
  }
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
        <li>
          <button @click="$router.push({ name: 'MenuPage' })" class="text-uppercase">
            Cardápio
          </button>
        </li>
        <li v-if="! hasPermission">
          <button @click="$router.push({ name: 'MenuPage' })" class="text-uppercase">
            Sobre nós
          </button>
        </li>
        <li v-if="! hasPermission">
          <button @click="$router.push({ name: 'MenuPage' })" class="text-uppercase">
            Contato
          </button>
        </li>
        <li v-if="hasPermission">
          <button class="text-uppercase">Pedidos</button>
        </li>
        <li class="logo">
          <img @click="$router.push({ name: 'homePage' })" src="@/assets/logo-pizza.png" alt="Pizzaria Basileus" />
        </li>
      </ul>
    </nav>
  </header>

  <SideBar 
    v-if="showSidebar"
    @close="closeSidebar"
  />
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
  }

  .logo {
    img {
      width: 150px;
    }
  }
}
</style>
