<script>
export default {
  data() {
    return {
      limit: '',
      modalTitle: 'DEFINIR LIMITE DE PIZZAS',
      date: '',
      selectedTime: ''
    };

  },
  methods: {
    closeModal() {
      this.$emit('close');
    },
    updateDate(newValue) {
      this.date = newValue;
      console.log(this.date)
    },
    updateTime(newValue){
      this.selectedTime = newValue;
      console.log(this.selectedTime)
    }
  },
};

</script>

<template>
  <base-modal :modalTitle="modalTitle" @cancel="closeModal">
    <div class="div-settings">
      <base-input label="Limite" class="input name" v-model="limit" />
      <base-date label="Data" v-model="date" type="date" class="input data" @update:modelValue="updateDate"></base-date>
      <base-time label="Início" v-model="selectedTime" class="input" @update:modelValue="updateTime"/>
      <base-time label="Fim" v-model="selectedTime" class="input" @update:modelValue="updateTime"/>
    </div>
  </base-modal>
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
</style>