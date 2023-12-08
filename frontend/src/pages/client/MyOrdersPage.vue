<script>
import axios from 'axios';

export default {
    data() {
        return {
            orders: [],
            selectedOrderId: null,
            selectedOrder: null
        };
    },
    mounted() {
        this.fetchOrders();
    },
    methods: {
        async fetchOrders() {
            try {
                const response = await axios.get('/orders');
                this.orders = response.data;
            } catch (error) {
                console.error('Erro ao buscar os pedidos', error);
            }
        },
        async fetchOrderById(orderId) {
            try {
                const response = await axios.get(`/orders/${orderId}`);
                this.selectedOrder = response.data;
            } catch (error) {
                console.error('Erro ao buscar o pedido por ID', error);
            }
        },
        selectOrder(orderId) {
            this.selectedOrderId = orderId;
            this.fetchOrderById(orderId);
        }
    }
};
</script>

<template>
    <div>
        <div class="page-header-options">
            <h2 class="title">Pedidos</h2>
        </div>

        <div v-if="orders.length === 0">
            <p>Você ainda não tem nenhum pedido 😔</p>
        </div>

        <ul v-else>
            <li v-for="order in orders" :key="order.id" @click="selectOrder(order.id)">
                {{ order.name }} - {{ order.total }}
            </li>
        </ul>

        <div v-if="selectedOrder">
            <h3>{{ selectedOrder.name }} - {{ selectedOrder.total }}</h3>
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
</style>