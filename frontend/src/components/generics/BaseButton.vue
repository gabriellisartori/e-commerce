<script>
export default {
  name: "BaseButton",
  props: {
    type: {
      type: String,
      default: "button",
      validator: (value) => ["button", "submit", "reset"].includes(value),
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    loading: {
      type: Boolean,
      default: false,
    },
    to: {
      type: [String, Object],
      default: undefined,
    },
    href: {
      type: String,
      default: undefined,
    },
    size: {
      type: String,
      default: "medium",
      validator: (value) => ["small", "medium", "large"].includes(value),
    },
    color: {
      type: String,
      default: "green",
      validator: (value) => ["green", "basic", "dark-green"].includes(value),
    },
    icon: {
      type: String,
      default: undefined,
    },
    isIcon: {
      type: Boolean,
      default: false,
    },
    isRounded: {
      type: Boolean,
      default: false,
    },
    isTransparent: {
      type: Boolean,
      default: false,
    },
    isOutlined: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    isDisabled() {
      return this.disabled || this.loading;
    },
    computedClasses() {
      return [
        "base-button",
        `is-${this.size}`,
        `is-${this.color}`,
        {
          "is-rounded": this.isRounded,
          "is-outlined": this.isOutlined,
          "is-transparent": this.isTransparent,
          "is-flat": !this.isOutlined && !this.isTransparent,
          "is-disabled": this.disabled,
          "is-icon": this.isIcon,
        },
      ];
    },
    computedTag() {
      if (this.disabled) {
        return "span";
      }
      if (this.to) {
        return "router-link";
      }
      if (this.href) {
        return "a";
      }
      return "button";
    },
    computedType() {
      return this.computedTag === "button" ? this.type : undefined;
    },
  },
  methods: {
    onClick() {
      if (this.isDisabled) {
        return;
      }
      this.$emit("onClick");
    },
  },
};
</script>

<template>
  <component
    :is="computedTag"
    :type="computedType"
    :to="to"
    :href="href"
    :disabled="isDisabled"
    :class="computedClasses"
    @click="onClick"
  >
    <span class="base-button-content">
      <font-awesome-icon v-if="icon" :icon="icon" />
      <slot />
    </span>
  </component>
</template>
