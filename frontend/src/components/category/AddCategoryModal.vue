<script>
import BaseInput from '../generics/BaseInput.vue';
import BaseModal from '../generics/BaseModal.vue'
import BaseSwitch from '../generics/BaseSwitch.vue'

export default {
  components: {
    BaseModal,
    BaseInput,
    BaseSwitch,
  },
  data() {
    return {
      showModal: false,
      name: '',
      modalTitle: 'ADICIONAR CATEGORIA',
      active: false,
    };
  },
  methods: {
    handleSwitchInput(value) {
      console.log('Evento input recebido com valor:', value);
      this.active = value;
    },
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.$emit('close');
    },
    async saveCategory() {
      try {
        const response = await this.$http.post('/category', {
          name: this.name,
          active: this.active
        });

        this.name = '';
        this.active = false;
        this.$emit('categoryAdded', response.data);
        this.$emit('close');

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });

      } catch (error) {
        console.error('Erro ao salvar a categoria:', error);
      }
    }
  }
};
</script>

<template>
  <BaseModal :modalTitle="modalTitle">
    <div class="components">
      <BaseInput v-model="name" label="Nome" class="input name" />
      <BaseSwitch label="Ativo" v-model="active" />
    </div>


    <div class="content-buttons">
      <button class="button cancel" @click="closeModal">
        CANCELAR
      </button>
      <button class="button filled" @click="saveCategory">
        SALVAR
      </button>
    </div>
  </BaseModal>
</template>

<style scoped lang="scss">
.components {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  width: 80%;
  margin: 0 auto;

  .name {
    width: 65%;
    margin-top: 40px;
    margin-bottom: 0px;
  }
}
</style>