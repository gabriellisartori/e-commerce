<script>
import { toast } from "vue3-toastify";
import DetailsOrderModal from '@/components/orders/DetailsOrderModal.vue';

export default {
    components: {
        DetailsOrderModal
    },
    data() {
        return {
            showModal: false,
            products: [],
            id: null,
            selectedPizza: null,
            selectedPizzaCount: 0,
            selectedPizzaType: null,
            shouldShowAddToCartButton: false,
            selectedHalfPizzas: [],
            promotionPizza: [],
            pizzaInCart: false,
            showAddToCartButton: false,
            disableOtherElements: false,
            showAdditionalSwitch: false,
            showAdditionalInfo: false,
            resetCheckboxEvent: false,
        };
    },
    computed: {
        shouldShowBottomBar() {
            const shouldShow = window.innerWidth <= 425;
            return shouldShow;
        },
    },
    methods: {
        closeModal() {
            this.id = null;
            this.showModal = false;
        },
        async fetchProducts() {
            try {
                const { data } = await this.$http.get("/products");
                this.products = data;
                this.getPromotionPizza();

            } catch (error) {
                console.error(error);
            }
        },
        async getPromotionPizza() {
            const { data } = await this.$http.get('promotionPizza');
            this.promotionPizza = data
        },
        selectPizzaType(pizzaType) {
            if (this.selectedPizzaType !== pizzaType) {
                this.selectedPizzaType = pizzaType;
            } else {
                this.selectedPizzaType = pizzaType === 'whole' ? 'half' : 'whole';
            }
        },
        handleAdditionalSwitch(value) {
            this.showAdditionalSwitch = value;
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

            const pizzaWithAdditional = this.products.find(
                (product) => product.name === pizzaPart.name && product.additional
            );

            // Se tiver adicional, abre a modal
            if (this.shouldShowAddToCartButton && pizzaWithAdditional) {
                this.showModal = true;
                this.selectedPizzaWithAdditional = pizzaWithAdditional;
                this.shouldShowAddToCartButton = false;
            }
        },
        addToCart(data) {
            this.showAddToCartButton = false;
            this.resetCheckboxEvent = !this.resetCheckboxEvent;
            this.$emit('pizzaAdicionadaAoCarrinho');

            if ((this.selectedPizzaType === 'half' && this.selectedHalfPizzas.length !== 2) ||
                (this.selectedPizzaType === 'whole' && !this.selectedPizza)) {
                return;
            }

            const storedPizzas = JSON.parse(localStorage.getItem('selectedPizza')) || [];

            if (data && data.pizzaDetails) {
                const { pizzaDetails, showAdditionalSwitch } = data;
                if (this.selectedPizzaType === 'whole') {
                    const pizzaToAdd = {
                        pizza: {
                            id: pizzaDetails.id,
                            name: pizzaDetails.name,
                            quantity: 1,
                            value: pizzaDetails.value,
                            half_pizza: false,
                            half_pizza_product_id: null,
                            additional: pizzaDetails.additional || [],
                            ingredients: pizzaDetails.ingredients || [],
                        },
                        showAdditionalInfo: showAdditionalSwitch,
                    };
                    storedPizzas.push(pizzaToAdd);

                } else if (this.selectedPizzaType === 'half') {
                    const maxPricePizza = this.selectedHalfPizzas.reduce((maxPizza, pizza) => (pizza.value > maxPizza.value ? pizza : maxPizza), this.selectedHalfPizzas[0]);
                    const firstPizzaId = this.selectedHalfPizzas.length > 0 ? this.selectedHalfPizzas[0].id : null;

                    if (this.showAdditionalSwitch) {
                        this.showAdditionalInfo = true;
                    }

                    const pizzaToAdd = {
                        pizza: {
                            id: maxPricePizza.id,
                            name: this.selectedHalfPizzas.map(pizza => pizza.name).join(' e '),
                            quantity: 1,
                            value: parseFloat(maxPricePizza.value).toFixed(2),
                            half_pizza: true,
                            half_pizza_product_id: firstPizzaId,
                            additional: maxPricePizza.additional || [],
                            ingredients: maxPricePizza.ingredients || [],
                        },
                        showAdditionalInfo: this.showAdditionalSwitch,
                    };
                    storedPizzas.push(pizzaToAdd);
                }

            } else {
                if (this.selectedPizzaType === 'whole') {
                    let pizzasToAdd = [];

                    if (Array.isArray(this.selectedPizza)) {
                        pizzasToAdd = this.selectedPizza.map(pizza => ({
                            pizza: {
                                id: pizza.id,
                                name: pizza.name,
                                quantity: 1,
                                value: pizza.value,
                                half_pizza: false,
                                half_pizza_product_id: null,
                                additional: pizza.additional || [],
                                ingredients: pizza.ingredients || [],
                            },
                            showAdditionalInfo: this.showAdditionalSwitch,
                        }));

                    } else {
                        const pizzaToAdd = {
                            pizza: {
                                id: this.selectedPizza.id,
                                name: this.selectedPizza.name,
                                quantity: 1,
                                value: this.selectedPizza.value,
                                half_pizza: false,
                                half_pizza_product_id: null,
                                additional: this.selectedPizza.additional || [],
                                ingredients: this.selectedPizza.ingredients || [],
                            },
                            showAdditionalInfo: this.showAdditionalSwitch,
                        };
                        pizzasToAdd.push(pizzaToAdd);
                    }

                    storedPizzas.push(...pizzasToAdd);
                } else if (this.selectedPizzaType === 'half') {
                    const maxPricePizza = this.selectedHalfPizzas.reduce((maxPizza, pizza) => (pizza.value > maxPizza.value ? pizza : maxPizza), this.selectedHalfPizzas[0]);
                    const firstPizzaId = this.selectedHalfPizzas.length > 0 ? this.selectedHalfPizzas[0].id : null;

                    const pizzaToAdd = {
                        pizza: {
                            id: maxPricePizza.id,
                            name: this.selectedHalfPizzas.map(pizza => pizza.name).join(' e '),
                            quantity: 1,
                            value: parseFloat(maxPricePizza.value).toFixed(2),
                            half_pizza: true,
                            half_pizza_product_id: firstPizzaId,
                            additional: maxPricePizza.additional || [],
                            ingredients: maxPricePizza.ingredients || [],
                        },
                        showAdditionalInfo: this.showAdditionalSwitch,
                    };
                    storedPizzas.push(pizzaToAdd);
                }
            }

            localStorage.setItem('selectedPizza', JSON.stringify(storedPizzas));

            this.pizzaInCart = true;
            this.shouldShowAddToCartButton = false;
            this.disableOtherElements = true;

            toast.success("Produto adicionado ao carrinho!", {
                position: toast.POSITION.BOTTOM_LEFT,
            });
        },
        goToCarrinho() {
            this.$router.push({ name: 'ShoppingPage' });
        },
        clearLocalStorage() {
            localStorage.clear();
        },
    },
    mounted() {
        this.fetchProducts();
        this.selectedPizzaType = 'whole';
        this.selectedPizzas = JSON.parse(localStorage.getItem('selectedPizzas')) || [];
        window.addEventListener('beforeunload', this.clearLocalStorage);
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

            <DetailsOrderModal v-if="showModal" @close="closeModal" @add-to-cart="addToCart"
                :pizzaDetails="selectedPizzaWithAdditional">
            </DetailsOrderModal>


            <button v-if="shouldShowAddToCartButton" class="add-cart" @click="addToCart">Adicionar ao Carrinho</button>


            <div class="bottom-bar" v-if="shouldShowBottomBar && selectedPizza">
                <p class="text-uppercase" @click="goToCarrinho">{{ selectedPizzaCount }}x Ver carrinho</p>
            </div>

            <div class="menu" :class="{ 'opacity-low': showAddToCartButton }">
                <base-speciale class="header" v-for="promoPizza in promotionPizza" :key="promoPizza.id"
                    :promotion="promotionPizza" @activate-checkbox="selectPizza" :resetCheckboxEvent="resetCheckboxEvent" />
                <template v-for="product in products">
                    <template v-if="!product.promotion">
                        <base-pizza-card-client class="content" :key="product.id" :image="product.image"
                            :value="product.value" :pizzaDetails="product" @activate-checkbox="selectPizza"
                            :pizzaInCart="product.pizzaInCart" :resetCheckboxEvent="resetCheckboxEvent" />
                    </template>
                </template>
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