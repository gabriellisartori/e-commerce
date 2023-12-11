<script>
export default {
    props: {
        image: String,
        name: String,
        value: String,
        active: Boolean,
        cardId: String,
        categoryId: String,
        hasEdit: {
            type: Boolean,
            required: false,
            default: true,
        },
    },
    data() {
        return {
            switchValue: this.active,
        };
    },
    methods: {
        async toggleSwitch() {
            console.log(this.switchValue)
            this.switchValue = !this.switchValue;

            try {
                await this.$http.put(`/products/${this.cardId}`, {
                    id: this.cardId,
                    name: this.name,
                    active: this.switchValue,
                    category_id: this.categoryId,
                    image: this.image,
                    ingredients: ["ingrediente1", "ingrediente2"],
                    value: this.value,
                });
                // Se a chamada for bem-sucedida, emitir o evento para atualizar o estado no componente pai
                this.$emit('update:active', this.switchValue);
            } catch (error) {
                console.error(error);
            }
        },
    },
}

</script>

<template>
    <div class="pizza-card">
        <img :src="'http://localhost:8000/' + image" class="pizza-image">
        
        <div class="pizza-infos">
            <h3 class="text-uppercase title long-name">{{ name }}</h3>
            <h3 class="title">R$ {{ value }}</h3>
            <base-switch :id="'switch-' + cardId" class="switch-menu" v-model="switchValue"
                @update:modelValue="toggleSwitch" />
        </div>
        <div v-if="hasEdit" class="icon" @click="$emit('edit')">
            <font-awesome-icon icon="fa-solid fa-pen-to-square" />
        </div>
    </div>
</template>

<style scoped lang="scss">
.pizza-card {
    background-color: rgba(95, 138, 23, 0.6);
    border-radius: 16px;
    height: 165px;
    display: flex;
    justify-content: space-between;

    .pizza-image {
        border-bottom-left-radius: 16px;
        border-top-left-radius: 16px;
    }

    .pizza-infos {
        width: 200px;
        padding: 20px;
        line-height: 2;

        .title {
            font-size: 18px;
        }

        .switch-menu {
            margin-top: 10px;
        }

        .long-name {
            white-space: nowrap;
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }

    .icon {
        padding: 20px;
        color: var(--cor-fonte);
        cursor: pointer;
    }

    @media screen and (max-width: 425px) {
        height: 90px;
        width: 95%;
        margin: 0 auto;

        .pizza-infos {
            padding: 10px 8px 10px 15px;
            line-height: 1.5;

            .title {
                font-size: 14px;
            }

            .switch {
                height: 22px;

                .switch-label {
                    width: 40px;

                    :deep(&:before) {
                        width: 17px;
                        height: 17px;
                        left: -5px;
                        bottom: 1px;
                    }
                }
            }
        }

        .icon {
            padding: 10px 15px;

            svg {
                width: 12px;
            }
        }
    }
}
</style>


  