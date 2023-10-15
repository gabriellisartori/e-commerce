<script>
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import CategoryModal from '@/components/category/CategoryModal.vue';

export default {
  components: {
    CategoryModal
  },
  data() {
    return {
      categories: [],
      showModal: false,
      id: null
    };
  },
  methods: {
    openEditModal(categoryId) {
      this.id = categoryId;
      this.showModal = true;
    },
    closeModal() {
      this.id = null;
      this.showModal = false;
    },
    async fetchCategories() {
      try {
        const { data } = await this.$http.get('/categories');
        this.categories = data;
      } catch (error) {
        console.error(error);
      }
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
          await this.$http.delete(`/categories/${categoryId}`);
          this.fetchCategories();

          toast.success("Categoria excluída!", {
            position: toast.POSITION.BOTTOM_LEFT,
          });
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
  <div class="content">
    <div class="page-header-options">
      <h2 class="title">CATEGORIAS</h2>
      <base-button isTransparent color="dark-green" @onClick="showModal = true"> Adicionar </base-button>
    </div>

    <div class="content-category">
      <base-card
        v-for="category in categories"
        :key="category.id"
        :title="category.name"
        @edit="openEditModal(category.id)"
        @delete="deleteCategory(category.id)"
      />
    </div>
  </div>

  <CategoryModal
    v-if="showModal"
    :id="id"
    @close="closeModal"
    @categorySave="fetchCategories"
  />

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