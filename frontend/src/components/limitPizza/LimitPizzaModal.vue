<script>
import BaseModal from '../generics/BaseModal.vue';
import BaseInput from '../generics/BaseInput.vue';

export default {
  data() {
    return {
      showModal: false,
      modalTitle: 'DEFINIR LIMITE DE PIZZAS'
    };
  },
  components: {
    BaseModal,
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
  <BaseModal :modalTitle="modalTitle">

    <div class="div-settings">
      <BaseInput label="Limite" class="input name" />
      <BaseInput label="Dia" class="input name" />
      <BaseInput label="Início" class="input name" />
      <BaseInput label="Fim" class="input name" />
    </div>

    <div class="content-buttons">
      <button class="button cancel" @click="closeModal">
        CANCELAR
      </button>
      <button class="button filled">
        SALVAR
      </button>
    </div>
  </BaseModal>
</template>

<style lang="scss">
.div-settings {
  display: flex;
  flex-direction: row;
  justify-content: space-between;

  .base-input-div {
    width: 20%;

    .base-input {
      height: 25px;
    }
  }

}
</style>