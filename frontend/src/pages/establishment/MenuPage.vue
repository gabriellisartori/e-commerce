<script>
import BasePizzaCard from '@/components/generics/BasePizzaCard.vue';
import AddProductModal from '@/components/product/AddProductModal.vue';

export default {
    components: {
        BasePizzaCard,
        AddProductModal
    },
    data() {
        return {
            pizza: {
                image: '../../assets/pizza-home.png',
                name: 'Pizza Margherita',
                value: 'R$60,00',
                isAvailable: true,
                showModal: false,

            }
        };
    },
}
</script>

<template>
    <div class="content">
        <div class="page-header-options">
            <h2 class="title">PRODUTOS</h2>
            <base-button isTransparent color="dark-green" @onClick="showModal = true"> Adicionar </base-button>
        </div>
        <div class="content-menu">
            <BasePizzaCard :image="pizza.image" :name="pizza.name" :value="pizza.value" :switchValue="pizza.isAvailable" />
        </div>
    </div>

   <AddProductModal v-if="showModal"></AddProductModal>
   
</template>

<style lang="scss">
.content-menu {
    display: grid;
    grid-template-columns: 1fr 1fr;
}
</style>