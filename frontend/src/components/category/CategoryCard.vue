<script>
import BaseCard from '@/components/generics/BaseCard.vue';
import CategoryEditModal from './CategoryEditModal.vue';
import Swal from 'sweetalert2';

export default {
  components: {
    BaseCard,
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
      this.$http.get('/category/all')
        .then(response => {
          this.categories = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    addCategory(newCategory) {
      this.categories.push(newCategory);
    },
    async deleteCategory(categoryId) {
      const confirmed = await Swal.fire({
        title: 'Tem certeza que deseja excluir?',
        showCancelButton: true,
        confirmButtonColor: 'var(--cor-secundaria)',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir',
        reverseButtons: true
      });

      if (confirmed.isConfirmed) {
        try {
          const response = await axios.delete(`/category`, { data: { id: categoryId } });
          if (response.status === 200) {
            await this.fetchCategories();

            Swal.fire(
              'Categoria excluída!',
              'Sua categoria foi excluída com sucesso.',
              'success'
            );
          }
        } catch (error) {
          console.error(error);
          Swal.fire(
            'Erro!',
            'Ocorreu um erro ao excluir a categoria.',
            'error'
          );
        }
      }
    },
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
      <img src="../../assets/icons/exit.png" @click="deleteCategory(category.id)">
    </div>
    <p class="item">{{ category.name }}</p>
  </BaseCard>
  <CategoryEditModal v-if="showEditModal" :category="categoriaParaEditar" @close="closeModal"
    @categoria-atualizada="handleUpdateCategory"></CategoryEditModal>
</template>