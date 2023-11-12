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
            products: [],
            showModal: false,
            id: null,
        };
    },
    methods: {
        openEditModal(productId) {
            this.id = productId;
            this.showModal = true;
        },
        closeModal() {
            this.id = null;
            this.showModal = false;
        },
        async fetchProducts() {
            try {
                const { data } = await this.$http.get("/products");
                this.products = data;

                console.log(this.products)
            } catch (error) {
                console.error(error);
            }
        },
    },
    mounted() {
        this.fetchProducts();
    },
}
</script>

<template>
    <div>
        <div class="page-header-options">
            <h2 class="title">Produtos</h2>
            <base-button isTransparent color="dark-green" @onClick="showModal = true"> Adicionar </base-button>
        </div>
        <div class="content-menu">
            <BasePizzaCard 
                v-for="product in products" 
                :key="product.id" 
                :id="product.id"
                :image="product.image" 
                :name="product.name"
                :value="product.value" 
                :active="product.active" 
                @edit="openEditModal(product.id)"
            />
        </div>
    </div>

    <AddProductModal v-if="showModal" :id="id" @close="closeModal" @limitSave="fetchProducts" />
</template>

<style scoped lang="scss">
.content-menu {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 25px;

    @media screen and (max-width: 425px) {
        grid-template-columns: 1fr;
    }
}
</style>