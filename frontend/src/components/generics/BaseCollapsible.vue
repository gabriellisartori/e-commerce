<script>
export default {
    data() {
        return {
            isCollapsed: true,
        };
    },
    props: {
        title: {
            type: String,
            required: true,
        },
        icone: Boolean,
        phone: String,
    },
    computed: {
        whatsapp() {
            return `https://wa.me/55${this.phone}`;
        },
    },
    methods: {
        toggleCollapsible() {
            this.isCollapsed = !this.isCollapsed;
        },
    },
    computed: {
        formattedPhoneNumber() {
            const numericPhoneNumber = this.phoneNumber.replace(/\D/g, '');

            return numericPhoneNumber;
        },
    },
};
</script>

<template>
    <div>
        <div class="collapsible-header" @click="toggleCollapsible">
            {{ title }}
            <div class="actions-header">
                <base-button v-if="icone" class="whats" isRounded icon="fa-brands fa-whatsapp" :href="whatsapp" target="_blank"></base-button>
                <span :class="{ 'arrow-up': !isCollapsed, 'arrow-down': isCollapsed }"></span>
            <div class="actions-header" v-if="icone">
                <base-button  class="whats" isRounded icon="fa-brands fa-whatsapp"
                    :href="'https://wa.me/55' + formattedPhoneNumber" target="_blank"></base-button>
                <font-awesome-icon class="icon" :class="{ 'arrow-up': !isCollapsed, 'arrow-down': isCollapsed }"
                    icon="fa-solid fa-chevron-up" />
            </div>
            <font-awesome-icon v-else class="icon" :class="{ 'arrow-up': !isCollapsed, 'arrow-down': isCollapsed }"
                icon="fa-solid fa-chevron-up" />
        </div>
        <transition name="fade">
            <div v-show="!isCollapsed" class="collapsible-content">
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

  
<style scoped lang="scss">
.collapsible-header {
    cursor: pointer;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid var(--cor-primaria);
    background-color: #f9f9f9;
    border-left: 10px solid var(--cor-primaria);
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}

.actions-header {
    width: 12%;
    width: 12%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    .base-button.is-medium.is-rounded[data-v-74ec8ad6] {
        border-radius: 42px;
    }

    .base-button.is-medium {
        min-width: 20px;
        height: 20px;
    }
}

.icon {
    color: var(--cor-primaria);
}

.arrow-up {
    transition: transform 0.8s ease;
}

.arrow-down {
    transform: rotate(180deg);
    transition: transform 0.8s ease;
}

.collapsible-content {
    padding: 10px;
    border: 1px solid var(--cor-primaria);
    border-radius: 10px;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
  