

<script>
export default {
  name: "BaseChipCheckbox",
  props: {
    modelValue: {
      type: Boolean,
      default: false,
    },
    myCheckbox: {
      type: String,
      default: undefined,
      required: true,
    },
    label: {
      type: String,
      default: undefined,
    },
    color: {
      type: String,
      default: "green",
      validator: (value) => ["green", "basic", "dark-green"].includes(value),
    },
    size: {
      type: String,
      default: "medium",
      validator: (value) => ["small", "medium", "large"].includes(value),
    },
  },
  data() {
    return {
      isChecked: false,
    };
  },
  watch: {
    isChecked() {
      this.isChecked = !this.modelValue;
      this.$emit("input", this.isChecked);
    },
  },
  computed: {
    classes() {
      return [`is-${this.color}`, `is-${this.size}`];
    },
  },
};
</script>

<template>
  <div class="chip-checkbox" :class="classes">
    <input
      class="chip-checkbox-input"
      type="checkbox"
      :id="myCheckbox"
      :value="modelValue"
    />
    <label class="chip-checkbox-label" :for="myCheckbox">{{ label }}</label>
  </div>
</template>
