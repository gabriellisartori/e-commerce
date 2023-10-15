<script>
import VueDatePicker from '@vuepic/vue-datepicker';

const customDateFormat = (dateString) => {
  const dateObject = new Date(dateString);
  const day = dateObject.getDate();
  const month = dateObject.getMonth() + 1;
  const year = dateObject.getFullYear();

  return `${day}/${month}/${year}`;
}

export default {
  components: { VueDatePicker },
  props: ['modelValue', 'label'],
  
  data() {
    return {
      date: this.modelValue,
      showCalendarIcon: true,
      customDateFormat,

    };
  },
  watch: {
    date(newValue) {
      this.$emit('update:modelValue', newValue);
    }
  },
};
</script>

<template>
  <div class="base-input-div">
    <label class="base-label">{{ label }}</label>
    <VueDatePicker v-model="date" type="date" class="my-date base-input" :format="customDateFormat" locale="pt-br"></VueDatePicker>
  </div>
</template>

<style lang="scss">
.base-input-div {
  margin-bottom: 20px;
  width: auto;

  .base-label {
    display: block;
    color: #7A7373;
    font-weight: bold;
  }

  .my-date {
    width: -webkit-fill-available;
    height: 48px !important;
    border: 1px solid #5F8A17;
    border-radius: 16px;
    padding: 0px !important;
    outline: none;
    cursor: pointer;


    .dp__input_wrap {
      background-color: transparent !important;
      border: none;
      z-index: -1 !important;
      height: 47px;

      .dp__pointer {
        height: 46px;
      }

      .dp__icon {
        display: none;
      }

      .dp__input_icon_pad {
        padding-inline-start: 0px;
        font-size: 14px;
        margin-left: 12px;
        color: var(--cor-fonte);
        font-weight: 700;

        &.dp__input {
          border: none;
        }
      }
    }

    .dp__input_focus {
      border: none;
    }

    .dp--menu-wrapper {
      position: absolute;
      z-index: 99999;
      top: -44px !important;
      left: 103px !important;
      border-radius: 16px;

      .dp__menu {
        border-radius: 16px;
      }
    }

    .dp--tp-wrap {
      display: none !important;
    }

    .dp__arrow_top {
      display: none !important;
    }

    .dp__today {
      border: 1px solid var(--cor-primaria);
    }

    .dp__active_date {
      background-color: var(--cor-primaria);
    }

    .dp__action_buttons {
      display: flex;
      flex: auto;
      width: 100%;
      height: 40px;
      align-items: center;
      justify-content: space-around;
      margin-inline-start: auto;
      content: "teste";

      .dp__action_cancel {
        border: 1px solid var(--cor-primaria);
        height: 30px;
        border-radius: 10px;
        width: 80px;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .dp__action_select {
        background-color: var(--cor-primaria);
        height: 30px;
        border-radius: 10px;
        width: 80px;
        display: flex;
        justify-content: center;
        align-items: center;
      }
    }
  }
}
</style>
