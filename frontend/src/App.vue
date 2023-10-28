<template>
  <div id="app" v-if="isAuth">
    <div v-if="$auth.ready()">
      <PageHeaderEstablishment></PageHeaderEstablishment>
      <div class="content">
        <router-view></router-view>
      </div>
    </div>
  </div>
  <div v-else>
    <PageHeaderEstablishment v-if="! isLogin"></PageHeaderEstablishment>
    <router-view></router-view>
  </div>
</template>

<script>
import PageHeaderEstablishment from "@/components/pageHeaders/PageHeaderEstablishment.vue";

export default {
  name: "App",
  components: {
    PageHeaderEstablishment,
  },
  computed: {
    isAuth() {
      return this.$auth.user();
    },
    isLogin () {
      return this.$route.name === 'login'
    }
  }
};
</script>
