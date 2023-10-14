<script>
import axios from '@/axios';
import { toast } from 'vue3-toastify';
import BaseInput from '../generics/BaseInput.vue';
import BaseModal from '../generics/BaseModal.vue';
import BaseSwitch from '../generics/BaseSwitch.vue';

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
      value: null,
      modalTitle: 'ADICIONAR INGREDIENTE',
      hasAdditional: false,
    };
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.$emit('close');
    },
    async saveIngredient() {
      try {
        this.value = Number(this.value);

        const response = await axios.post('/ingredient', {
          name: this.name,
          value: this.value,
          hasAdditional: this.hasAdditional,
        });

        this.name = '';
        this.hasAdditional = false;
        this.$emit('ingredientAdded', response.data);
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
      <div class="infos">
        <BaseInput v-model="name" label="Nome" class="input value" />
        <BaseSwitch label="Adicional" v-model="hasAdditional" />
      </div>

      <div>
        <BaseInput type="number" v-if="hasAdditional" v-model="value" label="Valor Adicional" class="input value additional" />
      </div>
    </div>


    <div class="content-buttons">
      <button class="button cancel" @click="closeModal">
        CANCELAR
      </button>
      <button class="button filled" @click="saveIngredient">
        SALVAR
      </button>
    </div>
  </BaseModal>
</template>
      

<style scoped lang="scss">
.components {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  width: 80%;
  margin: 0 auto;

  .infos {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .value {
    width: 65%;
    margin-top: 40px;
    margin-bottom: 0px;

    &.additional{
      width: 100%;
    }
  }
}
</style>
