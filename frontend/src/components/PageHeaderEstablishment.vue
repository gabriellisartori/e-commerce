<script>
import SideBar from './SideBar.vue'

export default {
  components: {
    SideBar
  },
  methods: {
    toggleSideBar() {
      const sideBarElement = document.getElementById("mySideBar");

      if (sideBarElement.style.width === "200px") {
        sideBarElement.style.width = "0";
      } else {
        sideBarElement.style.width = "200px";
      }
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
        <li><a href="#">HOME</a></li>
        <li><a href="#">CARDÁPIO</a></li>
        <li><a href="#">CONFIGURAÇÕES</a></li>
      </ul>
    </nav>
    <div class="logo">
      <img src="@/assets/logo-pizza.png" alt="Pizzaria Basileus" />
    </div>
  </header>

  <!-- Use o componente SideBar -->
  <SideBar />
</template>



<style scoped lang="scss">
.page-header {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  padding: 10px 70px;
  background-color: #FBFBFB;
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

  .logo img {
    width: 150px;
  }
}
</style>
