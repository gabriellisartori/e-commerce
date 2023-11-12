<script>
import { toast } from "vue3-toastify";
import moment from "moment";
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
      form: {
        quantity: null,
        date: null,
      },
      showModal: false,
      showDateModal: false,
      v$: useVuelidate(),
      errorMessage: "",
      error: false,
    };
  },
  validations() {
    return {
      form: {
        quantity: { required$ },
        date: { required$ },
      },
    };
  },
  computed: {
    modalTitle() {
      return this.id
        ? "Editar limite diário de pizzas"
        : "Adicionar limite diário de pizzas";
    },
  },
  methods: {
    closeDateModal() {
      this.showDateModal = false;
    },
    closeModal() {
      this.$emit("close");
    },
    updateDate(selectedDate) {
      this.form.date = selectedDate;
      console.log("data recebida", this.form.date);
      this.showDateModal = false;
    },
    async saveLimit() {
      this.v$.$validate();
      if (this.v$.$error) {
        return;
      }

      try {
        if (this.id) {
          this.form.id = this.id;

          let dataString = this.form.date;
          let dataFormatada = moment(dataString, "DD/MM/YYYY").format(
            "YYYY-MM-DD"
          );
          this.form.date = dataFormatada;

          console.log(this.form);
          await this.$http.put(
            `/daily-pizza-sale-limits/${this.id}`,
            this.form
          );
        } else {
          console.log(this.form);
          await this.$http.post("/daily-pizza-sale-limits", this.form);
        }

        this.$emit("limitSave");
        this.$emit("close");

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });
      } catch (error) {
        this.error = true;
        this.errorMessage = "Erro ao salvar o limite diário de pizza";
        console.error("Erro ao salvar o limite diário de pizza:", error);
      }
    },
    async getData() {
      try {
        const { data } = await this.$http.get(
          `/daily-pizza-sale-limits/${this.id}`
        );

        this.form = data;
/*         this.form.date = moment(data.date).format("DD/MM/YYYY");
 */      } catch (error) {
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
  <base-modal :modalTitle="modalTitle" @close="closeModal" @save="saveLimit">
    <div class="limit-pizza">
      <div>
        <base-input
          v-model="form.quantity"
          label="Quantidade"
          type="number"
          class="input"
          :placeholder="'Quantidade de pizzas'"
          @update:modelValue="form.quantity = $event"
        />
        <div
          :class="{ 'error-message': v$.form.quantity.$error }"
          v-if="v$.form.quantity.$error"
        >
          {{ v$.form.quantity.$errors[0].$message }}
        </div>
      </div>

      <div>
        <base-date
          v-model="form.date" 
          type="date" 
          @date-selected="updateDate"
          @update:modelValue="form.date = $event"
        />
        <div
          :class="{ 'error-message': v$.form.date.$error }"
          v-if="v$.form.date.$error"
        >
          {{ v$.form.date.$errors[0].$message }}
        </div>
      </div>
    </div>
    <base-message v-if="error" :errorMessage="errorMessage" />
  </base-modal>
</template>

<style lang="scss">
.limit-pizza {
  display: flex;
  justify-content: space-evenly;
}
</style>