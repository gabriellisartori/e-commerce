<script>

export default {
    props: {
        image: String,
        name: String,
        value: String,
        active: Boolean,
        hasEdit: {
            type: Boolean,
            required: false,
            default: true,
        },
    },
    data() {
        return {
            switchValue: this.active,
        };
    },
    methods: {
        toggleSwitch() {
            console.log(this.switchValue)
            this.switchValue = !this.switchValue;
            this.$emit('update:switchValue', this.switchValue);
        },
    },
}

</script>

<template>
    <div class="pizza-card">
        <!-- <img :src="image" alt="Pizza Image" class="pizza-image" /> -->
        <img class="pizza-image" src="../../assets/login.jpeg">
        <div class="pizza-infos">
            <h3 class="text-uppercase title">{{ name }}</h3>
            <h3 class="title">R$ {{ value }}</h3>
            <base-switch id="card" class="switch-menu" v-model="switchValue"  @click="toggleSwitch"></base-switch>
        </div>
        <div v-if="hasEdit" class="icon" @click="$emit('edit')">
            <font-awesome-icon icon="fa-solid fa-pen-to-square" />
        </div>
    </div>
</template>

<style scoped lang="scss">
.pizza-card {
    background-color: rgba(95, 138, 23, 0.6);
    border-radius: 16px;
    /* width: 460px; */
    height: 165px;
    display: flex;

    .pizza-image {
        border-bottom-left-radius: 16px;
        border-top-left-radius: 16px;
    }

    .pizza-infos {
        width: 100%;
        padding: 20px;
        line-height: 2;

        .title {
            font-size: 18px;
        }

        .switch-menu {
            margin-top: 10px;
        }
    }

    .icon {
        padding: 20px;
        color: var(--cor-fonte);
        cursor: pointer;
    }
}
</style>


  