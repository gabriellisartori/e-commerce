<script>
import { toast } from "vue3-toastify";
import LimitPizzaModal from "../../components/limitPizza/LimitPizzaModal.vue";
import moment from "moment";
import FiltersModal from '@/components/FiltersModal.vue';

export default {
  components: {
    LimitPizzaModal,
    FiltersModal
  },
  data() {
    return {
      limits: [],
      showModal: false,
      id: null,
      search: {
        start_date: null,
        end_date: null
      },
      showFilters: false
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
        const { data } = await this.$http.get("/daily-pizza-sale-limits", {
          params: this.search
        });
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
    },
    searchFilter (event) {
      this.search.start_date = event.start_date;
      this.search.end_date = event.end_date;
      this.fetchLimits();
    },
    getAll () {
      this.search.start_date = null;
      this.search.end_date = null;
      this.fetchLimits();
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
      <div>
        <h2 class="title">Limite de pizzas</h2>
      </div>
      <div>
        <base-button isTransparent color="dark-green" @onClick="showModal = true">
        Adicionar
        </base-button>
        <base-button class="icon" isTransparent isIcon icon="fa-solid fa-magnifying-glass" color="dark-green" @onClick="showFilters = true"/>
        <base-button class="icon" isTransparent isIcon icon="fa-solid fa-rotate" color="dark-green" @onClick="getAll"/>
      </div>
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

  <FiltersModal 
    v-if="showFilters"
    isPeriod
    @close="showFilters = false"
    @getValues="searchFilter($event)"
  />
</template>