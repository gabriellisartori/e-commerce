
<script>
import { toast } from "vue3-toastify";
import BaseSwitch from '../generics/BaseSwitch.vue';
import BaseDropzone from '../generics/BaseDropzone.vue';

export default {
    components: {
        BaseSwitch,
        BaseDropzone,
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
                value: '',
                active: false,
            },
            ingredients: [],
            categories: [],
        };
    },
    computed: {
        modalTitle() {
            return this.id ? 'Editar produto' : 'Adicionar produto';
        },
        filteredIngredients() {
            return this.ingredients.filter(ingredient => ingredient.additional !== null && ingredient.additional !== undefined);
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
        async fetchCategories() {
            try {
                const { data } = await this.$http.get('/categories');
                this.categories = data;
                console.log('categorias ', this.categories)

            } catch (error) {
                console.error(error);
            }
        },
        async saveProduct() {
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('value', this.form.value);
                formData.append('active', this.form.active);
                formData.append('category_id', this.form.category_id);

                for (let i = 0; i < this.ingredients.length; i++) {
                    formData.append(`ingredients[${i}][id]`, this.ingredients[i].id);
                }

                await this.$http.post("/products", formData)
                

                this.$emit("limitSave");
                this.$emit("close");

                toast.success("Salvo com sucesso!", {
                    position: toast.POSITION.BOTTOM_LEFT,
                });
            } catch (error) {
                console.error("Erro ao salvar o limite diário de pizza:", error);
            }
        },
    },
    mounted() {
        this.fetchIngredients();
        this.fetchCategories();
    }
};
</script>

<template>
    <base-modal :modalTitle="modalTitle" @close="closeModal" @save="saveProduct">
        <div class="components-grid">
            <div>
                <base-input label="Nome" v-model="form.name" @update:modelValue="form.name = $event" />
                <base-input label="Valor" v-model="form.value" @update:modelValue="form.value = $event" />
                <base-select :options="categories" v-model="form.category_id" />


                <base-input label="Selecione a promoção" />
            </div>
            <div>
                <BaseDropzone></BaseDropzone>
                <base-input label="Valor promocional" />
            </div>
        </div>
        <p>Ingredientes</p>
        <div class="ingredient-content">
            <base-chip-checkbox v-for="ingredient in ingredients" :key="ingredient.id" :label="ingredient.name"
                :myCheckbox="`ingredient_${ingredient.id}`" />
        </div>

        <p>Adicionais</p>

        <div class="additional-content">
            <div class="item" v-for="ingredient in filteredIngredients" :key="ingredient.id">
                <BaseSwitch :label="`${ingredient.name}`" />
                <base-input label="Valor" v-model="ingredient.additional.value" />
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