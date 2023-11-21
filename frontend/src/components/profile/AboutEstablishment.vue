<template>
  <div class="profile-edit">
    <div class="profile-edit-about">
      <base-textarea
        v-model="form.description"
        label="Descrição"
        class="input"
      />
      <div
        :class="{ 'error-message': v$.form.description.$error }"
        v-if="v$.form.description.$error"
      >
        {{ v$.form.description.$errors[0].$message }}
      </div>
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
        id: null,
        description: "",
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
        description: { required$ },
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
        await this.$http.put("/establishments/about/1", this.form);

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });
      } catch (error) {
        this.error = true;
        this.errorMessage = "Erro ao salvar a descrição";
        console.error(error);
      }
    },
    async getData() {
      const { data } = await this.$http.get("/establishments");
      this.form.description = data.description;
      this.form.id = data.id;
    },
  },
  mounted() {
    this.getData();
  },
};
</script>

<style scoped>
.profile-edit-about {
  padding: 1rem;
}
</style>