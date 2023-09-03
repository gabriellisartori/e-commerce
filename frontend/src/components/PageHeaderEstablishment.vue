<script setup>
import { ref } from 'vue';

const isMenuOpen = ref(false);

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};
</script>

<template>
  <header class="page-header">
    
     <div class="menu-icon" @click="toggleMenu">
      <div class="menu-bar"></div>
      <div class="menu-bar"></div>
      <div class="menu-bar"></div>
    </div>

    <!-- Menu Lateral -->
    <div class="sidebar" :class="{ 'sidebar-open': isMenuOpen }">
      <ul>
        <li><a href="#">Perfil</a></li>
        <li><a href="#">Configurações</a></li>
      </ul>
    </div>

    <nav class="menu">
      <ul>
        <li><a href="#">HOME</a></li>
        <li><a href="#">CARDÁPIO</a></li>
        <li><a href="#">CONFIGURAÇÕES</a></li>
      </ul>
    </nav>

    <div class="logo">
      <img src="../assets/logo-pizza.png" alt="Pizzaria Basileus" />
    </div>
  </header>
</template>

<style lang="scss">
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 70px;
  background-color: #FBFBFB;
  color: #000000;
  width: 50%;

  .menu-icon {
    display: flex;
    flex-direction: column;
    cursor: pointer;
    margin-right: 20px;

    .menu-bar {
      width: 5px;
      height: 5px;
      background-color: #000000;
      margin: 4px 0;
      border-radius: 16px;
    }
  }

  .sidebar{
    display: none;
  }

  .sidebar-open {
    display: block;
    left: 0;
  }

  .menu{
    display: flex;
    align-items: center;

    ul{
      list-style-type: none;
      padding: 0;
      display: flex;

      li{
        margin-right: 20px;

        a{
          text-decoration: none;
          color: #000000;
          font-weight: bold;
          transition: color 0.3s;

          &:hover{
            color: #3E5903;
          }
        }
      }
    }
  }

  .menu-open {
    display: block;
  }

  .logo{
    img {
      width: 150px; 
    }
  } 
}
</style>
