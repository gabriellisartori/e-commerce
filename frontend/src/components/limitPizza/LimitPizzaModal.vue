<script>
import BaseDatePicker from '../generics/BaseDatePicker.vue';

export default {
  emits: ['close'], 
  data() {
    return {
      limit: '',
      modalTitle: 'DEFINIR LIMITE DE PIZZAS',
      selectedTime: '',
      endTime: '',
      showDatepicker: false,
      selectedDate: '',
      showModal: false,
    };
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.$emit('close');
    },
    updateDate(newValue) {
      this.date = newValue;
      console.log(this.date);
    },
    updateStartTime(newValue) {
      this.selectedTime = newValue;
      console.log(this.selectedTime);
    },
    updateEndTime(newValue) {
      this.endTime = newValue;
      console.log(this.endTime);
    },
  },
  components: { BaseDatePicker },
};
</script>

<template>
  <base-modal :modalTitle="modalTitle" @cancel="closeModal">
    <div class="div-settings">
      <base-input label="Limite" class="input name" v-model="limit" />
      <base-input label="Data" @click="showModal = true" class="input" @update:modelValue="updateStartTime" />
      <base-time label="Início" v-model="selectedTime" class="input" @update:modelValue="updateStartTime" />
      <base-time label="Fim" v-model="endTime" class="input" @update:modelValue="updateEndTime" />
    </div>
  </base-modal>
  <BaseDatePicker v-if="showModal" class="datepicker-modal"></BaseDatePicker>
</template>

<style lang="scss">
.div-settings {
  margin-top: 35px;
  display: flex;
  flex-direction: row;
  justify-content: space-between;

  .base-input-div {
    width: 22%;

    .base-input {
      height: 25px;
    }
  }

  .name {
    .base-input {
      color: var(--cor-fonte);
      font-weight: 700;
      font-size: 14px;
    }
  }
}

.datepicker-modal{
  z-index: 9999;
}
</style>