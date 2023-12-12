<script>
import BaseCollapsible from '@/components/generics/BaseCollapsible.vue';
import FiltersModal from '@/components/FiltersModal.vue';

export default {
    components: {
        BaseCollapsible,
        FiltersModal
    },
    data() {
        return {
            orders: [],
            selectedOrderId: null,
            selectedOrder: null,
            search: {
                start_date: null,
                end_date: null
            },
            showFilters: false
        };
    },
    methods: {
        async fetchOrders() {
            try {
                const establishmentResponse = await this.$http.get('/establishments');
                this.establishment = establishmentResponse.data;
                console.log(this.establishment)

                const response = await this.$http.get('/orders' , {
                    params: this.search
                });
                this.orders = response.data;

                console.log(this.orders, 'pedidos');
            } catch (error) {
                console.error('Erro ao buscar os pedidos', error);
            }
        },
        formatCurrency(value) {
            const numericValue = typeof value === 'string' ? parseFloat(value) : value;
            return numericValue.toFixed(2).replace('.', ',');
        },
        openWhatsApp(phoneNumber) {
            const formattedPhoneNumber = phoneNumber.replace(/\D/g, '');

            window.open(`https://web.whatsapp.com/send?phone=${formattedPhoneNumber}`, '_blank');
        },
        formatDate(dateTimeString) {
            const parts = dateTimeString.split(/[\s/•:]/);

            const day = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10);
            const year = parseInt(parts[2], 10);

            const date = new Date(year, month - 1, day);

            if (isNaN(date.getTime())) {
                return "Data inválida";
            }

            const options = { year: 'numeric', month: 'numeric', day: 'numeric' };
            return date.toLocaleDateString('pt-BR', options);
        },
        searchFilter (event) {
          this.search.start_date = event.start_date;
          this.search.end_date = event.end_date;
          this.fetchOrders();
        },
        getAll () {
          this.search.start_date = null;
          this.search.end_date = null;
          this.fetchOrders();
        },
        async exportFile () {
            const { data } = await this.$http.get('/orders/exportFile', { params: this.search }, {
              responseType: 'blob'
            });
            const url = window.URL.createObjectURL(new Blob([data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'pedidos.xlsx');
            document.body.appendChild(link);
            link.click();
        }
    },
    mounted() {
        this.fetchOrders();
    },
};
</script>


<template>
    <div>
        <div class="page-header-options">
            <h2 class="title">Pedidos</h2>
            <div>
                <base-button class="icon" isTransparent isIcon icon="fa-solid fa-magnifying-glass" color="dark-green" @onClick="showFilters = true"/>
                <base-button class="icon" isTransparent isIcon icon="fa-solid fa-file-excel" color="dark-green" @click="exportFile()"/>
                <base-button class="icon" isTransparent isIcon icon="fa-solid fa-rotate" color="dark-green" @onClick="getAll"/>
            </div>
        </div>

        <div v-if="orders.length === 0">
            <p>Você ainda não tem nenhum pedido 😔</p>
        </div>

        <div v-else class="collapsible-orders">
            <BaseCollapsible v-for="order in orders" :key="order.id"
                :title="`${formatDate(order.created_at)} - ${order.client.name}`"  :icone="true">
               
                    <p>Pizza:</p>
                    <div v-for="productItem in order.products" :key="productItem.id">
                        <template v-if="productItem.half_pizza">
                            <p>{{ productItem.product.name }} - R$ {{ productItem.product.value }},00</p>
                        </template>
                        <template v-else>
                            <p>{{ productItem.product.name }} - R$ {{ productItem.product.value }},00</p>
                        </template>
                        <p v-if="productItem.product.additional">+ {{ productItem.product.additional.name }} - R${{
                            formatCurrency(productItem.product.additional.value) }}</p>
                        <p class="total-value">Total: R${{ formatCurrency(order.total_value) }}</p>
                    </div>
            </BaseCollapsible>
        </div>
    </div>
    <FiltersModal 
        v-if="showFilters"
        isPeriod
        @close="showFilters = false"
        @getValues="searchFilter($event)"
    />
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

.collapsible-orders {
    gap: 20px;
    display: grid;
    font-weight: 700;
    line-height: 1.6rem;

    .total-value {
        font-size: 20px;
        margin-top: 12px;
    }
}
</style>