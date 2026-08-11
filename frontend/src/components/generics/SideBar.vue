<script>
export default {
  data() {
    return {
      establishmentOptions: [
        {
          name: "Meu perfil",
          icon: "fa-solid fa-user",
          route: "ProfilePage",
        },
        {
          name: "Horário de funcionamento",
          icon: "fa-solid fa-clock",
          route: "BusinessHoursModal",
        },
        {
          name: "Categorias",
          icon: "fa-solid fa-tag",
          route: "CategoryPage",
        },
        {
          name: "Ingredientes",
          icon: "fa-solid fa-pizza-slice",
          route: "IngredientPage",
        },
        {
          name: "Promoções",
          icon: "fa-solid fa-dollar-sign",
          route: "PromotionPage",
        },
        {
          name: "Limite de pizzas",
          icon: "fa-solid fa-mitten",
          route: "LimitPizzaPage",
        },
      ],
      clientOptions: [
        {
          name: "Meu perfil",
          icon: "fa-solid fa-user",
          route: "ProfilePage",
        },
        {
          name: "Meus pedidos",
          icon: "fa-solid fa-bag-shopping",
          route: "MyOrdersPage",
        }
      ]
    };
  },
  computed: {
    hasPermission() {
      return this.$auth.user() && this.$auth.user().is_admin;
    },
    isEstablishment () {
      return this.$auth.user() && (this.$auth.user().establishment_id || this.$auth.user().is_admin);
    }
  }
}
</script>

<template>
  <div>
    <div id="mySideBar" class="sidebar">
      <div @click="$emit('close')">
        <font-awesome-icon class="closebtn" icon="fa-solid fa-xmark" />
      </div>
      <div class="sidebar-items" @click="$emit('close')">
        <ul v-if="isEstablishment">
          <li v-for="(option, index) in establishmentOptions" :key="index">
            <button @click="$router.push({ name: option.route })">
              <font-awesome-icon class="icon" :icon="option.icon" />
              {{ option.name }}
            </button>
          </li>
        </ul>

        <ul v-else>
          <li v-for="(option, index) in clientOptions" :key="index">
            <button @click="$router.push({ name: option.route })">
              <font-awesome-icon class="icon" :icon="option.icon" />
              {{ option.name }}
            </button>
          </li>
        </ul>

        <button v-if="hasPermission" @click="$router.push({ name: 'RegisterEstablishment' })">
          <font-awesome-icon class="icon" icon="fa-solid fa-plus" />
          Cadastrar estabelecimento
        </button>
        <button @click="$auth.logout()">
          <font-awesome-icon class="icon" icon="fa-solid fa-arrow-right-from-bracket" />
          Sair
        </button>
      </div>
    </div>
    <div @click="$emit('close')" class="overlay-sidebar"></div>
  </div>
</template>
  
<style scoped lang="scss">

.sidebar {
  height: 100%;
  width: 300px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: var(--cor-primaria);
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 50px;

  &-items {
    display: flex;
    flex-direction: column;

    .icon {
      margin-right: 10px;
    }

    
    button {
      color: #ffffff;
      background-color: transparent;
      border: none;
      cursor: pointer;
      transition: color 0.3;
      font-size: 1.1rem;
      padding: 8px 8px 8px 32px;
      text-align: left;
      font-family: 'Inria Sans';
      font-weight: 700;
      margin-bottom: 10px;
      
      &:hover {
        color: var(--cor-secundaria);
      }
    }
  }
}

.overlay-sidebar {
  position: absolute;
    top: 0;
    left: 300px;
    width: calc(100% - 300px);
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

.sidebar a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 16px;
  color: var(--cor-site);
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  color: #f1f1f1;
}

.sidebar .closebtn {
  color: white;
  position: absolute;
  top: 5px;
  right: 13px;
  font-size: 28px;
  cursor: pointer;
}
</style>


  