<script>
import axios from '@/axios';
import { toast } from 'vue3-toastify';
import BaseModal from '../generics/BaseModal.vue'
import BaseInput from '../generics/BaseInput.vue';
import BaseSwitch from '../generics/BaseSwitch.vue';

export default {
  props: {
    category: {
      type: Object,
      required: true
    }
  },
  components: {
    BaseModal,
    BaseInput,
    BaseSwitch
  },
  data() {
    return {
      modalTitle: 'EDITAR CATEGORIA',
      showModal: false,
      editedCategory: {
        id: this.category.id,
        name: this.category.name,
        active: this.category.active
      }
    };
  },
  computed: {
    switchValue: {
      get() {
        return this.editedCategory.active;
      },
      set(value) {
        this.editedCategory.active = value;
      }
    }
  },
  methods: {
    closeModal() {
      this.$emit('close');
    },
    async updateCategory() {
      try {
        const data = {
          id: this.editedCategory.id,
          name: this.editedCategory.name,
          active: this.editedCategory.active
        };

        const response = await axios.put(`/category`, data);
        console.log('Categoria atualizada com sucesso:', response.data);

        this.$emit('categoria-atualizada', response.data);

        this.$emit('close');

        toast.success("Alterações salvas!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });
      } catch (error) {
        console.error('Erro ao atualizar a categoria:', error);
      }
    },
    handleSwitchInput(value) {
      console.log('Evento input recebido com valor:', value);
      this.editedCategory.active = value;
    }
  }
}
</script>

<template>
  <BaseModal :modalTitle="modalTitle">
    <div class="components">
      <BaseInput v-model="editedCategory.name" label="Nome" class="input name" />
      <BaseSwitch label="Ativo" v-model="editedCategory.active" @input="handleSwitchInput" />
    </div>

    <div class="content-buttons">
      <button class="button cancel" @click="closeModal">
        CANCELAR
      </button>
      <button class="button filled" @click="updateCategory">
        SALVAR
      </button>
    </div>
  </BaseModal>
</template>

<style scoped lang="scss">
.components {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: 80%;
  margin: 0 auto;

  .name {
    width: 65%;
    margin-top: 40px;
    margin-bottom: 0px;
  }
}
</style>