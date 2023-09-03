<template>
  <header class="page-header">
    
    <nav class="menu" >
      <div class="menu-icon" :class="{ 'menu-open': isMenuOpen }" @click="toggleMenu">
        <div class="menu-bar"></div>
        <div class="menu-bar"></div>
        <div class="menu-bar"></div>
      </div>
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

<script setup>
import { ref } from 'vue';

const isMenuOpen = ref(false);

// Função para alternar o estado do menu
const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};
</script>

<style lang="scss">
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 70px;
  background-color: #FBFBFB;
  color: #000000;
  width: 50%;

  .menu{
    display: flex;
    align-items: center;

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
