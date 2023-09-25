<script>
import axios from 'axios';
import PageHeaderEstablishment from '@/components/PageHeaderEstablishment.vue';
import BaseInput from '@/components/BaseInput.vue';
import BasePassword from '@/components/BasePassword.vue';

export default {
  components: {
    PageHeaderEstablishment,
    BaseInput,
    BasePassword
  },
  data() {
    return {
      form: {
        nome: '',
        telefone: '',
        cnpj: '',
        email: '',
        password: '',
        cep: '',
        cidade: '', 
        bairro: '',
        rua: '',
        numero: '',
        complemento: ''
      }
    };
  },
  methods: {
    handleSubmit() {
      axios.post('http://seu-backend.com/establishment', this.form)
        .then(response => {
          console.log('Sucesso:', response.data);
        })
        .catch(error => {
          console.error('Erro:', error);
        });
    }
  }
}
</script>

<template>
    <div class="content-page">
        <PageHeaderEstablishment></PageHeaderEstablishment>
         <h2 class="title">CADASTRO DE ESTABELECIMENTO</h2>
        <form @submit.prevent="handleSubmit">
            <div class="container">
                <div class="column">
                    <BaseInput v-model="nome" label="Nome Completo" class="input"></BaseInput>
                    <BaseInput v-model="telefone" label="Telefone" class="input"></BaseInput>
                    <BaseInput v-model="cnpj" label="CNPJ" class="input"></BaseInput>
                    <BaseInput v-model="email" label="E-mail" class="input"></BaseInput>
                    <BasePassword v-model="password" label="Senha" class="input"></BasePassword>
                </div>
                <div class="column">
                    <BaseInput v-model="cep" label="CEP" class="input"></BaseInput>
                    <BaseInput v-model="cidade" label="Cidade" class="input"></BaseInput>
                    <BaseInput v-model="bairro" label="Bairro" class="input"></BaseInput>
                    <BaseInput v-model="rua" label="Rua" class="input"></BaseInput>
                    <div class="grid-2">
                        <BaseInput v-model="numero" label="Número" class="input"></BaseInput>
                        <BaseInput v-model="complemento" label="Complemento" class="input"></BaseInput>
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