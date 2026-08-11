<script>
import BaseButton from './BaseButton.vue';
export default {
  components: { BaseButton },
  props: {
    modalTitle: String,
    size: {
      type: String,
      default: 'medium',
    },
    showButtons: {
      type: Boolean,
      default: true,
    },
    saveLabel: {
      type: String,
      default: 'Salvar',
    },
  },
  data() {
    return {
      showModal: false,
    };
  },
  computed: {
    computedClass() {
      return {
        'is-medium': this.size === 'medium',
        'is-large': this.size === 'large',
        'modal': true,
        'show-modal': this.showModal
      }
    }
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
    <div :class="computedClass">
      <div class="exit">
        <h2 class="title">{{ modalTitle }}</h2>
        <div class="hover-icon">
          <font-awesome-icon class="icon" icon="fa-solid fa-xmark" @click="closeModal" />
        </div>
      </div>

      <div class="content-modal">
        <slot></slot>

        <div class="content-buttons" v-if="showButtons">
          <base-button class="button" color="dark-green" isOutlined @onClick="closeModal">
            Cancelar
          </base-button>
          <base-button class="button" color="dark-green" @onClick="saveModal">
            {{ saveLabel }}
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


  &.is-large {
    max-width: 1000px;
  }


  .exit {
    display: flex;
    opacity: 0.7;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;

    @media screen and (max-width: 645px){
      margin-top: 5px;
    }

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

    @media screen and (max-width: 645px){
      margin-bottom: 30px;
    }
  }
}
</style>