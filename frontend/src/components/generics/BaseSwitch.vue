<script>
import { ref } from 'vue';

export default {
    props: ['modelValue', 'label'],
    setup(props, { emit }) {
        const inputValue = ref(props.modelValue);

        const updateValue = (event) => {
            const newValue = event.target.checked;
            inputValue.value = newValue;
            emit('update:modelValue', newValue);
        };

        return {
            inputValue,
            updateValue
        };
    }
};
</script>

<template>
    <div class="switch">
        <p>{{ label }}</p>
        <input type="checkbox" id="mySwitch" class="switch-input" v-model="inputValue" @change="updateValue">
        <label for="mySwitch" class="switch-label"></label>
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
        height: 30px;
        width: 60px;
        right: 0;
        bottom: 0;
        background-color: var(--cor-site) !important;
        border-radius: 34px;
        border: 1px solid var(--cor-primaria) !important;
        transition: background-color 0.3s;

        &:before {
            position: absolute;
            content: "";
            width: 25px;
            height: 25px;
            left: 4px;
            bottom: 2px;
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
  