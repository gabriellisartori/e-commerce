<template>
  <div class="profile-edit">
    <div class="column">
      <div>
        <base-input
          v-model="form.name"
          label="Nome Completo"
          class="input"
        ></base-input>
        <div
          :class="{ 'error-message': v$.form.name.$error }"
          v-if="v$.form.name.$error"
        >
          {{ v$.form.name.$errors[0].$message }}
        </div>
      </div>
      <div>
        <base-input
          v-model="form.phone_number"
          label="Telefone"
          class="input"
        ></base-input>
        <div
          :class="{ 'error-message': v$.form.phone_number.$error }"
          v-if="v$.form.phone_number.$error"
        >
          {{ v$.form.phone_number.$errors[0].$message }}
        </div>
      </div>
      <div>
        <base-input v-model="form.cnpj" label="CNPJ" class="input"></base-input>
        <div
          :class="{ 'error-message': v$.form.cnpj.$error }"
          v-if="v$.form.cnpj.$error"
        >
          {{ v$.form.cnpj.$errors[0].$message }}
        </div>
      </div>
    </div>
    <div class="column">
      <div>
        <base-input
          v-model="form.email"
          label="E-mail"
          class="input"
        ></base-input>
        <div
          :class="{ 'error-message': v$.form.email.$error }"
          v-if="v$.form.email.$error"
        >
          {{ v$.form.email.$errors[0].$message }}
        </div>
      </div>
      <base-password
        v-model="form.password"
        label="Senha"
        class="input"
      ></base-password>
      <base-button @click="saveEstablishment" class="input save-data">
        Salvar
      </base-button>
    </div>
  </div>
  <div class="message-error-request">
    <base-message v-if="error" :errorMessage="errorMessage" />
  </div>
</template>

<script>
import { toast } from "vue3-toastify";
import { useVuelidate } from "@vuelidate/core";
import { required$ } from "../../store/validators";

export default {
  data() {
    return {
      form: {
        id: null,
        name: "",
        phone_number: "",
        cnpj: "",
        email: "",
        password: "",
      },
      v$: useVuelidate(),
      error: false,
      errorMessage: null,
    };
  },
  validations() {
    return {
      form: {
        id: {},
        name: { required$ },
        phone_number: { required$ },
        cnpj: { required$ },
        email: { required$ },
        password: {},
      },
    };
  },
  methods: {
    async saveEstablishment() {
      this.v$.$validate();
      if (this.v$.$error) {
        return;
      }
      try {
        await this.$http.put("/establishments/basic-data/1", this.form);

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });
      } catch (error) {
        this.error = true;
        this.errorMessage = "Erro ao salvar os dados do estabelecimento";
        console.error(error);
      }
    },
    async getData() {
      const { data } = await this.$http.get("/establishments");
      this.form = data;
    },
  },
  mounted() {
    this.getData();
  }
};
</script>

<style lang="scss">
.profile-edit {
  display: flex;
  justify-content: space-between;
  width: 100%;
  margin-bottom: 20px;

  .column {
    display: flex;
    flex-direction: column;
    width: 45%;
    padding: 1rem;

    .save-data {
      margin-top: 2.5rem;
    }

    .password-input .svg {
      margin-top: 1.5rem;
    }
  }
}
</style>