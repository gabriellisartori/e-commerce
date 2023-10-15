<template>
  <div class="content">
    <div class="page-header-options">
      <h3 class="title text-uppercase">Promoções</h3>
      <base-button isTransparent color="dark-green" @click="showModal = true"> Adicionar </base-button>
    </div>
  </div>
  <div class="content-ingredient">
    <base-card
      v-for="promotion in promotions"
      :key="promotion.id"
      :title="promotion.name"
      @edit="openModal(promotion)"
    >
    </base-card>
  </div>
  <PromotionModal 
    v-if="showModal"
    :id="id"
    @close="showModal = false"
  />
</template>

<script>
import PromotionModal from '@/components/promotion/PromotionModal.vue';
export default {
  components: {
    PromotionModal
  },
  data () {
    return {
      promotions: [],
      showModal: false,
      id: null
    };
  },
  methods: {
    async getData () {
      try {
        const { data } = await this.$http.get('/promotion/all');
        this.promotions = data;
      } catch (error) {
        console.error(error);
      }
    },
    openModal (promotion) {
      this.id = promotion.id;
      this.showModal = true;
    }
  },
  mounted () {
    this.getData();
  }
};
</script>

<style lang="scss">
</style>