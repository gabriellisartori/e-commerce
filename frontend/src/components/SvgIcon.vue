<script setup>
import { defineProps, defineAsyncComponent, computed } from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
});

const svg = computed(() => defineAsyncComponent(() => import(`@/assets/svg/${props.name}.svg`)));
</script>

<template>
    <!-- nao ta funcionando, vou ajustar -->
    <component :is="svg"></component>
</template>
  

  