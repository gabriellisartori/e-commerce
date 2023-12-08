<script>
import { toast } from 'vue3-toastify';
import IngredientModal from '@/components/ingredients/IngredientModal.vue';
import FiltersModal from '@/components/FiltersModal.vue';

export default {
  components: {
    IngredientModal,
    FiltersModal
  },
  data() {
    return {
      ingredients: [],
      showModal: false,
      id: null,
      search: {
        name: null
      },
      showFilters: false
    };
  },
  methods: {
    openEditModal(ingredientId) {
      this.id = ingredientId;
      this.showModal = true;
    },
    closeModal() {
      this.id = null;
      this.showModal = false;
    },
    async fetchIngredients() {
      try {
        const { data } = await this.$http.get('/ingredients', {
          params: this.search
        });
        this.ingredients = data;
      } catch (error) {
        console.error(error);
      }
    },
    async deleteIngredient(ingredientId) {
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
          await this.$http.delete(`/ingredients/${ingredientId}`);
          this.fetchIngredients();

          toast.success("Ingrediente excluído!", {
            position: toast.POSITION.BOTTOM_LEFT,
          });
        } catch (error) {
          console.error(error);
          this.$swal.fire(
            'Erro!',
            'Ocorreu um erro ao excluir o ingrediente.',
            'error'
          );
        }
      }
    },
    searchFilter (event) {
      this.search.name = event
      this.fetchIngredients()
    },
    getAll () {
      this.search.name = null
      this.fetchIngredients()
    },
    async exportFile () {
      const { data } = await this.$http.get('/ingredients/exportFile', { params: this.search }, {
        responseType: 'blob'
      });
      const url = window.URL.createObjectURL(new Blob([data]));
      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'ingredientes.xlsx');
      document.body.appendChild(link);
      link.click();
    }
  },
  mounted() {
    this.fetchIngredients();
  }
}
</script>

<template>
  <div>
    <div class="page-header-options">
      <div>
        <h2 class="title">Ingredientes</h2>
      </div>
      <div>
        <base-button isTransparent color="dark-green" @onClick="showModal = true"> Adicionar </base-button>
        <base-button class="icon" isTransparent isIcon icon="fa-solid fa-magnifying-glass" color="dark-green" @onClick="showFilters = true"/>
        <base-button class="icon" isTransparent isIcon icon="fa-solid fa-file-excel" color="dark-green" @click="exportFile()"/>
        <base-button class="icon" isTransparent isIcon icon="fa-solid fa-rotate" color="dark-green" @onClick="getAll"/>
      </div>
    </div>

    <div class="content-ingredient">
      <base-card v-for="ingredient in ingredients" :key="ingredient.id" :title="ingredient.name"
        @edit="openEditModal(ingredient.id)" @delete="deleteIngredient(ingredient.id)" />
    </div>
  </div>

  <IngredientModal v-if="showModal" :id="id" @close="closeModal" @ingredientSave="fetchIngredients" />

  <FiltersModal 
    v-if="showFilters"
    isName
    @close="showFilters = false"
    @getValues="searchFilter($event)"
  />
</template>

<style lang="scss">
.menu-home {
  .settings {
    border-bottom: 3px solid var(--cor-primaria);
  }
}

.content {
  width: 80%;
  margin: 0 auto;

  .page-header-options {
    display: flex;
    justify-content: space-between;

    .icon {
      margin-left: 10px;
    }

  }

  .content-ingredient {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px 50px;
    width: 90%;
    margin: 0 auto;

    @media screen and (max-width: 768px) {
      grid-template-columns: 1fr;
      gap: 0px;
    }
  }
}
</style>