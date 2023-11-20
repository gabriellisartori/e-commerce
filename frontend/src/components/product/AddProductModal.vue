<script>
import { toast } from "vue3-toastify";
import BaseSwitch from '../generics/BaseSwitch.vue';
import BaseDropzone from '../generics/BaseDropzone.vue';
import { useVuelidate } from "@vuelidate/core";
import { required$ } from "../../store/validators";


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
                category_id: '',
                ingredients: [],
                promotion: [],
                additional: []
            },
            storeIngredients: [],
            categories: [],
            promotions: [],
            v$: useVuelidate(),
            errorMessage: "",
            error: false,
        };
    },
    validations() {
        return {
            form: {
                name: { required$ },
                image: { required$ },
                value: { required$ },
                category_id: { required$ },
                ingredients: { required$ }
            },
        };
    },
    computed: {
        modalTitle() {
            return this.id
                ? "Editar produto"
                : "Adicionar produto";
        },
        filteredIngredients() {
            return this.storeIngredients.filter(ingredient => ingredient.additional !== null && ingredient.additional !== undefined);
        },
        isAdditionalSelected() {
            return ingredient => Array.isArray(this.form.additional) && this.form.additional.some(item => item.id === ingredient.additional.id);
        },
        selectedPromotionData() {
            return this.promotions.find(promotion => promotion.id === this.form.selectedPromotion);
        },
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        converterParaNumero(valor) {
            const valorNumerico = valor.replace(/[^\d,]/g, '').replace(',', '.');

            return parseFloat(valorNumerico);
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
        async fetchPromotions() {
            try {
                const { data } = await this.$http.get('/promotions');
                this.promotions = data;

                console.log('promocoes', this.promotions)

            } catch (error) {
                console.error(error);
            }
        },
        async saveProduct() {
            this.v$.$validate();
            if (this.v$.$error) {
                return;
            }
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                const valorNumerico = this.converterParaNumero(this.form.value);
                formData.append('value', valorNumerico);
                formData.append('active', this.form.active ? '1' : '0');
                formData.append('category_id', this.form.category_id);
                formData.append('image', this.form.image);

                for (let i = 0; i < this.form.ingredients.length; i++) {
                    formData.append(`ingredients[${i}][id]`, this.form.ingredients[i].id);
                }

                if (this.form.additional.length > 0) {
                    console.log(this.form.additional.length)
                    for (let i = 0; i < this.form.additional.length; i++) {
                        formData.append(`additional[${i}][id]`, this.form.additional[i].id);
                        formData.append(`additional[${i}][value]`, this.form.additional[i].value);
                    }
                } else {
                    formData.append('additional', this.form.additional);
                }

                if (this.form.promotion.length > 0) {
                    for (let i = 0; i < this.form.promotion.length; i++) {
                        const promotionItem = this.form.promotion[i];
                        if (promotionItem && typeof promotionItem === 'string') {
                            formData.append(`promotion[${i}][id]`, promotionItem);
                            formData.append(`promotion[${i}][value]`, ''); // Envie uma string vazia ou ajuste conforme necessário
                        } else if (promotionItem && typeof promotionItem === 'object') {
                            formData.append(`promotion[${i}][id]`, promotionItem.id);
                            formData.append(`promotion[${i}][value]`, promotionItem.value === null ? '' : promotionItem.value);
                        }
                    }
                } else {
                    formData.append('promotion', this.form.promotion);
                }


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

                this.selectedFilePath = this.form.image;
                this.$refs.dropzone.initFile(this.selectedFilePath);

            } catch (error) {
                console.error(error);
            }
        },

        handleCategoryChange(event) {
            this.form.category_id = event.target.value;
        },
        handlePromotionChange(event) {
            this.form.promotion = Array.isArray(event.target.value) ? event.target.value : [event.target.value];
            console.log('promcaaaaao', this.form.promotion);
        },
        handleSendFileToParent(file) {
            if (file instanceof File) {
                console.log('Arquivo recebido no componente pai:', file);
                this.form.image = file;
            } else {
                console.error('O objeto recebido não é um arquivo válido:', file);
            }
        },

        isIngredientSelected(ingredient) {
            return this.form.ingredients.some(selectedIngredient => selectedIngredient.id === ingredient.id);
        },

        handleCheckboxChange(ingredient) {
            if (this.isIngredientSelected(ingredient)) {
                this.form.ingredients = this.form.ingredients.filter(item => item !== ingredient);
            } else {
                this.form.ingredients.push(ingredient);
            }
        },
        handleSwitchChange(value, ingredient) {
            this.form.additional = this.form.additional || [];

            const existingItemIndex = this.form.additional.findIndex(item => item.id === ingredient.additional.id);

            if (value && existingItemIndex === -1) {
                this.form.additional.push({
                    id: ingredient.additional.id,
                    value: ingredient.additional.value,
                });
            } else if (!value && existingItemIndex !== -1) {
                this.form.additional.splice(existingItemIndex, 1);
            }

            console.log(this.form.additional);
        }

    },
    mounted() {
        this.fetchIngredients();
        this.fetchCategories();
        this.fetchPromotions();
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
                <div :class="{ 'error-message': v$.form.name.$error }" v-if="v$.form.name.$error">
                    {{ v$.form.name.$errors[0].$message }}
                </div>

                <base-input label="Valor" v-model="form.value" placeholder="00,00"
                    @update:modelValue="form.value = $event" />
                <div :class="{ 'error-message': v$.form.value.$error }" v-if="v$.form.value.$error">
                    {{ v$.form.value.$errors[0].$message }}
                </div>

                <base-select label="Categoria" :options="categories" :selectedValue="this.form.category"
                    @change="handleCategoryChange($event)" />
                <div :class="{ 'error-message': v$.form.category_id.$error }" v-if="v$.form.category_id.$error">
                    {{ v$.form.category_id.$errors[0].$message }}
                </div>

                <base-select label="Promoção" :options="promotions" v-model="form.promotion"
                    :selectedValue="this.form.promotion" @change="handlePromotionChange($event)" />
            </div>
            <div class="column">
                <BaseDropzone label="Imagem" :sendFileToParent="handleSendFileToParent" :initialFile="selectedFilePath"
                    ref="dropzone" />
                <div :class="{ 'error-message': v$.form.image.$error }" v-if="v$.form.image.$error">
                    {{ v$.form.image.$errors[0].$message }}
                </div>

                <base-input label="Valor promocional" placeholder="00,00" />
            </div>
        </div>
        <div class="ingredient-content">
            <p>Ingredientes</p>

            <base-chip-checkbox v-for="ingredient in storeIngredients" :key="ingredient.id" :label="ingredient.name"
                :myCheckbox="`ingredient_${ingredient.id}`" :modelValue="isIngredientSelected(ingredient)"
                @change="handleCheckboxChange(ingredient)" />
            <div :class="{ 'error-message': v$.form.ingredients.$error }" v-if="v$.form.ingredients.$error">
                {{ v$.form.ingredients.$errors[0].$message }}
            </div>
        </div>

        <p>Adicionais</p>

        <div class="additional-content">
            <div class="item" v-for="ingredient in filteredIngredients" :key="ingredient.id">
                <BaseSwitch :label="`${ingredient.name}`" :id="`active_${ingredient.id}`"
                    :modelValue="isAdditionalSelected(ingredient)"
                    @update:modelValue="value => handleSwitchChange(value, ingredient)" />

                <base-input label="Valor" v-model="ingredient.additional.value" />
            </div>
        </div>
    </base-modal>
</template>

<style scoped lang="scss">
:deep(.modal) {
    max-width: none;
    width: 55%;

    @media screen and (max-width: 425px) {
        width: 70%;
    }
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

p {
    color: var(--cor-fonte);
    font-weight: 700;
    margin-bottom: 10px;
}

.ingredient-content {
    margin-bottom: 20px;
    margin-top: 1rem;
}

.additional-content {
    display: flex;
    flex-direction: row;
    justify-content: space-around;

    @media screen and (max-width: 768px) {
        flex-direction: column;

        .item {
            justify-content: space-around;
        }
    }

    .item {
        display: flex;
        flex-direction: row;
        gap: 20px;

        :deep(.switch) {
            justify-content: flex-start;
            margin-top: 0px;

            .switch-label {
                margin-top: 10px;
            }
        }

        :deep(.base-label) {
            margin-top: 0px !important;
        }
    }
}
</style>