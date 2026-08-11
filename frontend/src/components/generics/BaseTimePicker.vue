<script>
export default {
    props: {
        label: String,
        modelValue: String
    },
    name: 'TimePicker',
    data() {
        return {
            showPicker: false,
            hours: [...Array(24).keys()],
            minutes: [...Array(60).keys()],
            selectedHour: null,
            selectedMinute: null,
            highlightedHour: null,
            highlightedMinute: null,
            selectedTimeDisplay: ''
        }
    },
    watch: {
        modelValue: {
            immediate: true,
            handler(newValue) {
                this.selectedTimeDisplay = newValue;
            }
        }
    },
    methods: {
        openPicker() {
            this.showPicker = true;
        },
        selectHour(hour) {
            this.selectedHour = hour;
            this.updateTimeDisplay();
        },
        selectMinute(minute) {
            this.selectedMinute = minute;
            this.updateTimeDisplay();
        },
        highlightHour(hour) {
            this.highlightedHour = hour;
        },
        unhighlightHour() {
            this.highlightedHour = null;
        },
        highlightMinute(minute) {
            this.highlightedMinute = minute;
        },
        unhighlightMinute() {
            this.highlightedMinute = null;
        },
        updateTimeDisplay() {
            if (this.selectedHour !== null && this.selectedMinute !== null) {
                const hour = String(this.selectedHour).padStart(2, '0');
                const minute = String(this.selectedMinute).padStart(2, '0');
                this.selectedTimeDisplay = `${hour}:${minute}`;
                this.showPicker = false;
                this.$emit('update:modelValue', this.selectedTimeDisplay);
            }
        }
    },
    mounted() {
        if (this.modelValue) {
            this.selectedTimeDisplay = this.modelValue;
        }
    }
}
</script>

<template>
    <div class="time-picker">
        <label class="label">{{ label }}</label>

        <input class="time-picker baseInput" type="text" v-model="selectedTimeDisplay" readonly @click="openPicker"
            ref="timeInput" />
        <div v-if="showPicker" class="picker">
            <div class="hours">
                <div v-for="hour in hours" :key="hour" @click="selectHour(hour)"
                    :class="{ 'selected': selectedHour === hour, 'highlighted': highlightedHour === hour }"
                    @mouseover="highlightHour(hour)" @mouseout="unhighlightHour">
                    {{ hour }}
                </div>
            </div>
            <div class="minutes">
                <div v-for="minute in minutes" :key="minute" @click="selectMinute(minute)"
                    :class="{ 'selected': selectedMinute === minute, 'highlighted': highlightedMinute === minute }"
                    @mouseover="highlightMinute(minute)" @mouseout="unhighlightMinute">
                    {{ minute < 10 ? '0' + minute : minute }} </div>
                </div>
            </div>
        </div>
</template>
  
<style scoped lang="scss">
.label {
    color: var(--cor-fonte);
    font-weight: 700;
}

.time-picker {
    margin-top: 1rem;
}

.input {
    width: 22%;

    .baseInput {
        border: 1px solid var(--cor-primaria);
        height: 20px;
        padding: 10px;
        border-radius: 16px;
        width: -webkit-fill-available;
        margin-top: 10px;
        font-size: 14px;
        text-align: center;

        &:focus{
            outline-color: var(--cor-primaria);
        }
    }

    .picker {
        display: flex;
        justify-content: space-between;
        position: absolute;
        background: white;
        z-index: 9999;
    }


    .hours,
    .minutes {
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        flex: 1;


        &::-webkit-scrollbar {
            width: 5px;
        }

        &::-webkit-scrollbar-thumb {
            background-color: var(--cor-primaria);
            border-radius: 10px !important;
        }

    }

    .hours div,
    .minutes div {
        padding: 10px;
        cursor: pointer;
        text-align: center;
        border-bottom: 1px solid #ccc;
    }

    .selected {
        background-color: var(--cor-secundaria);
        color: white;
    }

    .highlighted {
        background-color: var(--cor-primaria);
        color: var(--cor-site);
    }
}
</style>
  
  
  
  
  
  

  
  
  