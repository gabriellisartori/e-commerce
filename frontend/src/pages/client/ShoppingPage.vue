<script>
import router from '@/router';

export default {
    data() {
        return {
            selectedPizzas: [],
            showAdditionalInfo: false,
        };
    },
    mounted() {
        this.selectedPizzas = JSON.parse(localStorage.getItem('selectedPizza')) || [];
        console.log(this.selectedPizzas, 'minhas pzza')

        const accessToken = localStorage.getItem('token');
        console.log(accessToken, 'token')

        if (accessToken) {
            const decodedToken = this.decodeAccessToken(accessToken);

            const clientId = decodedToken.sub;

            console.log('ID do cliente:', clientId);
        }

        window.addEventListener('beforeunload', this.clearLocalStorage);
    },
    methods: {
        calcularTotal() {
            const total = this.selectedPizzas.reduce((acc, item) => {
                const pizzaValue = parseFloat(item.pizza.value) || 0;

                if (!isNaN(pizzaValue) && isFinite(pizzaValue)) {
                    const additionalValue = item.pizza.additional && item.showAdditionalInfo
                        ? parseFloat(item.pizza.additional.value) || 0
                        : 0;

                    return acc + pizzaValue + additionalValue;
                } else {
                    console.error('Valor inválido para pizza:', item);
                    return acc;
                }
            }, 0);

            return total.toFixed(2);
        },

        getAdditionalInfo() {
            return ingredient => {
                const foundItem = this.storeIngredients.find(item => item.id === ingredient.id);
                return foundItem || null;
            };
        },
        async removerPizza(index) {
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
                this.selectedPizzas.splice(index, 1);

                localStorage.setItem('selectedPizza', JSON.stringify(this.selectedPizzas));
            }
        },
        finalizarPedido() {
            const token = this.$auth.token();

            if (!token) {
                console.error('Usuário não autenticado');
                return;
            }

            const totalValue = parseFloat(this.calcularTotal());
            const orderProducts = this.selectedPizzas.map(item => {
                const pizza = item.pizza;
                const orderProductAdditional = pizza.additional || null;

                if (
                    !pizza?.id ||
                    !pizza?.quantity ||
                    !pizza?.value ||
                    !Number.isFinite(parseFloat(pizza.value))
                ) {
                    console.error('Dados da pizza inválidos:', pizza);
                    return null;
                }

                return {
                    product_id: pizza.id,
                    quantity: pizza.quantity,
                    value: parseFloat(pizza.value),
                    half_pizza: pizza.half_pizza || false,
                    half_pizza_product_id: pizza.half_pizza_product_id || null,
                    order_product_additional: this.showAdditionalInfo ? orderProductAdditional : null,
                };
            }).filter(orderProduct => orderProduct !== null);

            console.log('Order Products:', orderProducts);

            const observation = this.$el.querySelector('.text-area').value || null;

            this.$http.post("/orders", {
                total_value: totalValue,
                observation: observation,
                paid: true,
                client_id: 1,
                establishment_id: 1,
                order_product: orderProducts,
            }, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            })
                .then(response => {
                    console.log('Pedido salvo:', response.data);
                    this.selectedPizzas = [];
                    localStorage.removeItem('selectedPizzas');

                    const confirmed = this.$swal.fire({
                        icon: 'success',
                        title: 'Pedido realizado com sucesso',
                        showConfirmButton: false,
                        timer: 1500,
                        didClose: () => {
                            console.log('Notificação fechada', confirmed);
                            router.push({ name: 'MenuPageClient' });
                        }
                    });
                })
                .catch(error => {
                    console.error('Erro ao salvar o pedido:', error);
                    const confirmed = this.$swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        showConfirmButton: false,
                        didClose: () => {
                            console.log('Notificação fechada', confirmed);
                            router.push({ name: 'MenuPageClient' });
                        }
                    });
                });

            this.clearLocalStorage()
        },
        clearLocalStorage() {
            localStorage.removeItem('selectedPizza');
        },
    },
    beforeUnmount() {
        window.removeEventListener('beforeunload', this.clearLocalStorage);
    },
};
</script>

<template>
    <div class="shopping-content">
        <h2 class="title">Seu carrinho</h2>
        <template v-if="selectedPizzas.length > 0">
            <div class="shopping-page">
                <div v-for="(item, index) in selectedPizzas" :key="index" class="products">
                    <div>
                        <p class="pizza-title">
                            <span>{{ item.pizza.quantity }}x</span>
                            {{ item.pizza.half_pizza ? item.pizza.name : item.pizza.name }}
                        </p>

                        <p>Sabor: <span v-if="Array.isArray(item.pizza.ingredients)">{{
                            item.pizza.ingredients.map(ingredient =>
                                ingredient.name).join(', ') }}</span></p>
                        <p v-if="item.showAdditionalInfo">Adicional: <span>{{ item.pizza.additional ?
                            item.pizza.additional.name : 'Nenhum' }}</span></p>
                    </div>
                    <div class="pizza-values">
                        <h2>R${{ item.pizza.value }}</h2>
                        <h3>R$0,00</h3>
                        <h3 v-if="item.showAdditionalInfo">R${{ item.pizza.additional.value || '0,00' }}</h3>
                    </div>

                    <div class="actions-icons">
                        <div class="hover-icon" @click="removerPizza(index)">
                            <font-awesome-icon class="icon" icon="fa-solid fa-xmark" />
                        </div>
                    </div>

                </div>
                <div class="pizza-values">
                </div>

            </div>

            <div class="total">
                <p>total:</p>
                <h2><span>R$</span>{{ calcularTotal() }}</h2>

                <textarea class="text-area" placeholder="Alguma observação?"></textarea>

                <base-button class="button" color="dark-green" @click="finalizarPedido">ACABEI</base-button>
            </div>
        </template>
        <template v-else>
            <div class="empty">
                Você ainda não possui nada no carrinho 😔
            </div>
        </template>
    </div>
</template>

<style scoped lang="scss">
.shopping-content {
    padding-bottom: 25px;

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


    .shopping-page {
        width: 60%;
        margin: 0 auto;
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        padding: 30px 0px;
        border-top: 1px solid var(--cor-fonte);
        border-bottom: 1px solid var(--cor-fonte);
        line-height: 1.7;

        @media screen and (max-width: 768px) {
            width: 80%;
        }

        @media screen and (max-width: 425px) {
            width: 100%;
            gap: 20px;
        }

        .products {
            display: grid;
            grid-template-columns: 3fr 0fr 0fr;
            margin: 0px 30px;
            gap: 15px;

            .pizza-title {
                font-weight: 700;
                font-size: 20px;

                span {
                    color: var(--cor-secundaria);
                    font-weight: 700;
                    font-size: 24px;
                    margin-right: 10px;
                }
            }
        }

        .pizza-values {
            font-weight: 700;
            margin-right: 25px;

            .value {
                font-weight: 700;
                font-size: 20px;
            }
        }

        .actions-icons {
            display: flex;

            .hover-icon {
                gap: 10px;
            }
        }

    }

    .total {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 60%;
        margin: 0 auto;
        margin-top: 50px;
        text-align: center;

        h2 {
            font-weight: 700;
            color: var(--cor-secundaria);
            font-size: 32px;
        }

        .text-area {
            margin-top: 20px;
            border: none;
            outline: none;
            background-color: rgba(217, 217, 217, 0.60);
            height: 40px;
            width: 60%;
            border-radius: 16px;
            text-align: center;
            padding-top: 5px;
        }

        .button {
            width: 70%;
        }
    }

    .empty {
        margin-top: 50px;
    }
}
</style>