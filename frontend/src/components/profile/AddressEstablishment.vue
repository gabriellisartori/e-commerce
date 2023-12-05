<template>
  <div class="profile-edit">
    <div class="column">
      <div>
        <base-input v-model="form.zip_code" label="CEP" placeholder="00000-000" v-mask="'#####-###'" class="input"></base-input>
        <div
          :class="{ 'error-message': v$.form.zip_code.$error }"
          v-if="v$.form.zip_code.$error"
        >
          {{ v$.form.zip_code.$errors[0].$message }}
        </div>
      </div>
      <div>
        <base-input
          v-model="form.city"
          label="Cidade"
          class="input"
        ></base-input>
        <div
          :class="{ 'error-message': v$.form.city.$error }"
          v-if="v$.form.city.$error"
        >
          {{ v$.form.city.$errors[0].$message }}
        </div>
      </div>
      <div>
        <base-input
          v-model="form.neighborhood"
          label="Bairro"
          class="input"
        ></base-input>
        <div
          :class="{ 'error-message': v$.form.neighborhood.$error }"
          v-if="v$.form.neighborhood.$error"
        >
          {{ v$.form.neighborhood.$errors[0].$message }}
        </div>
      </div>
    </div>
    <div class="column">
      <div>
        <base-input v-model="form.street" label="Rua" class="input"></base-input>
        <div
          :class="{ 'error-message': v$.form.street.$error }"
          v-if="v$.form.street.$error"
        >
          {{ v$.form.street.$errors[0].$message }}
        </div>
      </div>
      <div>
        <base-input
          v-model="form.number"
          label="Número"
          class="input grid"
        ></base-input>
        <div
          :class="{ 'error-message': v$.form.number.$error }"
          v-if="v$.form.number.$error"
        >
          {{ v$.form.number.$errors[0].$message }}
        </div>
      </div>
      <base-input
        v-model="form.complement"
        label="Complemento"
        class="input grid"
      ></base-input>
    </div>
  </div>
  <div class="message-error-request">
    <base-message v-if="error" :errorMessage="errorMessage" />
  </div>
  <div class="content-button-profile">
    <base-button class="button-profile" @click="saveEstablishment">
      Salvar
    </base-button>
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
        address_id: null,
        zip_code: "",
        city: "",
        neighborhood: "",
        street: "",
        number: "",
        complement: "",
      },
      v$: useVuelidate(),
      error: false,
      errorMessage: null,
    };
  },
  validations() {
    return {
      form: {
        address_id: {},
        zip_code: { required$ },
        city: { required$ },
        neighborhood: { required$ },
        street: { required$ },
        number: { required$ },
        complement: {},
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
        await this.$http.put("/establishments/address/1", this.form);

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });
      } catch (error) {
        this.error = true;
        this.errorMessage = "Erro ao salvar o endereço";
        console.error(error);
      }
    },
    async getData() {
      const { data } = await this.$http.get("/establishments");
      this.form = data.address;
    },
  },
  mounted() {
    this.getData();
  },
};
</script>

<style lang="scss">
.content-button-profile {
  text-align: center;
  .button-profile {
    margin-bottom: 20px;
    width: 80%;
  }
}

.message-error-request {
  display: flex;
  justify-content: center;

  .message {
    width: 80%;
  }
}
</style>