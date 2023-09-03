<script setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps(['modelValue', 'label', 'placeholder']);
const emits = defineEmits(['update:modelValue']);

// Variável reativa para o valor do input
const inputValue = ref(props.modelValue);

const updateValue = (newValue) => {
  inputValue.value = newValue;
  emits('update:modelValue', inputValue.value);
};
</script>

<template>
    <div>
      <label>{{ label }}</label>
      <input :value="modelValue" @input="updateValue" :placeholder="placeholder" />
    </div>
  </template>

<style lang="scss">
  div {
    margin-bottom: 20px;

    label {
        display: block;
        color: #7A7373;
        font-weight: bold;
    }
    
    input {
        width: -webkit-fill-available;
        height: 25px;
        padding: 10px;
        border: 1px solid #5F8A17;
        border-radius: 16px;
        margin-top: 10px;
        outline: none; 
    }
  }
  </style>
  