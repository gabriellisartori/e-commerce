<script>
export default {
  props: {
    modelValue: {
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
  },
};
</script>

<template>
  <div class="base-textarea">
    <label class="base-label">{{ label }}</label>
    <textarea
      rows="4"
      cols="50"
      class="base-textarea-input"
      :value="modelValue"
      :placeholder="placeholder"
      @input="$emit('update:modelValue', $event.target.value)"
    />
  </div>
</template>
  
<style lang="scss">
.base-textarea {
  .base-label {
    display: block;
    color: var(--cor-fonte);
    font-weight: bold;
    margin-top: 1rem;
  }

  .base-textarea-input {
    padding: 10px;
    border: 1px solid var(--cor-primaria);
    border-radius: 16px;
    margin-top: 10px;
    outline: none;
  }
}
</style>