<script>
import BaseModal from '../generics/BaseModal.vue';

export default {
  components: {
    BaseModal,
  },
  data() {
    return {
      showModal: false,
      modalTitle: 'HORÁRIO DE FUNCIONAMENTO'
    };
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
    <div class="div-settings"></div>

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

</style>