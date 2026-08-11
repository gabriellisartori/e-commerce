<template>
  <div class="base-button-group">
    <base-button
      v-for="(option, index) in options"
      :key="option[itemValue]"
      :size="size"
      :color="color"
      :icon="option.icon"
      :class=" { 'is-selected': isSelected(option) }"
      isOutlined
      @click="toggle(option, index)"
    >
      {{ option[itemName] }}
    </base-button>
  </div>
</template>
  
  <script>
export default {
  name: "eui-button-group",
  props: {
    modelValue: {
      type: [String, Number, Boolean, Array],
      default: undefined,
    },
    size: {
      type: String,
      default: "medium",
    },
    color: {
      type: String,
      default: "green",
    },
    options: {
      type: Array,
      default: () => [],
    },
    itemValue: {
      type: String,
      default: "id",
    },
    itemName: {
      type: String,
      default: "name",
    },
  },
  methods: {
    isSelected(option) {
      return this.modelValue === option[this.itemValue];
    },
    toggle(option, index) {
      this.$emit("input", option[this.itemValue] || index);
    },
  },
};
</script>