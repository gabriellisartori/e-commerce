<template>
  <div class="promotion-modal">
    <base-modal :modalTitle="modalTitle" @cancel="closeModal" @close="closeModal" @save="submit">
      <base-input 
        label="Nome" 
        class="input name" 
        v-model="promotion.name" 
      />
      <div :class="{ 'error-message': v$.promotion.name.$error }" v-if="v$.promotion.name.$error">
        {{ v$.promotion.name.$errors[0].$message }}
      </div>

      <div class="content">
        <div class="content-message-error">
          <base-date label="Dia de início" 
            v-model="promotion.start_date" 
            type="date" 
            class="input date"
            @date-selected="updateStartDate" 
            @update:modelValue="promotion.start_date = $event">
          </base-date>
          <div :class="{ 'error-message': v$.promotion.start_date.$error }" v-if="v$.promotion.start_date.$error">
            {{ v$.promotion.start_date.$errors[0].$message }}
          </div>
        </div>

        <div>
          <base-time 
            label="Hora de início" 
            v-model="promotion.start_time" 
            class="input"
            @update:modelValue="promotion.start_time = $event" />
          <div :class="{ 'error-message': v$.promotion.start_time.$error }" v-if="v$.promotion.start_time.$error">
            {{ v$.promotion.start_time.$errors[0].$message }}
          </div>
        </div>
      </div>
      <div class="content">
        <div class="content-message-error">
          <base-date label="Dia final" v-model="promotion.end_date" type="date" class="input date"
            @date-selected="updateEndDate" @update:modelValue="promotion.end_date = $event"></base-date>
          <div :class="{ 'error-message': v$.promotion.end_date.$error }" v-if="v$.promotion.end_date.$error">
            {{ v$.promotion.end_date.$errors[0].$message }}
          </div>
        </div>

        <div>
          <base-time label="Hora final" v-model="promotion.end_time" class="input"
            @update:modelValue="promotion.end_time" />
          <div :class="{ 'error-message': v$.promotion.end_time.$error }" v-if="v$.promotion.end_time.$error">
            {{ v$.promotion.end_time.$errors[0].$message }}
          </div>
        </div>
      </div>
      <base-message v-if="error" :errorMessage="errorMessage" />
    </base-modal>
  </div>
</template>

<script>
import { toast } from "vue3-toastify";
import { useVuelidate } from "@vuelidate/core";
import { required$ } from "../../store/validators";

export default {
  props: {
    id: {
      type: Number,
      default: null,
    },
  },
  data() {
    return {
      promotion: {
        id: "",
        name: "",
        start_date: "",
        start_time: "",
        end_date: "",
        end_time: "",
      },
      v$: useVuelidate(),
      errorMessage: "",
      error: false,
    };
  },
  validations() {
    return {
      promotion: {
        name: { required$ },
        start_date: { required$ },
        start_time: { required$ },
        end_date: { required$ },
        end_time: { required$ },
      },
    };
  },
  computed: {
    modalTitle() {
      return this.id ? "Editar promoção" : "Adicionar promoção";
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
    },
    updateStartDate(selectedDate) {
      this.promotion.start_date = selectedDate;
      console.log("data recebida", this.promotion.start_date);
      this.showDateModal = false;
    },
    updateEndDate(selectedDate) {
      this.promotion.end_date = selectedDate;
      console.log("data final recebida", this.promotion.end_date);
      this.showDateModal = false;
    },
    async getData() {
      try {
        const { data } = await this.$http.get(`/promotions/${this.id}`);
        this.promotion = data;
        console.log(this.promotion.end_date);
      } catch (error) {
        console.error(error);
      }
    },
    async submit() {
      this.v$.$validate();
      if (this.v$.$error) {
        return;
      }
      try {
        if (this.id) {
          await this.$http.put(`/promotions/${this.id}`, this.promotion);
        } else {
          await this.$http.post("/promotions", this.promotion);
        }
        this.$emit("savePromotion");
        this.$emit("close");

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });
      } catch (error) {
        this.error = true;
        this.errorMessage = "Erro ao salvar a promoção";
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

<style lang="scss">
.promotion-modal {
  .content {
    width: 100%;
    display: flex;
    justify-content: space-between;

    &-message-error {
      width: 100%;
      margin-right: 45px;
    }

    .date {
      width: 100% !important;
    }

    .input {
      width: 100%;
    }
  }
}
</style>