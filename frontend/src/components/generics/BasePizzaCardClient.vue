<script>
export default {
    props: {
        image: String,
        name: String,
        value: String,
        disabled: Boolean,
        pizzaDetails: Object,
    },
    data() {
        return {
            isChecked: false,
        };
    },
    methods: {
        formatValue(value) {
            const hasCents = value.includes('.');
            const formattedValue = hasCents ? value : `${value},00`;

            return formattedValue;
        },
        activateCheckbox() {
            this.isChecked = !this.isChecked;
            this.$emit('activate-checkbox', this.isChecked);

            const storedPizzas = JSON.parse(localStorage.getItem('selectedPizzas')) || [];

            if (this.isChecked) {
                storedPizzas.push(this.pizzaDetails);
            } else {
                const index = storedPizzas.findIndex(pizza => pizza.name === this.pizzaDetails.name);
                if (index !== -1) {
                    storedPizzas.splice(index, 1);
                }
            }

            localStorage.setItem('selectedPizzas', JSON.stringify(storedPizzas));
        },

    },
}

</script>

<template>
    <div class="pizza-content" @click="activateCheckbox">
        <div class="select-item">
            <h3 class="text-uppercase title">{{ name }}</h3>
            <input class="checkbox" type="checkbox" v-model="isChecked" :disabled="disabled">
        </div>

        <h4>Pomodoro pelati, muçarela, alho poró, palmito, catupiry e tomate cereja</h4>
        <div class="photo-value">
            <img class="pizza-image" src="../../assets/login.jpeg">
            <div class="pizza-value">
                <h3 class="subtitle">R$</h3>
                <h3 class="title">{{ formatValue(value) }}</h3>
            </div>

        </div>
    </div>
</template>

<style setup lang="scss">
.pizza-content {
    cursor: pointer;

    .select-item {
        display: flex;
        justify-content: space-between;
        width: 80%;


        h3 {
            font-size: 24px;
            font-weight: 700;
        }
    }

    h4 {
        margin-bottom: 28px;
        width: 78%;
        font-weight: 500;
        text-align: center;
        left: 25%;
        position: relative;
        line-height: 1.4;
        margin-top: 10px;
    }

    .photo-value {
        display: flex;

        .pizza-image {
            width: 70%;
            border-radius: 16px;
        }

        .pizza-value {
            background-color: var(--cor-secundaria);
            color: var(--cor-site);
            width: 25%;
            height: 46px;
            border-radius: 16px;
            padding: 10px 10px;
            text-align: center;
            position: relative;
            right: 60px;
            bottom: 22px;


            .subtitle {
                text-align: left;
                font-size: 14px;
            }

            .title {
                font-size: 26px;
            }
        }
    }


}
</style>