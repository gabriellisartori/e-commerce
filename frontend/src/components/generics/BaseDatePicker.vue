<script>
import { ref } from 'vue';
import { format } from 'date-fns';

export default {
  props: {
    formattedDate: String, 
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

<template>
      <VDatePicker v-model="date" color="green" mode="date" class="calendar" @click="onDateSelected"/>
</template>

<style lang="scss">
  .calendar {
    margin-left: 60px;
    border: 1px solid var(--cor-primaria)!important;
  }
</style>

