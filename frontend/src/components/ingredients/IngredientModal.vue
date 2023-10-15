<script>
import { toast } from 'vue3-toastify';
import BaseSwitch from '../generics/BaseSwitch.vue'

export default {
  components: {
    BaseSwitch,
  },
  props: {
    id: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
      form: {
        name: '',
        value: 0,
        hasAdditional: false,
      },
      modalTitle: 'Adicionar ingrediente'
    };
  },
  methods: {
    closeModal() {
      this.$emit('close');
    },
    async saveIngredient() {
      try {

        if (this.id) {
          this.form.id = this.id;
          await this.$http.put(`/ingredients/${this.id}`, this.form);
        } else {
          await this.$http.post('/ingredients', this.form);
        }

        this.$emit('ingredientSave');
        this.$emit('close');

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });

      } catch (error) {
        console.error('Erro ao salvar o ingrediente:', error);
      }
    },
    async getData() {
      try {
        const { data } = await this.$http.get(`/ingredients/${this.id}`);
        this.form = data;
        if (this.form.additional === null) {
          this.form.hasAdditional = false;
        } else {
          this.form.hasAdditional = true;
          this.form.value = this.form.additional.value;
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
  mounted() {
    if (this.id) {
      this.modalTitle = 'Editar ingrediente';
      this.getData();
    }
  }
};
</script>

<template>
    <base-modal :modalTitle="modalTitle" @close="closeModal" @save="saveIngredient">
      <div class="components">
        <div class="infos">
            <base-input v-model="form.name" label="Nome" class="input value" />
            <BaseSwitch label="Adicional" v-model="form.hasAdditional" @input="form.hasAdditional = $event" />
        </div>

        <div>
            <base-input v-if="form.hasAdditional" v-model="form.value" label="Valor Adicional"
                class="input value additional" />
        </div>
    </div>
  </base-modal>
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
