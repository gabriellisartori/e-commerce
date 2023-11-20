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

                return startMonth.toUpperCase();
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
                <h2 class="text-uppercase">{{ getPromotionMonth() }}</h2>
            </div>
            <input class="checkbox" type="checkbox">
        </div>

        <div class="photo-value">
            <img class="pizza-image" src="../../assets/login.jpeg">
            <div class="set">
                <div class="pizza-value">
                    <h3 class="subtitle">R$</h3>
                    <h3 class="title">{{ formatValue(value) }}</h3>
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
                font-size: 18px;
                font-weight: 700;
            }

            h2 {
                color: var(--cor-secundaria);
                font-weight: 700;
                font-size: 32px;
                margin-left: 45px;
            }
        }


    }

    .photo-value {
        display: flex;
        margin-top: 30px;

        .pizza-image {
            width: 70%;
            border-radius: 16px;
        }

        .set {
            display: flex;
            flex-direction: column;

            .pizza-value {
                background-color: var(--cor-secundaria);
                color: var(--cor-site);
                width: 127%;
                height: 46px;
                border-radius: 16px;
                padding: 10px 10px;
                text-align: center;
                position: relative;
                right: 45px;
                bottom: 30px;
                z-index: 2;


                .subtitle {
                    text-align: left;
                    font-size: 14px;
                }

                .title {
                    font-size: 26px;
                }
            }

            .ingredients {
                position: relative;
                right: 45px;
                bottom: 38px;
                background-color: var(--cor-primaria);
                color: var(--cor-site);
                height: 22%;
                z-index: 0;
                padding: 25px 15px;
                width: 140%;
                border-radius: 16px;
            }
        }


    }
}
</style>