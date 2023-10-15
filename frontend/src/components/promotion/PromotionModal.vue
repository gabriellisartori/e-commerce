<template>
    <div class="promotion-modal">
        <base-modal modalTitle="Promoção" @cancel="closeModal" @close="closeModal" @save="submit">
            <base-input label="Nome" class="input name" v-model="promotion.name" />
            <div class="content">
                <base-date label="Dia de início" v-model="promotion.start_date" type="date" class="input date" @update:modelValue="promotion.start_date = $event"></base-date>
                <base-time label="Hora de início" v-model="promotion.start_time" class="input" @update:modelValue="promotion.start_time = $event"/>
            </div>
            <div class="content">
                <base-date label="Dia final" v-model="promotion.end_date" type="date" class="input date" @update:modelValue="promotion.end_date = $event"></base-date>
                <base-time label="Hora final" v-model="promotion.end_time" class="input" @update:modelValue="promotion.end_time"/>
            </div>
        </base-modal>
    </div>
</template>

<script>

export default {
    props: {
        id: {
            type: Number,
            default: null
        }
    },
    data () {
        return {
            promotion: {
                id: '',
                name: '',
                start_date: '',
                start_time: '',
                end_date: '',
                end_time: ''
            }
        };
    },
    methods: {
        closeModal () {
            this.$emit('close');
        },
        async getData () {
            try {
                const { data } = await this.$http.get(`/promotion/${this.id}`);
                this.promotion = data;
                console.log(this.promotion.name);
            } catch (error) {
                console.error(error);
            }
        },
        submit () {
            //todo save post
        }
    
    },
    mounted () {
        if (this.id) {
            this.getData();
        }
    }
}
</script>

<style lang="scss">
.promotion-modal {
    .content {
        width: 100%;
        display: flex;
        justify-content: space-between;

        .date {
            width: 70% !important;
        }
    }
}

</style>