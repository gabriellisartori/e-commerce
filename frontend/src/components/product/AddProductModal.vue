
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
                console.log(data)
            } catch (error) {
                console.error(error);
            }
        },
        async saveProduct() {
      try {

          await this.$http.post("/products", this.form);
        

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
    }
};
</script>

<template>
    <base-modal :modalTitle="modalTitle" @close="closeModal" @save="saveProduct">
        <div class="components-grid">
            <div>
                <base-input 
                    label="Nome" 
                    v-model="form.name"
                    @update:modelValue="form.name = $event"    
                />
                <base-input 
                    label="Valor"
                    v-model="form.value"
                    @update:modelValue="form.value = $event"
                />
                <base-input label="Categoria" />
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
                :myCheckbox="`ingredient_${ingredient.id}`"  />
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