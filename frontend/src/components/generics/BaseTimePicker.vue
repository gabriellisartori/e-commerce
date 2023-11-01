<script>
export default {
    props: {
        label: String,
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
                this.$emit('update:modelValue', this.selectedTimeDisplay); // Emitindo o evento para atualizar o v-model
            }
        }
    }
}
</script>

<template>
    <div class="time-picker">
        <label class="label">{{ label }}</label>

        <input class="time-picker abc" type="text" v-model="selectedTimeDisplay" readonly @click="openPicker"
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

.input {
    width: 100px;

    .abc {
        border: 1px solid var(--cor-primaria);
        height: 44px;
        border-radius: 16px;
        width: -webkit-fill-available;
        margin-top: 10px;
        font-size: 14px;
        padding-left: 10px;
    }

    .picker {
        display: flex;
        justify-content: space-between;
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
  
  
  
  
  
  

  
  
  