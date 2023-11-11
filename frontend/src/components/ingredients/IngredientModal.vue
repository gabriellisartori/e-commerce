<script>
import { toast } from "vue3-toastify";
import BaseSwitch from "../generics/BaseSwitch.vue";
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
        value: 0,
        hasAdditional: false,
        additional: null,
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
        value: { required$ },
        hasAdditional: { required$ },
      },
    };
  },
  computed: {
    modalTitle() {
      return this.id ? "Editar ingrediente" : "Adicionar ingrediente";
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
    },
    async saveIngredient() {
      this.v$.$validate();
      if (this.v$.$error) {
        return;
      }

      try {
        if (this.id) {
          this.form.id = this.id;

          if (!this.form.hasAdditional) {
            this.form.additional = null;
          }

          await this.$http.put(`/ingredients/${this.id}`, this.form);
        } else {
          if (!this.form.hasAdditional) {
            this.form.additional = null;
          }

          await this.$http.post("/ingredients", this.form);
        }

        this.$emit("ingredientSave");
        this.$emit("close");

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });
      } catch (error) {
        this.error = true;
        this.errorMessage = "Erro ao salvar o ingrediente";
        console.error("Erro ao salvar o ingrediente:", error);
      }
    },
    async getData() {
      try {
        const { data } = await this.$http.get(`/ingredients/${this.id}`);
        this.form = data;
        if (this.form.additional && this.form.additional.value !== null) {
          this.form.hasAdditional = true;
          this.form.value = this.form.additional.value;
        } else {
          this.form.hasAdditional = false;
        }
      } catch (error) {
        console.error(error);
      }
    },
    handleSwitchChange(newValue) {
      this.form.hasAdditional = newValue;
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
  <base-modal
    :modalTitle="modalTitle"
    @close="closeModal"
    @save="saveIngredient"
  >
    <div class="components">
      <div class="infos">
        <div>
          <base-input v-model="form.name" label="Nome" class="input value" />
          <div
            :class="{ 'error-message': v$.form.name.$error }"
            v-if="v$.form.name.$error"
          >
            {{ v$.form.name.$errors[0].$message }}
          </div>
        </div>

        <base-switch
          label="Adicional"
          v-model="form.hasAdditional"
          id="name"
          @update:modelValue="handleSwitchChange"
        />
        <div
          :class="{ 'error-message': v$.form.hasAdditional.$error }"
          v-if="v$.form.hasAdditional.$error"
        >
          {{ v$.form.hasAdditional.$errors[0].$message }}
        </div>
      </div>

      <div>
        <base-input
          v-if="form.hasAdditional"
          v-model="form.value"
          label="Valor Adicional"
          class="input value additional"
        />
        <div
          :class="{ 'error-message': v$.form.value.$error }"
          v-if="v$.form.value.$error"
        >
          {{ v$.form.value.$errors[0].$message }}
        </div>
      </div>
    </div>
    <base-message v-if="error" :errorMessage="errorMessage" />
  </base-modal>
</template>
      

<style scoped lang="scss">
.components {
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  width: 100%;
  margin: 0 auto;

  .infos {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .value {
    width: 450px;
    margin-top: 40px;
    margin-bottom: 0px;

    &.additional {
      width: 100%;
    }
  }
}
</style>
