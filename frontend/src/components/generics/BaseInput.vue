<script>
export default {
  props: ['modelValue', 'label', 'placeholder', 'mask'],
  data() {
    return {
      inputValue: ''
    };
  },
  methods: {
    updateValue() {
      this.$emit('update:modelValue', this.inputValue);
    }
  },
  watch: {
    modelValue: {
      immediate: true,
      handler(value) {
        this.inputValue = value;
      }
    }
  }
};
</script>

<template>
  <div class="base-input-div">
    <label class="base-label">{{ label }}</label>
    <input 
      class="base-input"
      :value="inputValue" 
      @input="updateValue" 
      :placeholder="placeholder" 
      />      
  </div>
</template>

<style lang="scss">
.base-input-div{
    margin-bottom: 20px;

/*     .base-label {
        display: block;
        color: #7A7373;
        font-weight: bold;
    } */
    
/*     .base-input {
        width: -webkit-fill-available;
        height: 20px;
        padding: 10px;
        border: 1px solid #5F8A17;
        border-radius: 16px;
        margin-top: 10px; 
        outline: none; 
    } */
  }
  </style>
  