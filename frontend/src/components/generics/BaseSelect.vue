<template>
    <select :value="selectedValue" class="form-control" @input="$emit('update:selectedValue', $event.target.value)">
      <option v-for="option in options" :key="option.id" :value="option.id">
        {{ option.name }}
      </option>
    </select>
  </template>
  
  <script>
  export default {
    props: {
      options: Array,
      selectedValue: [String, Number]
    }
  };
  </script>
  
  <style scoped lang="scss">
  .form-control {
    width: 200px;
  }
  </style>
  