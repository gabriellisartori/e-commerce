<script>
import { toast } from "vue3-toastify";
import LimitPizzaModal from "../../components/limitPizza/LimitPizzaModal.vue";
import moment from "moment";

export default {
  components: {
    LimitPizzaModal,
  },
  data() {
    return {
      limits: [],
      showModal: false,
      id: null,
    };
  },
  methods: {
    openEditModal(limitId) {
      this.id = limitId;
      this.showModal = true;
    },
    closeModal() {
      this.id = null;
      this.showModal = false;
    },
    async fetchLimits() {
      try {
        const { data } = await this.$http.get("/daily-pizza-sale-limits");
        this.limits = data;

        this.limits.map((limit) => {
          limit.date = moment(limit.date).format("DD/MM/YYYY");
        });
      } catch (error) {
        console.error(error);
      }
    },
    async deleteLimit(limitId) {
      const confirmed = await this.$swal.fire({
        icon: "warning",
        title: "Realmente deseja excluir?",
        text: "Você não poderá reverter isso!",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sim, excluir",
        reverseButtons: true,
      });

      if (confirmed.isConfirmed) {
        try {
          await this.$http.delete(`/daily-pizza-sale-limits/${limitId}`);
          this.fetchLimits();

          toast.success("Limite de pizza excluído!", {
            position: toast.POSITION.BOTTOM_LEFT,
          });
        } catch (error) {
          console.error(error);
          this.$swal.fire(
            "Erro!",
            "Ocorreu um erro ao excluir o limite de pizza.",
            "error"
          );
        }
      }
    }
  },
  mounted() {
    this.fetchLimits();
  },
};
</script>

<template>
  <div>
    <div class="page-header-options">
      <h2 class="title">Limite de pizzas</h2>
      <base-button isTransparent color="dark-green" @onClick="showModal = true">
        Adicionar
      </base-button>
    </div>

    <div class="content-ingredient">
      <base-card
        v-for="limit in limits"
        :key="limit.id"
        :title="limit.date"
        :subtitle="`Limite: ${limit.quantity}`"
        @edit="openEditModal(limit.id)"
        @delete="deleteLimit(limit.id)"
      />
    </div>
  </div>

  <LimitPizzaModal
    v-if="showModal"
    :id="id"
    @close="closeModal"
    @limitSave="fetchLimits"
  />
</template>