
<script>
import BaseSwitch from '../generics/BaseSwitch.vue';

export default {
    components: {
        BaseSwitch,
    },
    props: {
        id: {
            type: Number,
            default: null,
        }
    },
    data() {
        return {
            form: {
                name: '',
                active: false,
            },
        };
    },
    computed: {
        modalTitle() {
            return this.id ? 'Editar produto' : 'Adicionar produto';
        }
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        async fetchIngredients() {
            try {
                const { data } = await this.$http.get('/ingredients');
                this.ingredients = data;
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>

<template>
    <base-modal :modalTitle="modalTitle" @close="closeModal">
        <div class="components-grid">
            <div>
                <base-input label="Nome" />
                <base-input label="Valor" />
                <base-input label="Categoria" />
                <base-input label="Selecione a promoção" />
            </div>
            <div>
                <!-- upload image -->
                <base-input label="Valor promocional" />
            </div>
        </div>
        <p>Ingredientes</p>
        <div class="ingredient-content">
            <base-chip-checkbox label="queijo" />
            <base-chip-checkbox v-for="ingredient in ingredients" :key="ingredient.id" :label="ingredient.name" />
            <base-chip-checkbox />
            <base-chip-checkbox />
        </div>

        <p>Adicionais</p>

        <div class="additional-content">
            <div class="item">
                <BaseSwitch label="Queijo" v-model="form.active" />
                <base-input label="Valor" />
            </div>
            <div class="item">
                <BaseSwitch label="Queijo" v-model="form.active" />
                <base-input label="Valor" />
            </div>
        </div>
    </base-modal>
</template>

<style scoped lang="scss">
.components-grid {
    display: flex;

}

.additional-content {
    display: flex;
}
</style>