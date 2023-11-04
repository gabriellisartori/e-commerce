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
    closeModal() {
      this.showModal = false;
      this.$emit('close');
    },
    onDateSelected() {
      const formattedDate = format(this.date, 'dd/MM/yyyy');
      console.log(formattedDate)
      this.$emit('date-selected', formattedDate);
    },
    openModal() {
      this.showModal = true;
    },
  },

  setup(props) {
    const date = ref(new Date(props.formattedDate + 'T00:00:00'));
    console.log(props.formattedDate)

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

<template>
  <base-modal @close="closeModal" :showButtons="false">
    <VDatePicker v-model="date" color="green" mode="date" id="calendar" @click="onDateSelected" />
  </base-modal>
</template>

<style lang="scss">
#calendar{
  margin: 0 auto;
  border: 1px solid var( --cor-primaria);
}
</style>

