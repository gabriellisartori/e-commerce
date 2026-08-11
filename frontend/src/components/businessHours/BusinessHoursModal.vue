<script>
import BaseModal from "../generics/BaseModal.vue";

export default {
  components: {
    BaseModal,
  },
  data() {
    return {
      showModal: false,
      modalTitle: "Horário de funcionamento",
      businessHours: [
        {
          day_week: "Segunda",
          isOpen: false,
          hours: [{ starts_at: null, end_at: null }],
        },
        {
          day_week: "Terça",
          isOpen: false,
          hours: [{ starts_at: null, end_at: null }],
        },
        {
          day_week: "Quarta",
          isOpen: false,
          hours: [{ starts_at: null, end_at: null }],
        },
        {
          day_week: "Quinta",
          isOpen: false,
          hours: [{ starts_at: null, end_at: null }],
        },
        {
          day_week: "Sexta",
          isOpen: false,
          hours: [{ starts_at: null, end_at: null }],
        },
        {
          day_week: "Sábado",
          isOpen: false,
          hours: [{ starts_at: null, end_at: null }],
        },
        {
          day_week: "Domingo",
          isOpen: false,
          hours: [{ starts_at: null, end_at: null }],
        }
      ],
    };
  },
  methods: {
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.$router.go(-1);
    },
    addHour(day) {
      day.hours.push({ start_time: "", end_time: "" });
    },
    async getData() {
      const { data } = await this.$http.get("/business-hours");
      if (!data.length) return;
      this.businessHours = data;
      this.businessHours.forEach((day) => {
        day.isOpen = day.hours[0].starts_at != null ? true : false;
      });
    },
    allowedHours(day) {
      return day.isOpen && day.hours.length < 2;
    },
    removeHour(day) {
      if (day.hours.length > 1) {
        day.hours.pop();
      } else {
        this.removeAllHours(day);
      }
    },
    removeAllHours(day) {
      day.isOpen = !day.isOpen;
      day.hours = [{ starts_at: null, end_at: null }];
    },
    async submit() {
      this.businessHours.forEach((day) => {
        if (day.isOpen && day.hours.length > 1) {
          this.businessHours.push({
            day_week: day.day_week,
            isOpen: true,
            hours: day.hours[1],
          });
          day.hours.pop();
        }
      });
      this.businessHours = {
        days: this.businessHours,
      };

      await this.$http.post("/business-hours", this.businessHours);
      this.closeModal();
    },
    isMobile() {
      if (
        /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
          navigator.userAgent
        )
      ) {
        return true;
      } else {
        return false;
      }
    },
  },
  mounted() {
    this.getData();
  },
};
</script>

<template>
  <BaseModal
    :modalTitle="modalTitle"
    size="large"
    @save="submit"
    @cancel="closeModal"
    @close="closeModal"
  >
    <div class="business-hours">
      <div v-for="(day, index) in businessHours" :key="index" :class=" { 'business-hours-items': ! isMobile() }">
        <div :class="isMobile() ? 'business-hours-items' : 'contents'">
          <div class="business-hours-day-week">{{ day.day_week }}</div>

          <base-switch
            v-model="day.isOpen"
            :id="index"
            @update:modelValue="
              removeAllHours(day);
              day.isOpen = !day.isOpen;
            "
          />
        </div>

        <div v-if="day.isOpen" style="display: contents">
          <div
            v-for="(hour, index) in day.hours"
            :key="index"
            style="display: contents"
          >
            <div :class="isMobile() ? 'business-hours-items' : 'contents'">
              <base-time
                v-model="hour.starts_at"
                class="input time"
                @update:modelValue="hour.starts_at = $event"
              />

              <p style="margin-right: 15px">até</p>

              <base-time
                v-model="hour.end_at"
                class="input time"
                @update:modelValue="hour.end_at = $event"
              />
            </div>
          </div>
        </div>

        <p v-if="!day.isOpen">Fechado</p>

        <base-button
          v-if="day.isOpen"
          isTransparent
          isIcon
          icon="fa-solid fa-trash"
          @click="removeHour(day)"
        />

        <base-button
          isTransparent
          v-if="allowedHours(day)"
          @click="addHour(day)"
          >Adicionar</base-button
        >
      </div>
    </div>
  </BaseModal>
</template>

<style lang="scss">
.business-hours {
  &-items {
    display: flex;
    align-items: center;
    height: 54px;

    .business-hours-day-week {
      margin-right: 15px;
      min-width: 110px;
      font-weight: 600;
    }

    .switch {
      margin-top: 0px !important;
      margin-right: 15px;
    }
  }

  .input {
    width: 10% !important;
    margin-top: 0px !important;

    .baseInput {
      margin-top: 0px !important;
    }
  }

  .time {
    margin-right: 15px;
  }

  .contents {
    display: contents;
  }
}
</style>