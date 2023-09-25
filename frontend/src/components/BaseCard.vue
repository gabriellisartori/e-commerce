<script setup>
</script>

<template>
    <div class="card">
        <slot></slot>
    </div>
</template>

<style lang="scss">
.card{
    width: 400px;
    height: 100px;
    border: 1px solid #5F8A17;
    border-left: 15px solid #5F8A17;
    border-radius: 10px;
    margin-top: 42px;
}
</style>