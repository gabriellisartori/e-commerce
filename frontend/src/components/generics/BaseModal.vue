<script>
import BaseButton from './BaseButton.vue';
export default {
  components: { BaseButton },
  props: {
    modalTitle: String,
  },
  data() {
    return {
      showModal: false,
    };
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.$emit('close');
    },
    saveModal() {
      this.$emit('save');
    }
  },
};
</script>

<template>
  <div>
    <div v-if="!showModal" class="overlay"></div>
    <div :class="{ 'modal': true, 'show-modal': showModal }">
      <div class="exit">
        <h2 class="title">{{ modalTitle }}</h2>
        <div class="hover-icon">
          <font-awesome-icon class="icon" icon="fa-solid fa-xmark" @click="closeModal" />
        </div>
      </div>

      <div class="content-modal">
        <slot></slot>

        <div class="content-buttons">
          <base-button class="button" color="dark-green" isOutlined @onClick="closeModal">
            Cancelar
          </base-button>
          <base-button class="button" color="dark-green" @onClick="saveModal">
            Salvar
          </base-button>
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
  max-width: 600px;
  background-color: #fefefe;
  padding: 20px;
  border: 1px solid #888;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 16px;
  max-height: 550px;
  overflow-y: auto;

  ::-webkit-scrollbar-thumb {
    background-color: #888;
    /* Cor do "thumb" (o indicador da posição atual) */
  }

  ::-webkit-scrollbar-track {
    background-color: #eee;
    /* Cor do "track" (a área da barra de rolagem que não está sendo percorrida) */
  }

  .exit {
    display: flex;
    opacity: 0.7;
    justify-content: space-between;
    align-items: center;

    .icon {
      cursor: pointer;
      font-size: 20px;
      color: var(--cor-fonte);
    }
  }

  .content-modal {
    padding: 0px 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;

    .title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 20px;
    }
  }
}
</style>