<template>
  <div>
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
          <base-date
            label="Data de nascimento"
            v-model="form.date_birth"
            type="date"
            class="input date"
            @date-selected="updateStartDate"
            @update:modelValue="form.date_birth = $event"
          >
          </base-date>
          <div
            :class="{ 'error-message': v$.form.date_birth.$error }"
            v-if="v$.form.date_birth.$error"
          >
            {{ v$.form.date_birth.$errors[0].$message }}
          </div>
        </div>

        <div>
          <base-input v-model="form.cpf" mask="###.###.###-##" placeholder="999.999.999-99" label="CPF" class="input"></base-input>
          <div
            :class="{ 'error-message': v$.form.cpf.$error }"
            v-if="v$.form.cpf.$error"
          >
            {{ v$.form.cpf.$errors[0].$message }}
          </div>
        </div>
      </div>
      <div class="column">
        <div>
          <base-input
            v-model="form.phone_number"
            label="Telefone"
            placeholder="(99) 99999-9999"
            mask="(##) #####-####"
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
          <base-input
            v-model="form.email"
            label="E-mail"
            placeholder="teste@teste.com"
            class="input"
          ></base-input>
          <div
            :class="{ 'error-message': v$.form.email.$error }"
            v-if="v$.form.email.$error"
          >
            {{ v$.form.email.$errors[0].$message }}
          </div>
        </div>
        <div>
          <base-password
            v-model="form.password"
            label="Senha"
            class="input"
          ></base-password>
          <div
            :class="{ 'error-message': v$.form.password.$error }"
            v-if="v$.form.password.$error"
          >
            {{ v$.form.password.$errors[0].$message }}
          </div>
        </div>
      </div>
    </div>
    <div class="message-error-request">
      <base-message v-if="error" :errorMessage="errorMessage" />
    </div>
    <div class="content-button-profile">
      <base-button class="button-profile" @click="saveClient">
        Salvar
      </base-button>
    </div>
  </div>
</template>
  
  <script>
import { toast } from "vue3-toastify";
import { useVuelidate } from "@vuelidate/core";
import { required$ } from "../../store/validators";
import { requiredIf, helpers } from "@vuelidate/validators";
import moment from "moment";

export default {
  data() {
    return {
      form: {
        id: null,
        name: "",
        phone_number: "",
        date_birth: "",
        cpf: "",
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
        date_birth: { required$ },
        cpf: { required$ },
        email: { required$ },
        password: { required: helpers.withMessage('Este campo é obrigatório', requiredIf(this.form.id === null)) },
      },
    };
  },
  methods: {
    async saveClient() {
        console.log(this.form);
      this.v$.$validate();
      if (this.v$.$error) {
        return;
      }
      try {
        this.error = false;
        let dataString = this.form.date_birth;
        let dataFormatada = moment(dataString, "DD/MM/YYYY").format(
          "YYYY-MM-DD"
        );
        this.form.date_birth = dataFormatada;

        if (this.form.id === null) {
          await this.$http.post("/clients", this.form);
          await this.$auth.login({
            data: {
              email: this.form.email,
              password: this.form.password,
            },
          });
        } else {
          await this.$http.put(`/clients/${this.form.id}`, this.form);
        }

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });
      } catch (error) {
        this.error = true;
        this.errorMessage = "Erro ao salvar os dados";
        console.error(error);
      }
    },
    async getData() {
      const { data } = await this.$http.get(`/clients/${this.$auth.user().id}`);
      this.form = data[0];
    },
    updateStartDate(selectedDate) {
      this.form.date_birth = selectedDate;
    },
  },
  mounted() {
    if (this.$auth.check()) {
      this.getData();
    }
  },
};
</script>
