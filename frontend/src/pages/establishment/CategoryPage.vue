<script>
import PageHeaderEstablishment from '@/components/pageHeaders/PageHeaderEstablishment.vue';
import AddCategoryModal from '@/components/category/AddCategoryModal.vue'
import CategoryCard from '@/components/category/CategoryCard.vue';

export default {
  components: {
    PageHeaderEstablishment,
    AddCategoryModal,
    CategoryCard
  },
  data() {
    return {
      showModal: false,
      categories: [],
    };
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    handleCategoryAdded(newCategory) {
      this.$refs.categoryCard.addCategory(newCategory);
    },
  }
};
</script>

<template>
  <PageHeaderEstablishment></PageHeaderEstablishment>
  <div class="content">
    <div class="page-header-options">
      <h2 class="title">CATEGORIAS</h2>
      <button class="button-add" @click="openModal">
        Adicionar
      </button>
    </div>

    <div class="content-category">
      <CategoryCard ref="categoryCard"></CategoryCard>
    </div>
  </div>

  <AddCategoryModal v-if="showModal" @close="closeModal" @categoryAdded="handleCategoryAdded"></AddCategoryModal>
</template>

<style lang="scss">
.content {


  .page-header-options {

    .button-add {
      background-color: transparent;
      color: var(--cor-secundaria);
      font-weight: 700;
      border: none;
      font-size: 16px;
      cursor: pointer;
    }
  }

  .content-category {
    display: grid;
    grid-template-columns: 1fr 1fr;
  }

}
</style>