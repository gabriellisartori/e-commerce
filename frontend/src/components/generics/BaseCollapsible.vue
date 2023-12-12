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
    },
    methods: {
        toggleCollapsible() {
            this.isCollapsed = !this.isCollapsed;
        },
    },
};
</script>

<template>
    <div>
        <div class="collapsible-header" @click="toggleCollapsible">
            {{ title }}
            <div class="actions-header">
                <a v-if="icone" class="whats-icon" href="https://wa.me/5551989511735"><img alt="Chat on WhatsApp"
                        src="../../assets/icons/whats-icon.png" /></a>
                <span :class="{ 'arrow-up': !isCollapsed, 'arrow-down': isCollapsed }"></span>
            </div>

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

    .whats-icon {
        img {
            width: 40%;
        }
    }
}

.arrow-up::before {
    float: right;
    content: "▲";
    margin-left: 5px;
}

.arrow-down::before {
    float: right;
    content: "▼";
    margin-left: 5px;
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
  