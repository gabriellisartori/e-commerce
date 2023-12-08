<script>
export default {
    props: {
        image: String,
        name: String,
        value: String,
        ingredients: [],
        promotion: Array,
    },
    methods: {
        getPromotionMonth() {
            if (this.promotion && this.promotion.length > 0 && this.promotion[0].start_date) {
                const startMonth = new Date(this.promotion[0].start_date).toLocaleString('default', { month: 'long' });

                return startMonth;
            }

            return 'Mês não disponível';
        },
        formatValue(value) {
            const hasCents = value.includes('.');
            const formattedValue = hasCents ? value : `${value},00`;

            return formattedValue;
        },
    },

}
</script>

<template>
    <div class="speciale-content">
        <div class="select-item">
            <div class="month">
                <h3 class="text-uppercase title">SPECIALE DO MÊS DE</h3>
                <h2>{{ getPromotionMonth() }}</h2>
            </div>
            <input class="checkbox" type="checkbox">
        </div>

        <div class="photo-value">
            <img class="pizza-image" src="../../assets/login.jpeg">
            <div class="set">
                <div class="pizza-value">
                    <h3 class="subtitle">R$</h3>
                    <h3 class="title-value">{{ formatValue(value) }}</h3>
                </div>
                <div class="ingredients">
                    <ul>
                        <li v-for="(ingredient, index) in ingredients" :key="index">{{ ingredient.name }}</li>
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
                height: 22%;
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