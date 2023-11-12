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
            selectedFilePath: '',
            form: {
                name: '',
                image: '',
                value: '',
                active: true,
                ingredients: [],
                promotion: [],
                additional:[]
            },
            storeIngredients: [],
            categories: [],
        };
    },
    computed: {
        modalTitle() {
            return this.id
                ? "Editar limite diário de pizzas"
                : "Adicionar limite diário de pizzas";
        },
        filteredIngredients() {
            return this.storeIngredients.filter(ingredient => ingredient.additional !== null && ingredient.additional !== undefined);
        }
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        async fetchIngredients() {
            try {
                const { data } = await this.$http.get('/ingredients');
                this.storeIngredients = data;
            } catch (error) {
                console.error(error);
            }
        },
        async fetchCategories() {
            try {
                const { data } = await this.$http.get('/categories');
                this.categories = data;

            } catch (error) {
                console.error(error);
            }
        },
        async saveProduct() {
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('value', this.form.value);
                formData.append('active', this.form.active ? '1' : '0');
                formData.append('category_id', this.form.category_id);
                formData.append('image', this.form.image);
                for (let i = 0; i < this.form.ingredients.length; i++) {
                    formData.append(`ingredients[${i}][id]`, this.form.ingredients[i].id);
                }
                formData.append('promotion', this.form.promotion);
                formData.append('additional', this.form.additional);


                console.log('mandando isso', formData)
                await this.$http.post('/products', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                this.$emit("limitSave");
                this.$emit("close");

                toast.success("Salvo com sucesso!", {
                    position: toast.POSITION.BOTTOM_LEFT,
                });
            } catch (error) {
                console.error("Erro ao salvar o produto:", error);
            }
        },
        async getData() {
            try {
                const { data } = await this.$http.get(
                    `/products/${this.id}`
                );

                this.form = data;
                console.log(this.form)
            } catch (error) {
                console.error(error);
            }
        },

        handleCategoryChange(event) {
            this.form.category_id = event.target.value;
        },
        handleSendFileToParent(file) {
            if (file instanceof File) {
                console.log('Arquivo recebido no componente pai:', file);
                this.form.image = file; // Atribui o objeto File diretamente à propriedade form.image
            } else {
                console.error('O objeto recebido não é um arquivo válido:', file);
            }
        },

        isIngredientSelected(ingredient) {
            return this.form.ingredients.includes(ingredient);
        },

        handleCheckboxChange(ingredient) {
            if (this.isIngredientSelected(ingredient)) {
                this.form.ingredients = this.form.ingredients.filter(item => item !== ingredient);
            } else {
                this.form.ingredients.push(ingredient);
            }
        },
    },
    mounted() {
        this.fetchIngredients();
        this.fetchCategories();
        if (this.id) {
            this.getData();
        }
    }
};
</script>

<template>
    <base-modal :modalTitle="modalTitle" @close="closeModal" @save="saveProduct">
        <div class="components-grid">
            <div class="column">
                <base-input label="Nome" v-model="form.name" @update:modelValue="form.name = $event" />
                <base-input label="Valor" v-model="form.value" @update:modelValue="form.value = $event" />
                <base-select label="Categoria" :options="categories" :selectedValue="categories.id" @change="handleCategoryChange($event)" />

                <base-input label="Selecione a promoção" />
            </div>
            <div class="column">
                <BaseDropzone label="Imagem" :sendFileToParent="handleSendFileToParent" />
                <base-input label="Valor promocional" />
            </div>
        </div>
        <p>Ingredientes</p>
        <div class="ingredient-content">
            <base-chip-checkbox v-for="ingredient in storeIngredients" :key="ingredient.id" :label="ingredient.name"
                :myCheckbox="`ingredient_${ingredient.id}`" :modelValue="isIngredientSelected(ingredient)"
                @change="handleCheckboxChange(ingredient)" />
        </div>

        <p>Adicionais</p>

        <div class="additional-content">
            <div class="item" v-for="ingredient in filteredIngredients" :key="ingredient.id">
                <BaseSwitch :label="`${ingredient.name}`" id="active" v-model="ingredient.additional.active" @change="handleSwitchChange(ingredient)"/>
                <base-input label="Valor" v-model="ingredient.additional.value" />
            </div>
        </div>
    </base-modal>
</template>

<style scoped lang="scss">
:deep(.modal) {
    max-width: none;
    width: 55%;
}

.components-grid {
    display: grid;
    grid-template-columns: 2fr 2fr;
    gap: 60px;

    @media screen and (max-width: 768px) {
        grid-template-columns: 1fr;
        gap: 0px;
    }
}

p{
    color: var(--cor-fonte);
    font-weight: 700;
    margin-bottom: 10px;
}



.additional-content {
    display: flex;
    flex-direction: row;
    justify-content: space-around;

    @media screen and (max-width: 768px) {
        flex-direction: column;
        .item{
            justify-content: space-around;
        }
    }

    .item{
        display: flex;
        flex-direction: row;
        gap: 20px;

        :deep(.switch){
            justify-content: flex-start;
            margin-top: 0px;

            .switch-label{
                margin-top: 10px;
            }
        }
    }
}
</style>