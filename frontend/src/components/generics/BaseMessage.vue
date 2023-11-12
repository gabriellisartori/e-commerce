<template>
    <div class="message">
        <font-awesome-icon icon="fa-solid fa-triangle-exclamation" />
        <span>{{ errorMessage }}</span>
    </div>
</template>

<script>
export default {
    props: {
        errorMessage: {
            type: String,
            required: true
        }
    }
}
</script>

<style lang="scss">
.message {
    width: 100%;
    padding: 10px;
    color: white;
    font-family: 'Inria Sans', sans-serif !important;
    border: 2px solid red;
    background-color: #ff8e8e;
    font-weight: 700;
    border-radius: 1rem;
    margin-bottom: 1rem;
    margin-top: 1rem;

    .fa-triangle-exclamation {
        color: red;
        margin-right: 8px;
    }
}
</style>