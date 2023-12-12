<script>
/* import { ref, watch } from 'vue';
 */import { format, parseISO } from 'date-fns';

export default {
  props: {
    formattedDate: Date,
    label: {
      type: String,
      default: 'Data',
    },
    modelValue: String
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
  watch: {
    modelValue: {
      immediate: true,
      handler(newVal) {
        console.log('emtrei')
        const dateObject = parseISO(newVal);

        if (!isNaN(dateObject)) {
          const formattedDate = format(dateObject, 'dd/MM/yyyy');
          this.form.date = formattedDate;
        } else {
          console.error("Invalid date value");
        }
      },
    },
  },
  methods: {
    closeModal() {
      this.showModal = false;
      this.showDatePicker = false;
      this.$emit('close');
    },
    onDateSelected() {
      const selectedDate = this.date;

      if (selectedDate instanceof Date && !isNaN(selectedDate)) {
        console.log('www')
        const formattedDate = format(selectedDate, 'dd/MM/yyyy');
        this.form.date = formattedDate;
        this.$emit('date-selected', formattedDate);
        this.showDatePicker = false;
      } else {
        console.error("Invalid date value");
      }
    },
  },

};
</script>

<template>
  <div>
    <base-input :label="label" v-model="form.date" class="input date" @click="showDatePicker = true" />
    <base-modal @close="closeModal" :showButtons="false" v-if="showDatePicker" id="custom-modal">
      <VDatePicker v-model="date" color="green" mode="date" class="calendar" @click="onDateSelected" />
    </base-modal>
  </div>
</template>

<style lang="scss">
.modal {
  overflow-y: initial !important;
}

.calendar {
  margin: 0 auto;
  border: 1px solid var(--cor-primaria);
}
</style>

