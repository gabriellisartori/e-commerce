<script>
import { toast } from 'vue3-toastify';
import IngredientModal from '@/components/ingredients/IngredientModal.vue';

export default {
  components: {
    IngredientModal
  },
  data() {
    return {
      ingredients: [],
      showModal: false,
      id: null
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
        const { data } = await this.$http.get('/ingredients');
        this.ingredients = data;
      } catch (error) {
        console.error(error);
      }
    },
    async deleteIngredient(ingredientId) {
      const confirmed = await this.$swal.fire({
        title: 'Tem certeza que deseja excluir?',
        showCancelButton: true,
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
  },
  mounted() {
    this.fetchIngredients();
  }
}
</script>

<template>
    <div>
      <div class="page-header-options">
        <h3 class="title">INGREDIENTES</h3>
        <base-button isTransparent color="dark-green" @onClick="showModal = true"> Adicionar </base-button>
    </div>
    
    <div class="content-ingredient">
      <base-card
        v-for="ingredient in ingredients"
        :key="ingredient.id"
        :title="ingredient.name"
        @edit="openEditModal(ingredient.id)"
        @delete="deleteIngredient(ingredient.id)"
      />
    </div>
    </div>
   
    <IngredientModal
      v-if="showModal"
      :id="id"
      @close="closeModal"
      @ingredientSave="fetchIngredients"
    />

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

  }

  .content-ingredient{
    display: grid;
    grid-template-columns: 2fr 1fr;
    width: 90%;
    margin: 0 auto;
  }
}

</style>