<script>
import BaseInput from '@/components/generics/BaseInput.vue';
import BasePassword from '@/components/generics/BasePassword.vue';

export default {
  components: {
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
    async saveEstablishment() {
      try {
        const response = await this.$http.post('/establishments', {
          nome: this.nome,
          telefone: this.telefone,
          cnpj: this.cnpj,
          email: this.email,
          password: this.password,
          cep: this.cep,
          cidade: this.cidade,
          bairro: this.bairro,
          rua: this.rua,
          numero: this.numero,
          complemento: this.complemento
        });

        console.log('Estabelecimento salvo com sucesso:', response.data);

      } catch (error) {
        console.error('Erro ao salvar estabelecimento:', error);
      }
    }
  }
}
</script>

<template>
    <div class="content-page">
         <h2 class="title">Cadastrar estabelecimento</h2>
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
                        <BaseInput v-model="numero" label="Número" class="input grid"></BaseInput>
                        <BaseInput v-model="complemento" label="Complemento" class="input grid"></BaseInput>
                    </div>
                    <base-button class="login" @click="saveEstablishment">ENTRAR</base-button>
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
        height: calc(100vh - 200px);

        .column{
            .input{
                margin-top: 30px;

                &.grid{
                  margin-top: 10px;
                }
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