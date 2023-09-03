<script setup>
import CardIngredient from '@/components/CardIngredient.vue'
import PageHeaderEstablishment from '@/components/PageHeaderEstablishment.vue';

</script>

<template>
    <PageHeaderEstablishment></PageHeaderEstablishment>
    <div class="page-header-options">
        <h2 class="title">INGREDIENTES</h2>
        <button class="button-add">
            <!-- <img src="../assets/icons/plus.png"> -->
            Adicionar
        </button>
    </div>
    
    <div class="content-ingredient">
        <CardIngredient></CardIngredient>
        <CardIngredient></CardIngredient>
        <CardIngredient></CardIngredient>
    </div>
</template>

<style lang="scss">
.page-header-options{
    display: flex;
    width: 70%;
    margin: 0 auto;
    margin-top: 40px;
    justify-content: space-between;

    .title{
        font-weight: 700;
    }

    .button-add{
        background-color: transparent;
        color: #3E5903;
        border: transparent;
        font-weight: bold;
        font-size: 16px;
    }
}

.content-ingredient{
    display: grid;
    grid-template-columns: 1fr 1fr;
    width: 70%;
    margin: 0 auto;
}
</style>