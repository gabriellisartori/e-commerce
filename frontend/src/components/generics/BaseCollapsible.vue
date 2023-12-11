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
            <span :class="{ 'arrow-up': !isCollapsed, 'arrow-down': isCollapsed }"></span>
        </div>
        <transition name="fade">
            <div v-show="!isCollapsed" class="collapsible-content">
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

  
<style scoped>
.collapsible-header {
    cursor: pointer;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid var(--cor-primaria);
    background-color: #f9f9f9;
    border-left: 10px solid var(--cor-primaria);
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
  