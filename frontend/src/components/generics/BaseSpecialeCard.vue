<script>
export default {
    props: {
        promotion: Object,
        pizzaInCart: Boolean,
        resetCheckboxEvent: Boolean,
    },
    data() {
        return {
            promotionPizza: [],
            isChecked: false,
        };
    },
    methods: {
        getPromotionPizza() {
            this.promotionPizza.ingredients = this.promotion[0].ingredients;
            this.promotionPizza.value = this.promotion[0].value;
            this.promotionPizza.image = this.promotion[0].image;
            const split = this.promotion[0].promotion[0].name.split(' ');
            this.promotionPizza.firstName = split[0] + ' ' + split[1];
            this.promotionPizza.secondName = split[split.length - 1];
        },
        activateCheckbox() {
            this.isChecked = !this.isChecked;
            if (this.pizzaInCart) {
                console.log('sou true')
            }
            this.$emit('activate-checkbox', this.promotion);

            const storedPizzas = JSON.parse(localStorage.getItem('selectedPizzas')) || [];

            if (this.isChecked) {
                storedPizzas.push(this.promotion);
            } else {
                const index = storedPizzas.findIndex(pizza => pizza.name === this.promotion.name);
                if (index !== -1) {
                    storedPizzas.splice(index, 1);
                }
            }

            localStorage.setItem('selectedPizzas', JSON.stringify(storedPizzas));
        },
    },
    async mounted() {
        this.getPromotionPizza();
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
    <div class="speciale-content" @click="activateCheckbox" :key="resetCheckboxEvent">
        <div class="select-item">
            <div class="month">
                <h3 class="text-uppercase title">{{ promotionPizza.firstName }}</h3>
                <h2>{{ promotionPizza.secondName }}</h2>
            </div>
            <input class="checkbox" type="checkbox" v-model="isChecked">
        </div>
        <div class="photo-value">
            <img class="pizza-image" :src="'http://localhost:8000/' + promotionPizza.image" alt="Pizza Image">
            <div class="set">
                <div class="pizza-value">
                    <h3 class="subtitle">R$</h3>
                    <h3 class="title-value">{{ promotionPizza.value }},00</h3>

                </div>
                <div class="ingredients">
                    {{ promotion.ingredient }}
                    <ul>
                        <li v-for="(ingredient, index) in promotionPizza.ingredients" :key="index" class="text-uppercase">{{
                            ingredient.name }}</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</template>

<style scoped lang="scss">
.speciale-content {
    display: flex;
    flex-direction: column;

    .select-item {
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        width: 80%;

        .month {
            display: flex;
            flex-direction: column;
            line-height: 1.6;

            h3 {
                font-size: 22px;
                font-weight: 700;
            }

            h2 {
                font-family: "Sabatons";

                @font-face {
                    font-family: "Sabatons";
                    src: local("Sabatons Sans Stamp"), local("Sabatons-Sans-Stamp"),
                        url("../../assets/fonts/sabatons/Sabatons-Stamp.woff2") format("woff2"),
                        url("../../assets/fonts/sabatons/Sabatons-Stamp.woff") format("woff"),
                        url("../../assets/fonts/sabatons/Sabatons-Stamp.ttf") format("truetype");
                    font-weight: normal;
                    font-style: normal;
                    font-display: swap;
                }

                color: var(--cor-secundaria);
                font-size: 52px;
                margin-left: 45px;
            }
        }


    }

    .photo-value {
        display: flex;
        margin-top: 35px;

        .pizza-image {
            width: 70%;
            border-radius: 16px;

            @media screen and (max-width: 425px) {
                width: 88%;
            }
        }

        .set {
            display: flex;
            flex-direction: column;

            .pizza-value {
                background-color: var(--cor-secundaria);
                color: var(--cor-site);
                width: 127%;
                height: 50px;
                border-radius: 16px;
                padding: 10px 10px;
                text-align: center;
                position: relative;
                right: 45px;
                bottom: 30px;
                z-index: 2;

                @media screen and (max-width: 425px) {
                    right: 65px;
                    width: 115%;
                }

                .subtitle {
                    text-align: left;
                    font-size: 18px;
                    margin-left: 10px;
                }

                .title-value {
                    font-size: 28px;
                    font-weight: 700;
                }
            }

            .ingredients {
                position: relative;
                right: 35px;
                bottom: 38px;
                background-color: var(--cor-primaria);
                color: var(--cor-site);
                z-index: 0;
                padding: 25px 15px;
                width: 140%;
                border-radius: 16px;

                @media screen and (max-width: 425px) {
                    right: 56px;
                    width: 117%;
                }

                ul {
                    list-style: disc;
                    margin-left: 15px;
                    font-weight: 700;
                }
            }
        }


    }
}
</style>