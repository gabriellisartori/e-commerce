<script>
import BaseInput from '../generics/BaseInput.vue';


export default {
  data() {
    return {
      showModal: false,
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
  }
};
</script>

<template>
    <div>
        <div v-if="!showModal" class="overlay"></div>
            <div :class="{ 'modal': true, 'show-modal': showModal }">
            <div class="exit">
              <img src="../../assets/icons/exit.png" @click="closeModal">
            </div>
            <div class="content-modal">
              <h3 class="title">ADICIONAR INGREDIENTE</h3>

              <BaseInput 
                label="Nome" 
                class="input name" 
              />

              <div class="content-buttons">
                <button class="button cancel" @click="closeModal">
                  CANCELAR
                </button>
                <button class="button filled">
                  SALVAR
                </button>
              </div>
            </div>
        </div>
    </div>
</template>
      
<!-- <style lang="scss">
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
  z-index: 1;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 70%;
 /*  height: 50%; */
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
  }
}
</style> -->
