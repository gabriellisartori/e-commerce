<script>
import { toast } from 'vue3-toastify';
import CategoryModal from '@/components/category/CategoryModal.vue';
import FiltersModal from '@/components/FiltersModal.vue';

export default {
  components: {
    CategoryModal,
    FiltersModal
  },
  data() {
    return {
      categories: [],
      showModal: false,
      id: null,
      search: {
        name: null
      },
      showFilters: false
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
        const { data } = await this.$http.get('/categories', {
          params: this.search
        });
        this.categories = data;
      } catch (error) {
        console.error(error);
      }
    },
    async deleteCategory(categoryId) {
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
          await this.$http.delete(`/categories/${categoryId}`);
          this.fetchCategories();

          toast.success("Categoria excluída!", {
            position: toast.POSITION.BOTTOM_LEFT,
          });
        } catch (error) {
          console.error(error);
          this.$swal.fire(
            'Erro!',
            'Ocorreu um erro ao excluir a categoria.',
            'error'
          );
        }
      }
    },
    searchFilter (event) {
      this.search.name = event
      this.fetchCategories()
    },
    getAll () {
      this.search.name = null
      this.fetchCategories()
    }
  },
  mounted() {
    this.fetchCategories();
  }
}
</script>

<template>
  <div>
    <div class="page-header-options">
      <div>
        <h2 class="title">Categorias</h2>
      </div>
      <div>
        <base-button isTransparent color="dark-green" @onClick="showModal = true"> Adicionar </base-button>
        <base-button class="icon" isTransparent isIcon icon="fa-solid fa-magnifying-glass" color="dark-green" @onClick="showFilters = true"/>
        <base-button class="icon" isTransparent isIcon icon="fa-solid fa-rotate" color="dark-green" @onClick="getAll"/>
      </div>
    </div>

    <div class="content-category">
      <base-card v-for="category in categories" :key="category.id" :title="category.name"
        @edit="openEditModal(category.id)" @delete="deleteCategory(category.id)" />
    </div>
  </div>

  <CategoryModal v-if="showModal" :id="id" @close="closeModal" @categorySave="fetchCategories" />

  <FiltersModal 
    v-if="showFilters"
    isName
    @close="showFilters = false"
    @getValues="searchFilter($event)"
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
    gap: 50px;
    width: 90%;
    margin: 0 auto;

    @media screen and (max-width: 768px) {
      grid-template-columns: 1fr;
      gap: 0px;
    }
  }

}
</style>