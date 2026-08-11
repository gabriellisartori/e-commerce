<script>
import BaseSwitch from "../generics/BaseSwitch.vue";
import { toast } from "vue3-toastify";
import { useVuelidate } from "@vuelidate/core";
import { required$ } from "../../store/validators";

export default {
  components: {
    BaseSwitch,
  },
  props: {
    id: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      form: {
        name: "",
        active: false,
      },
      v$: useVuelidate(),
      errorMessage: "",
      error: false,
    };
  },
  validations() {
    return {
      form: {
        name: { required$ },
        active: { required$ },
      },
    };
  },
  computed: {
    modalTitle() {
      return this.id ? "Editar categoria" : "Adicionar categoria";
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
    },
    async saveCategory() {
      this.v$.$validate();
      if (this.v$.$error) {
        return;
      }
      try {
        if (this.id) {
          this.form.id = this.id;
          await this.$http.put(`/categories/${this.id}`, this.form);
        } else {
          await this.$http.post("/categories", this.form);
        }

        this.$emit("categorySave");
        this.$emit("close");

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });
      } catch (error) {
        this.error = true;
        this.errorMessage = "Erro ao salvar a categoria";
        console.error("Erro ao salvar a categoria:", error);
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
  },
};
</script>

<template>
  <base-modal :modalTitle="modalTitle" @close="closeModal" @save="saveCategory">
    <div class="components">
      <div>
        <base-input v-model="form.name" label="Nome" class="input name" @update:modelValue="form.name = $event" />
        <div :class="{ 'error-message': v$.form.name.$error }" v-if="v$.form.name.$error">
          {{ v$.form.name.$errors[0].$message }}
        </div>
      </div>
      <BaseSwitch label="Ativo" id="active" v-model="form.active" />
    </div>
    <base-message v-if="error" :errorMessage="errorMessage" />
  </base-modal>
</template>

<style scoped lang="scss">
.components {
  display: flex;
  flex-direction: row;
  justify-content: space-around;
  width: 80%;
  margin: 0 auto;

  @media screen and (max-width: 650px) {
    flex-direction: column;
  }

  .name {
    width: 270px;
    margin-top: 40px;
    margin-bottom: 0px;

    @media screen and (max-width: 650px) {
      width: auto;

    }
  }
}
</style>