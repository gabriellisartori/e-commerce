<script>
export default {
    props: ['modelValue', 'label'],

    data() {
        return {
            times: Array.from({ length: 96 }, (_, i) => {
                const hour = Math.floor(i / 4);
                const minute = i % 4 * 15;
                return `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
            }),
            selectedTime: null
        };
    },
    watch: {
        selectedTime(newValue) {
            this.$emit('update:modelValue', newValue);
        }
    },
};
</script>

<template>
    <div class="time-picker">
        <label for="time" class="base-label">{{ label }}</label>
        <select v-model="selectedTime" id="time" class="base-input">
            <option class="custom-option" v-for="time in times" :key="time" :value="time">{{ time }}</option>
        </select>
    </div>
</template>
  

  
<style scoped lang="scss">
.time-picker {
    display: flex;
    flex-direction: column;

    .base-input {
        height: 47px;
        width: 117px;
        appearance: none;
        color: var(--cor-fonte);
        font-weight: 700;
        font-size: 14px;

        &::after {
            content: '\25BE';
            font-size: 16px;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .custom-option {
            height: 5% !important;

            &:focus {
                appearance: none;
                background-color: green !important;
            }
        }

        &::-webkit-scrollbar {
            width: 5px;

        }

        &::-webkit-scrollbar-thumb {
            background-color: var(--cor-secundaria);
            border-radius: 16px;
        }
    }
}
</style>
  