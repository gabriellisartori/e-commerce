<script>
export default {
    props: {
        pizzaDetails: {
            type: Object,
            default: null,
        },
        modalTitle: {
            type: String,
            default: "Deseja algum adicional?",
        },
    },
    data() {
        return {
            showAdditionalSwitch: false,
        };
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
        addToCart() {
            this.$emit("add-to-cart", {
                pizzaDetails: this.pizzaDetails,
                showAdditionalSwitch: this.showAdditionalSwitch
            });
            this.closeModal();
        },
        handleSwitchChange(value) {
            this.showAdditionalSwitch = value;
        },
    }
}
</script>

<template>
    <base-modal :modalTitle="modalTitle" @close="closeModal" :showButtons="false">
        <div class="components">
            <div class="additionals">
                <base-switch :label="`${pizzaDetails.additional.name}`" :id="`active_${pizzaDetails.additional.id}`"
                    :modelValue="showAdditionalSwitch" @update:modelValue="handleSwitchChange" />
                <p>R$ {{ pizzaDetails.additional.value }}</p>
            </div>
            <button class="add-cart" @click="addToCart">Adicionar ao Carrinho</button>
        </div>

    </base-modal>
</template>

<style scoped lang="scss">
.components {
    display: flex;
    flex-direction: column;
}


.additionals {
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    align-items: center;
    margin-bottom: 40px;
    margin-top: 20px;
    font-size: 18px;
    color: var(--cor-secundaria);
    font-weight: 700;

    :deep(.switch) {
        margin-top: 0px;
        flex-direction: row-reverse;
        align-items: center;

        .switch-label {
            margin-right: 15px;
        }
    }
}

.add-cart {
    margin: 0 auto;
    width: 40%;
    background-color: var(--cor-secundaria);
    height: 50px;
    text-transform: uppercase;
    border: none;
    border-radius: 16px;
    color: var(--cor-site);
    z-index: 5;
    font-weight: 700;
    cursor: pointer;
}
</style>