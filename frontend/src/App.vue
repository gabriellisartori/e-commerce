<template>
  <HeaderPage v-if="! isLogin"></HeaderPage>
  <div id="app" v-if="isAuth">
    <div v-if="$auth.ready()">
      <div class="content">
        <router-view></router-view>
      </div>
    </div>
  </div>
  <div v-else>
    <router-view></router-view>
  </div>
</template>

<script>
import HeaderPage from "@/components/pageHeaders/HeaderPage.vue";

export default {
  name: "App",
  components: {
    HeaderPage,
  },
  computed: {
    isAuth() {
      return this.$auth.user();
    },
    isLogin() {
      return this.$route.name === "login";
    },
  }
};
</script>
