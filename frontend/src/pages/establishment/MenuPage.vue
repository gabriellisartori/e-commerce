<script>
import BasePizzaCard from '@/components/generics/BasePizzaCard.vue';
import AddProductModal from '@/components/product/AddProductModal.vue';
import FiltersModal from '@/components/FiltersModal.vue';

export default {
    components: {
        BasePizzaCard,
        AddProductModal,
        FiltersModal
    },
    data() {
        return {
            products: [],
            showModal: false,
            id: null,
            search: {
              name: null
            },
            showFilters: false
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
                const { data } = await this.$http.get("/products", {
                    params: this.search
                });
                this.products = data;

                console.log(this.products)
            } catch (error) {
                console.error(error);
            }
        },
        searchFilter (event) {
            this.search.name = event
            this.fetchProducts()
        },
        getAll () {
          this.search.name = null
          this.fetchProducts()
        },
        async exportFile () {
            const { data } = await this.$http.get('/products/exportFile', { params: this.search }, {
              responseType: 'blob'
            });
            const url = window.URL.createObjectURL(new Blob([data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'produtos.xlsx');
            document.body.appendChild(link);
            link.click();
        }
    },
    mounted() {
        this.fetchProducts();
    },
}
</script>

<template>
    <div>
        <div class="page-header-options">
            <div>
                <h2 class="title">Produtos</h2>
            </div>
            <div>
                <base-button isTransparent color="dark-green" @onClick="showModal = true"> Adicionar </base-button>
                <base-button class="icon" isTransparent isIcon icon="fa-solid fa-magnifying-glass" color="dark-green" @onClick="showFilters = true"/>
                <base-button class="icon" isTransparent isIcon icon="fa-solid fa-file-excel" color="dark-green" @click="exportFile()"/>
                <base-button class="icon" isTransparent isIcon icon="fa-solid fa-rotate" color="dark-green" @onClick="getAll"/>
            </div>
        </div>
        <div class="content-menu">
            <BasePizzaCard 
                v-for="product in products" 
                :key="product.id" 
                :id="product.id"
                :image="product.image" 
                :name="product.name"
                :value="product.value" 
                :category_id="product.category_id"
                :active="product.active" 
                :cardId="product.id"
                @edit="openEditModal(product.id)"
            />
        </div>
    </div>

    <AddProductModal v-if="showModal" :id="id" @close="closeModal" @limitSave="fetchProducts" />

    <FiltersModal 
        v-if="showFilters"
        isName
        @close="showFilters = false"
        @getValues="searchFilter($event)"
    />
</template>

<style scoped lang="scss">
.content-menu {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 25px;
    padding-bottom: 35px;

    @media screen and (max-width: 425px) {
        grid-template-columns: 1fr;
    }
}
</style>