<template>
  <div class="content">
    <div class="page-header-options">
      <h3 class="title text-uppercase">Promoções</h3>
      <base-button isTransparent color="dark-green" @onClick="showModal = true"> Adicionar </base-button>
    </div>
  </div>
  <div class="content-ingredient">
    <base-card
      v-for="promotion in promotions"
      :key="promotion.id"
      :title="promotion.name"
      @edit="openModal(promotion)"
      @delete="deletePromotion(promotion.id)"
    >
    </base-card>
  </div>
  <PromotionModal 
    v-if="showModal"
    :id="id"
    @close="showModal = false"
    @savePromotion="getData"
  />
</template>

<script>
import PromotionModal from '@/components/promotion/PromotionModal.vue';
import { toast } from 'vue3-toastify';

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
        const { data } = await this.$http.get('/promotions');
        this.promotions = data;
      } catch (error) {
        console.error(error);
      }
    },
    openModal (promotion) {
      this.id = promotion.id;
      this.showModal = true;
    },
    async deletePromotion (promotionId) {
      const confirmed = await this.$swal.fire({
        title: 'Tem certeza que deseja excluir?',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir',
        reverseButtons: true
      });

      if (confirmed.isConfirmed) {
        try {
          await this.$http.delete(`/promotions/${promotionId}`);
          this.getData();

          toast.success("Promoção excluída!", {
            position: toast.POSITION.BOTTOM_LEFT,
          });
        } catch (error) {
          console.error(error);
          this.$swal.fire(
            'Erro!',
            'Ocorreu um erro ao excluir a promoção.',
            'error'
          );
        }
      }
    },
  },
  mounted () {
    this.getData();
  }
};
</script>