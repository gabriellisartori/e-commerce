<script>
export default {
  props: {
    modelValue: {
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
    mask: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: 'text',
    },
  },
};
</script>

<template>
  <div class="base-input-div">
    <label class="base-label">{{ label }}</label>
    <input 
      v-if="mask === ''"
      class="base-input"
      :value="modelValue" 
      :placeholder="placeholder"
      :type="type" 
      @input="$emit('update:modelValue', $event.target.value)" 
      />
      <input 
      v-else
      class="base-input"
      :value="modelValue" 
      :placeholder="placeholder"
      v-mask="mask"
      :type="type" 
      @input="$emit('update:modelValue', $event.target.value)" 
      /> 
  </div>
</template>

<style lang="scss">
.base-input-div{

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
  