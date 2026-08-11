<template>
    <component :is="svg"></component>
  </template>
  
  <script>
  import { defineAsyncComponent, computed } from 'vue';
  
  export default {
    props: {
      name: {
        type: String,
        required: true,
      },
    },
    setup(props) {
      const svg = computed(() =>
        defineAsyncComponent(() => import(`@/assets/svg/${props.name}.svg`))
      );
  
      return {
        svg,
      };
    },
  };
  </script>
  