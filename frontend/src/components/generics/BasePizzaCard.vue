<script>
import BaseSwitch from './BaseSwitch.vue';

export default {
    props: {
        image: String,
        name: String,
        value: String,
        switchValue: Boolean
    },
    components: { BaseSwitch }
}
</script>

<template>
    <div class="pizza-card">
        <!-- <img :src="image" alt="Pizza Image" class="pizza-image" /> -->
        <img class="pizza-image" src="../../assets/login.jpeg">
        <div class="pizza-infos">
            <h3 class="text-uppercase title">{{ name }}</h3>
            <h3 class="title">{{ value }}</h3>
            <BaseSwitch id="card" class="switch-menu"></BaseSwitch>
        </div>
    </div>
</template>

<style scoped lang="scss">
.pizza-card {
    background-color: rgba(95, 138, 23, 0.6);
    border-radius: 16px;
    width: 460px;
    height: 165px;
    display: flex;

    .pizza-image {
        border-bottom-left-radius: 16px;
        border-top-left-radius: 16px;
    }

    .pizza-infos {
        padding: 20px;
        line-height: 2;

        .title {
            font-size: 18px;
        }

        .switch-menu {
            margin-top: 10px;
        }
    }
}
</style>


  