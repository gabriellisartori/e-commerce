<template>
  <div id="app">
    <PageHeaderEstablishment></PageHeaderEstablishment>
    <div class="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import PageHeaderEstablishment from '@/components/pageHeaders/PageHeaderEstablishment.vue';

export default {
  name: 'App',
  components: {
    PageHeaderEstablishment,
    //Todo: verificar se está autenticado
  }
}

</script>
