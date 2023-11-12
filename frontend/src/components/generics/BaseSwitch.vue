<script>
export default {
    props: ['modelValue', 'label', 'id'],
    methods: {
        updateValue(event) {
            const newValue = event.target.checked;
            this.$emit('update:modelValue', newValue);
        }
    },
    data() {
        return {
            isChecked: this.value || false,
        };
    },
};
</script>

<template>
    <div class="switch">
        <p>{{ label }}</p>
        <input type="checkbox" :id="id" class="switch-input" :checked="modelValue" @change="updateValue">
        <label :for="id" class="switch-label"></label>
    </div>
</template>  
<style scoped lang="scss">
.switch {
    display: flex;
    flex-direction: column;
    /* width: 30%; */
    margin-top: 32px;
    /*  margin-left: 50px; */
    justify-content: space-evenly;
    color: var(--cor-fonte);
    font-weight: 700;

    .switch-input {
        display: none;
    }

    .switch-label {
        position: relative;
        cursor: pointer;
        top: 0;
        height: 25px;
        width: 50px;
        right: 0;
        bottom: 0;
        background-color: var(--cor-site) !important;
        border-radius: 34px;
        border: 1px solid var(--cor-primaria) !important;
        transition: background-color 0.3s;

        &:before {
            position: absolute;
            content: "";
            width: 20px;
            height: 20px;
            left: 1px;
            bottom: 3px;
            background-color: var(--cor-primaria) !important;
            border-radius: 50%;
            transition: transform 0.3s;
        }
    }

    .switch-input:checked+.switch-label {
        background-color: var(--cor-primaria) !important;
    }

    .switch-input:checked+.switch-label:before {
        transform: translateX(26px);
        background-color: var(--cor-site) !important;
    }
}
</style>
  