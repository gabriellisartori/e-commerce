<script>
import BasePizzaCard from '@/components/generics/BasePizzaCard.vue';
import PageHeaderEstablishment from '@/components/pageHeaders/PageHeaderEstablishment.vue';

export default {
    components: {
        PageHeaderEstablishment,
        BasePizzaCard
    },
    data() {
        return {
            pizza: {
                image: '../../assets/pizza-home.png',
                name: 'Pizza Margherita',
                value: 'R$60,00',
                isAvailable: true
            }
        };
    }
};
</script>

<template>
    <PageHeaderEstablishment></PageHeaderEstablishment>
    <div class="content">
        <div class="content-menu">
        <BasePizzaCard :image="pizza.image" :name="pizza.name" :value="pizza.value" :switchValue="pizza.isAvailable" />
    </div>
    </div>

</template>

<style lang="scss">
.content-menu{
    display: grid;
    grid-template-columns: 1fr 1fr;
}
</style>