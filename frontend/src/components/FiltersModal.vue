<template>
    <base-modal modalTitle="Filtros" saveLabel="Buscar" @cancel="closeModal" @close="closeModal" @save="changeValue">
        <div v-if="isName">
            <base-input
                label="Buscar por nome"
                v-model="name"
                placeholder="Nome do ingrediente"
            />
        </div>
        <div v-if="isPeriod">
            <base-date label="Início" 
            v-model="period.start_date" 
            type="date" 
            class="input date"
            @date-selected="period.start_date = $event" 
            @update:modelValue="period.start_date = $event">
          </base-date>

          <base-date label="Fim" 
            v-model="period.end_date" 
            type="date" 
            class="input date"
            @date-selected="period.end_date = $event" 
            @update:modelValue="period.end_date = $event">
          </base-date>
        </div>
    </base-modal>
</template>

<script>
import moment from "moment";
export default {
    props: {
        isName: {
            type: Boolean,
            default: false
        },
        isPeriod: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            name: '',
            period: {
                start_date: '',
                end_date: ''
            }
        }
    },
    methods: {
        changeValue () {
            this.closeModal();
            if (this.isName) {
                this.$emit('getValues', this.name)
            } else if (this.isPeriod) {
                this.period.start_date = moment(this.period.start_date, "DD/MM/YYYY").format("YYYY-MM-DD");
                this.period.end_date = moment(this.period.end_date, "DD/MM/YYYY").format("YYYY-MM-DD");
                this.$emit('getValues', this.period)
            }
        },
        closeModal () {
            this.$emit('close')
        },
    }
}
</script>