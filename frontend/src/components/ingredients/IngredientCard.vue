<script>
import axios from '@/axios';
import BaseCard from '@/components/generics/BaseCard.vue';
import Swal from 'sweetalert2';
import IngredientEditModal from './IngredientEditModal.vue';

export default {
  components: {
    BaseCard,
    IngredientEditModal
},
  data() {
    return {
        showDeleteModal: false,
        showEditModal: false,
        ingredienteParaEditar: null,
        ingredients: []
    };
  },
  methods: {
    openModal() {
      this.showDeleteModal = true;
    },
    openEditModal(ingredient) {
      this.ingredienteParaEditar = ingredient;

      console.log(this.ingredienteParaEditar)
      this.showEditModal = true;
    },
    closeModal() {
      this.showDeleteModal = false;
      this.showEditModal = false;
    },
    handleUpdateIngredient(updatedIngredient) {
      this.ingredients = this.ingredients.map(ingredient => {
        if (ingredient.id === updatedIngredient.id) {
          return updatedIngredient;
        }
        return ingredient;
      });
    },
    fetchIngredients() {
      axios.get('/ingredient/all')
        .then(response => {
          this.ingredients = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    addIngredient(newIngredient) {
      this.ingredients.push(newIngredient);
    },
    async deleteIngredient(ingredientId) {
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
          const response = await axios.delete(`/ingredient`, { data: { id: ingredientId } });
          if (response.status === 200) {
            await this.fetchIngredients();

            Swal.fire(
              'Ingrediente excluído!',
              'Seu ingrediente foi excluído com sucesso.',
              'success'
            );
          }
        } catch (error) {
          console.error(error);
          Swal.fire(
            'Erro!',
            'Ocorreu um erro ao excluir ingrediente.',
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
    <BaseCard v-for="ingredient in ingredients" :key="ingredient.id">
        <div class="icons">
            <img src="../../assets/icons/edit.png" @click="openEditModal(ingredient)">
            <img src="../../assets/icons/exit.png" @click="deleteIngredient(ingredient.id)">
        </div>
        <p class="item">{{ ingredient.name }}</p>
    </BaseCard>
<IngredientEditModal v-if="showEditModal" :ingredient="ingredienteParaEditar" @close="closeModal" @ingrediente-atualizado="handleUpdateIngredient"></IngredientEditModal>
</template>

<style lang="scss">
.icons{
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin: 10px;
    cursor: pointer;

    img{
        width: 4%;
        height: 4%;
        margin-right: 10px;
    }
}
.item{
    text-align: start;
    font-weight: 700;
    margin-left: 30px;
    font-size: 20px;
}
</style>