<script>
import { toast } from "vue3-toastify";

export default {
    data() {
        return {
            products: [],
            productsWithPromotion: [],
            id: null,
            selectedPizza: null,
            selectedPizzaCount: 0,
            hasProductsPromotion: false,
            selectedPizzaType: null,
            shouldShowAddToCartButton: false,
            selectedHalfPizzas: [],
            pizzaInCart: false,
            showAddToCartButton: false,
            disableOtherElements: false,
        };
    },
    computed: {
        shouldShowBottomBar() {
            const shouldShow = window.innerWidth <= 425;
            return shouldShow;
        },
    },
    methods: {
        async fetchProducts() {
            try {
                const { data } = await this.$http.get("/products");
                this.products = data;
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

            } else {
                console.log("A lista de todos os produtos não está definida.");
            }
        },
        selectPizzaType(pizzaType) {
            if (this.selectedPizzaType !== pizzaType) {
                this.selectedPizzaType = pizzaType;
            } else {
                this.selectedPizzaType = pizzaType === 'whole' ? 'half' : 'whole';
            }
        },
        selectPizza(pizzaPart) {
            if (!this.selectedPizzaType) {
                this.showPizzaTypeAlert = true;
                return;
            }

            if (this.selectedPizzaType === 'whole') {
                if (this.selectedPizza === pizzaPart) {
                    this.selectedPizza = null;
                    this.shouldShowAddToCartButton = false;
                    this.selectedPizzaCount--;
                } else {
                    this.selectedPizza = pizzaPart;
                    this.shouldShowAddToCartButton = true;
                    this.selectedPizzaCount++;
                }
            } else if (this.selectedPizzaType === 'half') {
                const index = this.selectedHalfPizzas.findIndex((pizza) => pizza.name === pizzaPart.name);

                if (index === -1) {
                    this.selectedHalfPizzas.push(pizzaPart);
                } else {
                    this.selectedHalfPizzas.splice(index, 1);
                }

                this.shouldShowAddToCartButton = this.selectedHalfPizzas.length === 2;
                this.selectedPizzaCount = this.selectedHalfPizzas.length;
            }

            // Adiciona controle de visibilidade e opacidade
            this.showAddToCartButton = this.shouldShowAddToCartButton;
            this.disableOtherElements = this.showAddToCartButton;
        },
        resetPizzaSelection() {
            this.selectedPizzas = [];
            this.showAddToCartButton = false;
            this.disableOtherElements = false;
        },
        addToCart() {
            this.showAddToCartButton = false;
            this.$emit('pizzaAdicionadaAoCarrinho'); 

            if ((this.selectedPizzaType === 'half' && this.selectedHalfPizzas.length !== 2) ||
                (this.selectedPizzaType === 'whole' && !this.selectedPizza)) {
                return;
            }

            const storedPizzas = JSON.parse(localStorage.getItem('selectedPizza')) || [];

            if (this.selectedPizzaType === 'whole') {
                const pizzaToAdd = {
                    id: this.selectedPizza.id,
                    name: this.selectedPizza.name,
                    quantity: 1,
                    value: this.selectedPizza.value,
                    half_pizza: false,
                    half_pizza_product_id: null,
                    additional: this.selectedPizza.additional || [],
                    ingredients: this.selectedPizza.ingredients || [],
                };

                storedPizzas.push(pizzaToAdd);
            } else if (this.selectedPizzaType === 'half') {
                const maxPricePizza = this.selectedHalfPizzas.reduce((maxPizza, pizza) => (pizza.value > maxPizza.value ? pizza : maxPizza), this.selectedHalfPizzas[0]);

                const pizzaToAdd = {
                    id: maxPricePizza.id,
                    name: this.selectedHalfPizzas.map(pizza => pizza.name).join(' e '),
                    quantity: 1,
                    value: parseFloat(maxPricePizza.value).toFixed(2),
                    half_pizza: true,
                    half_pizza_product_id: null,
                    additional: maxPricePizza.additional || [],
                    ingredients: maxPricePizza.ingredients || [],
                };

                storedPizzas.push(pizzaToAdd);
            }

            localStorage.setItem('selectedPizza', JSON.stringify(storedPizzas));

            this.pizzaInCart = true;
            this.resetPizzaSelection();
            this.shouldShowAddToCartButton = false;
            this.disableOtherElements = true;

            toast.success("Produto adicionado ao carrinho!", {
                position: toast.POSITION.BOTTOM_LEFT,
            });
        },
        goToCarrinho() {
            this.$router.push({ name: 'ShoppingPage' });
        },
        addToLocalStorage(pizza) {
            const storedPizzas = JSON.parse(localStorage.getItem('selectedPizzas')) || [];
            storedPizzas.push(pizza);
            localStorage.setItem('selectedPizzas', JSON.stringify(storedPizzas));
        },
        clearLocalStorage() {
            localStorage.clear();
        },
    },
    mounted() {
        this.fetchProducts();
        this.selectedPizzaType = 'whole';

        window.addEventListener('beforeunload', this.clearLocalStorage);

        this.selectedPizzas = JSON.parse(localStorage.getItem('selectedPizzas')) || [];

    },
    beforeUnmount() {
        window.removeEventListener('beforeunload', this.clearLocalStorage);
    },

}
</script>

<template>
    <div>
        <div class="page-header-options">
            <h2 class="title">Selecione sua pizza</h2>
        </div>
        <div class="content-menu">
            <div class="pizza-type">
                <div ref="wholePizzaType" @click="selectPizzaType('whole')"
                    :class="{ 'selected': selectedPizzaType === 'whole' }">
                    <img src="../../assets/pizza-inteira.png">
                </div>
                <div ref="halfPizzaType" @click="selectPizzaType('half')"
                    :class="{ 'selected': selectedPizzaType === 'half' }">
                    <img src="../../assets/meia-pizza.png">
                </div>
            </div>
            <button v-if="shouldShowAddToCartButton" class="add-cart" @click="addToCart">Adicionar ao Carrinho</button>


            <div class="bottom-bar" v-if="shouldShowBottomBar && selectedPizza">
                <p class="text-uppercase" @click="goToCarrinho">{{ selectedPizzaCount }}x Ver carrinho</p>
            </div>

            <div class="menu" :class="{ 'opacity-low': showAddToCartButton }">
                <base-speciale class="header" v-if="hasProductsPromotion" :key="hasProductsPromotion.id"
                    :image="productsWithPromotion[0].image" :name="productsWithPromotion[0].name"
                    :value="productsWithPromotion[0].value" :ingredients="productsWithPromotion[0].ingredients"
                    :promotion="productsWithPromotion[0].promotion" />

                <base-pizza-card-client ref="pizzaCards" class="content" v-for="product in products" :key="product.id"
                    :image="product.image" :value="product.value" :pizzaDetails="product" @activate-checkbox="selectPizza"
                    :pizzaInCart="product.pizzaInCart" />

            </div>
        </div>

        <div class="bottom-bar" v-if="shouldShowBottomBar && selectedPizza" @click="goToCarrinho">
            <p class="text-uppercase">{{ selectedPizzaCount }}x Ver carrinho</p>
        </div>
    </div>
</template>

<style scoped lang="scss">
.title {
    font-family: "Sabatons";
    font-size: 2rem;
    margin-bottom: 2rem;

    @font-face {
        font-family: "Sabatons";
        src: local("Sabatons Sans Stamp"), local("Sabatons-Sans-Stamp"),
            url("../../assets/fonts/sabatons/Sabatons-Stamp.woff2") format("woff2"),
            url("../../assets/fonts/sabatons/Sabatons-Stamp.woff") format("woff"),
            url("../../assets/fonts/sabatons/Sabatons-Stamp.ttf") format("truetype");
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }
}

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
    grid-template-areas: "header" "content";

    @media screen and (max-width: 768px) {
        grid-template-columns: 1fr;
    }

    @media screen and (max-width: 425px) {
        grid-template-columns: 1fr;
    }

    &.opacity-low {
        opacity: 0.5;
        /* ajuste o valor conforme necessário */
        pointer-events: none;
        /* impede a interação com elementos subjacentes */
    }
}

.add-cart {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 40%;
    background-color: var(--cor-secundaria);
    height: 50px;
    text-transform: uppercase;
    border: none;
    border-radius: 16px;
    color: var(--cor-site);
    z-index: 5;
    font-weight: 700;
    cursor: pointer;
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
    align-items: center;
    display: flex;
    justify-content: center;
}
</style>