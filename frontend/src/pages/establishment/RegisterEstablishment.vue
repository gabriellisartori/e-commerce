<script setup>
import PageHeaderEstablishment from '@/components/PageHeaderEstablishment.vue';
import BaseInput from '@/components/BaseInput.vue'

</script>

<template>
    <div class="content-page">
        <PageHeaderEstablishment></PageHeaderEstablishment>
         <h2 class="title">CADASTRO DE ESTABELECIMENTO</h2>
        <form>
            <div class="container">
                <div class="column">
                    <BaseInput label="Nome Completo" class="input"></BaseInput>
                    <BaseInput label="Telefone" class="input"></BaseInput>
                    <BaseInput label="CNPJ" class="input"></BaseInput>
                    <BaseInput label="E-mail" class="input"></BaseInput>
                    <BaseInput label="Senha" class="input"></BaseInput>
                </div>
                <div class="column">
                    <BaseInput label="CEP" class="input"></BaseInput>
                    <BaseInput label="Cidade" class="input"></BaseInput>
                    <BaseInput label="Bairro" class="input"></BaseInput>
                    <BaseInput label="Rua" class="input"></BaseInput>
                    <div class="grid-2">
                        <BaseInput label="Número" class="input"></BaseInput>
                        <BaseInput label="Complemento" class="input"></BaseInput>
                    </div>
                    <button type="submit" class="button login">ENTRAR</button>
                </div>
            </div>
        </form>
    </div>
</template>

<style scoped lang="scss">
.content-page{

    .title{
        font-weight: 700;
        margin-left: 10%;
        margin-top: 35px;
    }

    .container{
        display: grid;
        grid-template-columns: 1fr 1fr; 
        gap: 60px; 
        width: 70%; 
        margin: 0 auto;
        margin-top: 20px;

        .column{
            .input{
                margin-top: 30px;
            }

            .grid-2{
                display: grid;
                grid-template-columns: 1fr 1fr; 
                gap: 30px; 
            }

            .login{
                width: 100%;
            }
        }
    }
}

</style>