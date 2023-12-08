<template>
  <div>
    <div class="page-header-options">
      <div>
        <h2 class="title">Promoções</h2>
      </div>
      <div>
        <base-button isTransparent color="dark-green" @onClick="addPromotion()"> Adicionar </base-button>
        <base-button class="icon" isTransparent isIcon icon="fa-solid fa-magnifying-glass" color="dark-green" @onClick="showFilters = true"/>
        <base-button class="icon" isTransparent isIcon icon="fa-solid fa-file-excel" color="dark-green" @click="exportFile()"/>
        <base-button class="icon" isTransparent isIcon icon="fa-solid fa-rotate" color="dark-green" @onClick="getAll"/>
      </div>
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

  <FiltersModal 
    v-if="showFilters"
    isName
    @close="showFilters = false"
    @getValues="searchFilter($event)"
  />
</template>

<script>
import PromotionModal from '@/components/promotion/PromotionModal.vue';
import { toast } from 'vue3-toastify';
import FiltersModal from '@/components/FiltersModal.vue';

export default {
  components: {
    PromotionModal,
    FiltersModal
  },
  data () {
    return {
      promotions: [],
      showModal: false,
      id: null,
      search: {
        name: null
      },
      showFilters: false
    };
  },
  methods: {
    async getData () {
      try {
        const { data } = await this.$http.get('/promotions', {
          params: this.search
        });
        this.promotions = data;
      } catch (error) {
        console.error(error);
      }
    },
    openModal (promotion) {
      this.id = promotion.id;
      this.showModal = true;
    },
    addPromotion() {
      this.id = null;
      this.showModal = true;
    },
    async deletePromotion (promotionId) {
      const confirmed = await this.$swal.fire({
        icon: 'warning',
        title: 'Realmente deseja excluir?',
        text: 'Você não poderá reverter isso!',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
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
    searchFilter (event) {
      this.search.name = event
      this.getData()
    },
    getAll () {
      this.search.name = null
      this.getData()
    },
    async exportFile () {
      const { data } = await this.$http.get('/promotions/exportFile', { params: this.search }, {
        responseType: 'blob'
      });
      const url = window.URL.createObjectURL(new Blob([data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'promoções.xlsx');
      document.body.appendChild(link);
      link.click();
    }
  },
  mounted () {
    this.getData();
  }
};
</script>