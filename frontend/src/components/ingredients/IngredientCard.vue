<script>
import BaseCard from '@/components/generics/BaseCard.vue'
import IngredientModalDelete from '@/components/ingredients/IngredientModalDelete.vue'

export default {
  components: {
    BaseCard,
    IngredientModalDelete,
  },
  data() {
    return {
        showDeleteModal: false 
    };
  },
  methods: {
    openModal() {
      this.showDeleteModal = true;
    },
    closeModal() {
      this.showDeleteModal = false;
    }
  }
}
</script>

<template>
    <BaseCard>
        <div class="icons">
            <img src="../../assets/icons/edit.png">
            <img src="../../assets/icons/exit.png" @click="openModal">
        </div>
        <p class="item">Tomate</p>
    </BaseCard>

    <IngredientModalDelete v-if="showDeleteModal" @close="closeModal"></IngredientModalDelete>
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