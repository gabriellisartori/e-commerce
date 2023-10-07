<script>
import BaseModal from '../generics/BaseModal.vue';
import BaseInput from '../generics/BaseInput.vue';
import BaseDataPicker from '../generics/BaseDataPicker.vue';
import BaseTimePicker from '../generics/BaseTimePicker.vue';

export default {
  data() {
    return {
      showModal: false,
      limit: '',
      modalTitle: 'DEFINIR LIMITE DE PIZZAS',
      date: '',
      selectedTime: ''
    };

  },
  components: {
    BaseModal,
    BaseInput,
    BaseDataPicker,
    BaseTimePicker,
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
  <BaseModal :modalTitle="modalTitle">

    <div class="div-settings">
      <BaseInput label="Limite" class="input name" v-model="limit" />
      <BaseDataPicker label="Data" v-model="date" type="date" class="input data" @update:modelValue="updateDate"></BaseDataPicker>
      <BaseTimePicker label="Início" v-model="selectedTime" class="input" @update:modelValue="updateTime"/>
      <BaseTimePicker label="Fim" v-model="selectedTime" class="input" @update:modelValue="updateTime"/>
    </div>

    <div class="content-buttons">
      <button class="button cancel" @click="closeModal">
        CANCELAR
      </button>
      <button class="button filled">
        SALVAR
      </button>
    </div>
  </BaseModal>
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