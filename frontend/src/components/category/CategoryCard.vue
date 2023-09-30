<script>
import axios from '@/axios';
import BaseCard from '@/components/generics/BaseCard.vue';
import CategoryDeleteModal from './CategoryDeleteModal.vue';
import CategoryEditModal from './CategoryEditModal.vue';

export default {
  components: {
    BaseCard,
    CategoryDeleteModal,
    CategoryEditModal
  },
  data() {
    return {
      showDeleteModal: false,
      showEditModal: false,
      categoriaParaExcluir: null,
      categoriaParaEditar: null,
      categories: []
    };
  },
  methods: {
    openModal(category) {
      this.categoriaParaExcluir = category;
      console.log(this.categoriaParaExcluir)
      this.showDeleteModal = true;
    },
    openEditModal(category) {
      this.categoriaParaEditar = category;
      this.showEditModal = true;
    },
    closeModal() {
      this.showDeleteModal = false;
      this.showEditModal = false; 
    },
    handleUpdateCategory(updatedCategory) {
      this.categories = this.categories.map(category => {
        if (category.id === updatedCategory.id) {
          return updatedCategory;
        }
        return category;
      });
    },
    fetchCategories() {
      axios.get('/category/all')
        .then(response => {
          this.categories = response.data; 
        })
        .catch(error => {
          console.error(error);
        });
    }
  },
  mounted() {
    this.fetchCategories();
  }
}
</script>


<template>
    <BaseCard v-for="category in categories" :key="category.id">
      <div class="icons">
        <img src="../../assets/icons/edit.png" @click="openEditModal(category)">
        <img src="../../assets/icons/exit.png" @click="openModal(category.id)">
      </div>
      <p class="item">{{ category.name }}</p>
    </BaseCard>

    <CategoryDeleteModal v-if="showDeleteModal" :categoriaId="categoriaParaExcluir" @close="closeModal"></CategoryDeleteModal>
    <CategoryEditModal v-if="showEditModal" :category="categoriaParaEditar" @close="closeModal" @categoria-atualizada="handleUpdateCategory"></CategoryEditModal>
</template>