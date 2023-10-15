<script>
export default {
  methods: {
    closeModal() {
      this.$emit('close');
    },
    async saveIngredient() {
      try {
        this.value = Number(this.value);

        const response = await axios.post('/ingredient', {
          name: this.name,
          value: this.value,
          hasAdditional: this.hasAdditional,
        });

        this.name = '';
        this.hasAdditional = false;
        this.$emit('ingredientAdded', response.data);
        this.$emit('close');

        toast.success("Salvo com sucesso!", {
          position: toast.POSITION.BOTTOM_LEFT,
        });

      } catch (error) {
        console.error('Erro ao salvar a categoria:', error);
      }
    }
  }
};
</script>

<template>
    <base-modal modalTitle="Adicionar ingredientes" @cancel="closeModal">
      <base-input label="Nome" class="input name" />
    </base-modal>
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

    &.additional{
      width: 100%;
    }
  }
}
</style>
