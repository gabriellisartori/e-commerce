<script>
import { ref } from 'vue';
import { format } from 'date-fns';

export default {
  props: {
    formattedDate: String,
    modelValue: String,
  },
  data() {
    return {
      showModal: false,
    };
  },
  methods: {
    onDateSelected() {
      const formattedDate = format(this.date, 'dd/MM/yyyy');
      console.log(formattedDate)

      this.$emit('date-selected', formattedDate);
    },
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.$emit('close');
    },
  },

  setup() {
    const date = ref(new Date());

    const attrs = ref([
      {
        key: 'today',
        highlight: 'red',
        dates: new Date(),
      },
    ]);

    return { date, attrs };
  }
};
</script>

<!-- <template>
  <div class="data-modal">
    <div v-if="!showModal" class="overlay"></div>
    <VDatePicker v-model="date" color="green" mode="date" class="calendar" @click="onDateSelected" />
    <button>Selecionar</button>
  </div>
</template> -->

<template>
  <base-modal :button="true">
    <VDatePicker v-model="date" color="green" mode="date" class="calendar" @click="onDateSelected" />
    <button>Selecionar</button>
  </base-modal>
</template>

<style lang="scss">
.data-modal {
  .overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
  }

  .calendar {
    margin-left: 60px;
    border: 1px solid var(--cor-primaria) !important;
  }
}
</style>

