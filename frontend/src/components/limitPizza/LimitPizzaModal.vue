<script>
import { toast } from "vue3-toastify";

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
        date: "",
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
    closeModal() {
      this.$emit("close");
    },
    async saveLimit() {
      try {
        if (this.id) {
          this.form.id = this.id;

          await this.$http.put(
            `/daily-pizza-sale-limits/${this.id}`,
            this.form
          );
        } else {
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
        label="Data"
        v-model="form.date"
        type="date"
        class="input date"
        @date-selected="form.date = $event"
      >
      </base-date>
    </div>
  </base-modal>
</template>

<style lang="scss">
.limit-pizza {
  display: flex;
}
</style>