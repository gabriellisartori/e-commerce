<script>
import PageHeaderEstablishment from '@/components/PageHeaderEstablishment.vue';
import AddCategoryModal from '@/components/AddCategoryModal.vue'
import CategoryCard from '@/components/CategoryCard.vue';
/* import SvgIcon from '@/components/SvgIcon.vue';
 */
export default {
  components: {
    PageHeaderEstablishment,
    AddCategoryModal,
    CategoryCard
},
  data() {
    return {
      showModal: false 
    };
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    }
  }
};
</script>

<template>
    <PageHeaderEstablishment></PageHeaderEstablishment>
    <div class="content">
      <div class="page-header-options">
        <h2 class="title">CATEGORIAS</h2>
        <!-- <SvgIcon name="plus"/> -->
        <button class="button-add" @click="openModal">
            Adicionar
        </button>
      </div>
    
      <div class="content-category">
        <CategoryCard></CategoryCard>
      </div>
    </div>
   
    <AddCategoryModal v-if="showModal" @close="closeModal"></AddCategoryModal>
</template>

<style lang="scss">
.content{


  .page-header-options{

    .button-add{
      background-color: transparent;
      color: var(--cor-secundaria);
      font-weight: 700;
      border: none;
      font-size: 16px;
      cursor: pointer;
    }
  }

  .content-category{
    display: grid;
    grid-template-columns: 1fr 1fr;
  }
  
}
</style>