<script>
import axios from '@/axios';
import { toast } from 'vue3-toastify';
import BaseInput from '../generics/BaseInput.vue';
import BaseModal from '../generics/BaseModal.vue';
import BaseSwitch from '../generics/BaseSwitch.vue';

export default {
    props: {
        ingredient: {
            type: Object,
            required: true
        }
    },
    components: {
        BaseModal,
        BaseInput,
        BaseSwitch,
    },
    data() {
        const additional = this.ingredient.additional ?? { value: null };

        return {
            modalTitle: 'EDITAR INGREDIENTE',
            showModal: false,
            editedIngredient: {
                id: this.ingredient.id,
                name: this.ingredient.name,
                value: additional.value,
                hasAdditional: !!this.ingredient.additional,
            }
        };
    },
    computed: {
        switchValue: {
            get() {
                console.log('adicional?', this.editedIngredient.hasAdditional);
                return this.editedIngredient.hasAdditional;
            },
            set(value) {
                this.editedIngredient.hasAdditional = value;
            }
        }
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        async updateIngredient() {
            try {
                const data = {
                    id: this.editedIngredient.id,
                    name: this.editedIngredient.name,
                    value: this.editedIngredient.value,
                    hasAdditional: this.editedIngredient.hasAdditional
                };

                const response = await axios.put(`/ingredient`, data);
                console.log('Ingrediente atualizado com sucesso:', response.data);

                this.$emit('ingrediente-atualizado', response.data);

                this.$emit('close');

                toast.success("Alterações salvas!", {
                    position: toast.POSITION.BOTTOM_LEFT,
                });
            } catch (error) {
                console.error('Erro ao atualizar o ingrediente:', error);
            }
        },
        handleSwitchInput(value) {
            console.log('Evento input recebido com valor:', value);
            this.editedIngredient.hasAdditional = value;
        }
    }
}
</script>

<template>
    <BaseModal :modalTitle="modalTitle">
        <div class="components">
            <div class="infos">
                <BaseInput v-model="editedIngredient.name" label="Nome" class="input value" />
                <BaseSwitch label="Adicional" v-model="editedIngredient.hasAdditional" @input="handleSwitchInput" />
            </div>

            <div>
                <BaseInput v-if="editedIngredient.hasAdditional" v-model="editedIngredient.value" label="Valor Adicional"
                    class="input value additional" />
            </div>
        </div>

        <div class="content-buttons">
            <button class="button cancel" @click="closeModal">
                CANCELAR
            </button>
            <button class="button filled" @click="updateIngredient">
                SALVAR
            </button>
        </div>
    </BaseModal>
</template>
      

<style scoped lang="scss">
.components {
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    width: 80%;
    margin: 0 auto;

    .infos {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .value {
        width: 65%;
        margin-top: 40px;
        margin-bottom: 0px;

        &.additional {
            width: 100%;
        }
    }
}
</style>
