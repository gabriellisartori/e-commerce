<script>
export default {
    data() {
        return {
            products: [],
            productsWithPromotion: [],
            id: null,
            selectedPizza: null,
            selectedPizzaCount: 0,
            hasProductsPromotion: false,
        };
    },
    computed: {
        shouldShowBottomBar() {
            const shouldShow = window.innerWidth <= 425;
            console.log('shouldShowBottomBar:', shouldShow);
            return shouldShow;
        },
    },
    methods: {
        async fetchProducts() {
            try {
                const { data } = await this.$http.get("/products");
                this.products = data;

                console.log(this.products)
                this.fetchProductsWithPromotion();

            } catch (error) {
                console.error(error);
            }
        },
        fetchProductsWithPromotion() {
            if (this.products) {
                this.productsWithPromotion = this.products.filter(product => {
                    const hasPromotion = product.promotion && Array.isArray(product.promotion) && product.promotion.length > 0;

                    return hasPromotion;
                });
                this.hasProductsPromotion = this.productsWithPromotion.length > 0;
                console.log(this.productsWithPromotion)

            } else {
                console.log("A lista de todos os produtos não está definida.");
            }
        },
        selectPizza(pizzaPart) {
            this.selectedPizza = pizzaPart;
            this.selectedPizzaCount++;
        },
        goToCarrinho() {
            this.$router.push({ name: 'ShoppingPage' });
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
            <h2 class="title">SELECIONE SUA PIZZA</h2>
        </div>
        <div class="content-menu">
            <div class="pizza-type">
                <div @click="selectPizza('whole')" :class="{ 'selected': selectedPizza === 'whole' }">
                    <img src="../../assets/pizza-inteira.png">
                </div>
                <div @click="selectPizza('half')" :class="{ 'selected': selectedPizza === 'half' }">
                    <img src="../../assets/meia-pizza.png">
                </div>
            </div>
            <div class="menu">
                <base-speciale v-if="hasProductsPromotion" :key="hasProductsPromotion.id"
                    :image="productsWithPromotion[0].image" :name="productsWithPromotion[0].name"
                    :value="productsWithPromotion[0].value" :ingredients="productsWithPromotion[0].ingredients"
                    :promotion="productsWithPromotion[0].promotion" />
                <base-pizza-card-client v-for="product in products" :key="product.id" :image="product.image"
                    :name="product.name" :value="product.value" :pizzaDetails="product" @activate-checkbox="selectPizza"
                    :disabled="!selectedPizza" />
            </div>
        </div>

        <div class="bottom-bar" v-if="shouldShowBottomBar && selectedPizza" @click="goToCarrinho">
            <p class="text-uppercase">{{ selectedPizzaCount }}x Ver carrinho</p>
        </div>
    </div>
</template>

<style scoped lang="scss">
.pizza-type {
    display: flex;
    justify-content: center;

    div {
        display: flex;
        align-items: center;
        cursor: pointer;
        border-radius: 16px;
        width: 18%;
        height: 18%;
        transition: background-color 0.3s;

        &.selected {
            background-color: var(--cor-primaria);
        }

        img {
            width: 70%;
            margin: auto;
        }

        @media screen and (max-width: 425px) {
            width: 45%;
        }
    }
}

.menu {
    display: grid;
    width: 85%;
    margin: 0 auto;
    grid-template-columns: 1fr 1fr;
    gap: 40px 80px;
    padding-bottom: 50px;
    margin-top: 18px;

    @media screen and (max-width: 768px) {

        &:first-child {
            grid-template-columns: 1fr;
        }

        grid-template-columns: 1fr 1fr;
    }

    @media screen and (max-width: 425px) {
        grid-template-columns: 1fr;
    }
}

.bottom-bar {
    position: fixed;
    bottom: 25px;
    left: 0;
    width: 100%;
    background-color: var(--cor-primaria);
    color: #fff;
    padding: 10px;
    text-align: center;
    height: 5%;
    font-weight: 700;
}
</style>