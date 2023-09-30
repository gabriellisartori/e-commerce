<script>
import PageHeaderEstablishment from '@/components/pageHeaders/PageHeaderEstablishment.vue';
import AddIngredientModal from '@/components/ingredients/AddIngredientModal.vue'
import IngredientCard from '@/components/ingredients/IngredientCard.vue'
/* import SvgIcon from '@/components/SvgIcon.vue';
 */
export default {
  components: {
    IngredientCard,
    PageHeaderEstablishment,
    AddIngredientModal,
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
        <h3 class="title">INGREDIENTES</h3>
        <!-- <SvgIcon name="plus"></SvgIcon> -->
        <button class="button-add" @click="openModal">
            Adicionar
        </button>
    </div>
    
    <div class="content-ingredient">
        <IngredientCard></IngredientCard>
    </div>
    </div>
   
    <AddIngredientModal v-if="showModal" @close="closeModal"></AddIngredientModal>

</template>

<style lang="scss">
.menu-home{
  .settings{
    border-bottom: 3px solid var(--cor-primaria);
  }
}
.content{
  width: 80%;
  margin: 0 auto;

  .page-header-options{
    display: flex;
    justify-content: space-between;

    /*.button-add{
      background: none;
      border: none;
      color: var(--cor-primaria);
    }*/
  }

  .content-ingredient{
    display: grid;
    grid-template-columns: 1fr 1fr;
  }
}

</style>