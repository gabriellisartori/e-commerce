<script>
export default {
  methods: {
    toggleSideBar() {
      this.$el.style.width = this.$el.style.width === "200px" ? "0" : "200px";
    }
  }
}
</script>

<template>
  <div id="mySideBar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" @click="toggleSideBar">&times;</a>
    <a href="#">Meu perfil</a>
    <a href="#">Configurações</a>
  </div>
</template>
  
<style scoped>
.sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: var(--cor-primaria);
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
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
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}
</style>


  