<script>
import axios from '@/axios';
import BaseInput from './BaseInput.vue';

export default {
  data() {
    return {
      showModal: false,
      name: '',
      active: false
    };
  },
  components:{
    BaseInput
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.$emit('close');
    },
    async saveCategory() {
      try {
        const response = await axios.post('/category', {
          name: this.name,
          active: this.active
        });

        console.log('Categoria salva com sucesso:', response.data);

        this.name = '';
        this.active = false;
        this.$emit('close');
      } catch (error) {
        console.error('Erro ao salvar a categoria:', error);
      }
    }
  }
};
</script>

<template>
    <div>
        <div v-if="!showModal" class="overlay"></div>
        <div :class="{ 'modal': true, 'show-modal': showModal }">
            <div class="exit">
                <img src="../assets/icons/exit.png" @click="closeModal">
            </div>
            <div class="content-modal">
                <h2 class="title">ADICIONAR CATEGORIA</h2>

                <BaseInput 
                  v-model="name"
                  label="Nome" 
                  class="input name" 
                />

                <div class="switch">
                  <p>Adicional</p>
                  <input type="checkbox" id="mySwitch" class="switch-input" v-model="active">
                  <label for="mySwitch" class="switch-label"></label>
                </div>
    
                <div class="content-buttons">
                    <button class="button cancel" @click="closeModal">
                        CANCELAR
                    </button>
                    <button class="button filled" @click="saveCategory">
                        SALVAR
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

  .modal {
    position: fixed;
    z-index: 10000;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 70%;
    /* height: 50%; */
    max-width: 600px; /* Largura máxima da modal */
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;

    .exit{
        display: flex;
        flex-direction: row-reverse;
        opacity: 0.7;
        cursor: pointer;
    }

    .content-modal{
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;

        .name{
            width: 65%;
            margin: 0 auto;
            margin-top: 40px;
        }

        .switch {
          display: flex;
          flex-direction: row;
          width: 30%;
          height: 34px;
          margin-top: 35px;
          margin-left: 82px;
          justify-content: space-evenly;
          color: var(--cor-icones);
          font-weight: 700;

          .switch-input {
            display: none;
          }

          .switch-label {
            position: relative;
            cursor: pointer;
            top: 0;
            height: 20px;
            width: 50px;
            left: 100px;
            right: 0;
            bottom: 0;
            background-color: var(--cor-site)!important;
            border-radius: 34px;
            border: 1px solid var(--cor-primaria)!important;
            transition: background-color 0.3s;

            &:before {
              position: absolute;
              content: "";
              width: 18px;
              height: 18px;
              left: 4px;
              bottom: 1px;
              background-color: var(--cor-primaria)!important;
              border-radius: 50%;
              transition: transform 0.3s;
            }
          }

          .switch-input:checked + .switch-label {
            background-color: #2196F3;
          }

          .switch-input:checked + .switch-label:before {
            transform: translateX(26px);
          }
        }

    }
  }
</style>