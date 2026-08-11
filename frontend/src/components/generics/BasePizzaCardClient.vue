<script>
export default {
    props: {
        value: String,
        disabled: Boolean,
        pizzaDetails: Object,
        alertVisible: Boolean,
        pizzaInCart: Boolean,
        resetCheckboxEvent: Boolean,
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
        formatIngredients(ingredients) {
            if (!ingredients || !Array.isArray(ingredients)) {
                return '';
            }

            return ingredients.map(ingredient => ingredient.name).join(', ');
        },
        activateCheckbox() {
            this.isChecked = !this.isChecked;
            if (this.pizzaInCart) {
                console.log('sou true')
            }
            this.$emit('activate-checkbox', this.pizzaDetails);

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
        resetCheckbox() {
            this.isChecked = false;
        },
    },
    watch: {
        resetCheckboxEvent(newValue) {
            if (newValue) {
                this.isChecked = false;
            }
        },
    },
}
</script>

<template>
    <div class="pizza-content" @click="activateCheckbox" :key="resetCheckboxEvent">
        <div class="select-item">
            <h3 class="text-uppercase title">{{ pizzaDetails.name }}</h3>
            <input class="checkbox" type="checkbox" v-model="isChecked">
        </div>
        <h4>{{ formatIngredients(pizzaDetails.ingredients) }}</h4>
        <div class="photo-value">
            <!--  <img class="pizza-image" src="../../assets/login.jpeg"> -->
            <img :src="'http://localhost:8000/' + pizzaDetails.image" alt="Pizza Image" class="pizza-image" />
            <div class="pizza-value">
                <h3 class="subtitle">R$</h3>
                <h3 class="title-value">{{ formatValue(value) }}</h3>
            </div>

        </div>
    </div>
</template>

<style setup lang="scss">
.pizza-content {
    cursor: pointer;
    width: 100%;

    @media screen and (max-width: 425px) {
        width: 100% !important;
    }

    .select-item {
        display: flex;
        justify-content: space-between;
        width: 80%;

        @media screen and (max-width: 425px) {
            width: 100%;
        }


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

            @media screen and (max-width: 425px) {
                width: 82%;
            }
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

            .title-value {
                font-size: 22px;
                font-weight: 700;
            }

            @media screen and (max-width: 425px) {
                width: 25%;
                height: 46px;
                position: absolute;
                right: 35px;
                bottom: inherit;
            }
        }
    }


}
</style>