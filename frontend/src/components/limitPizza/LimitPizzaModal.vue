<script>
import { toast } from "vue3-toastify";
import moment from "moment";

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
        quantity: 0,
      },
      showModal: false,
      showDateModal: false,
    };
  },
  computed: {
    modalTitle() {
      return this.id
        ? "Editar limite diário de pizzas"
        : "Adicionar limite diário de pizzas";
    },
    formattedDate() {
      return this.form.date ? moment(this.form.date).format("DD/MM/YYYY") : '';
    }
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
      console.log("data recebida", this.form.date)
      this.showDateModal = false;
    },
    async saveLimit() {
      try {
        if (this.id) {
          this.form.id = this.id;


          let dataString = this.form.date;
          let dataFormatada = moment(dataString, 'DD/MM/YYYY').format('YYYY-MM-DD');
          this.form.date = dataFormatada;

          console.log(this.form)
          await this.$http.put(
            `/daily-pizza-sale-limits/${this.id}`,
            this.form
          );
        } else {
          console.log(this.form)
          await this.$http.post("/daily-pizza-sale-limits", this.form);
        }

        this.$emit("limitSave");
        this.$emit("close");

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });
      } catch (error) {
        console.error("Erro ao salvar o limite diário de pizza:", error);
      }
    },
    async getData() {
      try {
        const { data } = await this.$http.get(
          `/daily-pizza-sale-limits/${this.id}`
        );

        this.form = data;
        this.form.date = moment(data.date).format("DD/MM/YYYY");
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
  <base-modal :modalTitle="modalTitle" @close="closeModal" @save="saveLimit">
    <div class="limit-pizza">
      <base-input 
        v-model="form.quantity" 
        label="Quantidade" 
        type="number" 
        class="input"
        :placeholder="'Quantidade de pizzas'" 
        @update:modelValue="form.quantity = $event" 
      />

      <base-date 
        :showModal="showDateModal" 
        @date-selected="updateDate" 
        :formattedDate="formattedDate" 
      />
    </div>
  </base-modal>
</template>

<style lang="scss">
.limit-pizza {
  display: flex;
  justify-content: space-evenly;
}
</style>