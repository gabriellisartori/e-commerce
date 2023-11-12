<script>
import { ref } from 'vue';
import { format } from 'date-fns';

export default {
  props: {
    formattedDate: Date,
    label: {
      type: String,
      default: 'Data',
    },
  },
  data() {
    return {
      form: {
        date: '',
      },
      showModal: false,
      showDatePicker: false,
    };
  },
  methods: {
    closeModal() {
      this.showModal = false;
      this.showDatePicker = false;
      this.$emit('close');
    },
    onDateSelected() {
      const formattedDate = format(this.date, 'dd/MM/yyyy');
      this.form.date = formattedDate;
      this.$emit('date-selected', formattedDate);
      this.showDatePicker = false;
    }
  },

  setup(props) {
    const date = ref(new Date(props.formattedDate + 'T00:00:00'));

    return { date };
  }
};
</script>

<template>
  <div>
    <base-input :label="label" v-model="form.date" class="input date" @click="showDatePicker = true" />
    <base-modal @close="closeModal" :showButtons="false" v-if="showDatePicker">
      <VDatePicker v-model="date" color="green" mode="date" class="calendar" @click="onDateSelected" />
    </base-modal>
  </div>
</template>

<style lang="scss">
.calendar {
  margin: 0 auto;
  border: 1px solid var(--cor-primaria);

}
</style>

