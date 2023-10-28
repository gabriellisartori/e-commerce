<script>
import BaseSwitch from '../generics/BaseSwitch.vue'
import { toast } from 'vue3-toastify';

export default {
  components: {
    BaseSwitch,
  },
  props: {
    id: {
      type: Number,
      default: null,
    }
  },
  data() {
    return {
      form: {
        name: '',
        active: false,
      },
    };
  },
  computed: {
    modalTitle() {
      return this.id ? 'Editar categoria' : 'Adicionar categoria';
    }
  },
  methods: {
    closeModal() {
      this.$emit('close');
    },
    async saveCategory() {
      try {
        if (this.id) {
          this.form.id = this.id;
          await this.$http.put(`/categories/${this.id}`, this.form);
        } else {
          await this.$http.post('/categories', this.form);
        }

        this.$emit('categorySave');
        this.$emit('close');

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });

      } catch (error) {
        console.error('Erro ao salvar a categoria:', error);
      }
    },
    async getData() {
      try {
        const { data } = await this.$http.get(`/categories/${this.id}`);
        this.form = data;
      } catch (error) {
        console.error(error);
      }
    },
  },
  mounted() {
    if (this.id) {
      this.getData();
    }
  }
};
</script>

<template>
  <base-modal :modalTitle="modalTitle" @close="closeModal" @save="saveCategory">
    <div class="components">
      <base-input v-model="form.name" label="Nome" class="input name" @update:modelValue="form.name = $event"/>
      <BaseSwitch label="Ativo" v-model="form.active" />
    </div>
  </base-modal>
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