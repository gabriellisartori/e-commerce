<script>
export default {
  props: {
    options: Array,
    selectedValue: [String, Number],
    label: String
  }
};
</script>

<template>
  <div>
    <label class="base-label">{{label}}</label>

    <select :value="selectedValue" class="form-control base-input">
      <option value="" disabled selected>Selecione uma opção</option>
      <option v-for="option in options" :key="option.id" :value="option.id">
        {{ option.name }}
      </option>
    </select>
  </div>
</template>
  
  
<style scoped lang="scss">
.form-control {
  height: 44px;
  margin-bottom: 20px;
}
</style>
  