<script>
export default {
  name: "BaseCard",
  props: {
    title: {
      type: String,
      required: true,
    },
    subtitle: {
      type: String,
      required: false,
    },
    hasEdit: {
      type: Boolean,
      required: false,
      default: true,
    },
    hasDelete: {
      type: Boolean,
      required: false,
      default: true,
    },
  }
};
</script>

<template>
    <div class="card">
        <div class="list-icons">
            <div v-if="hasEdit" class="icon" @click="$emit('edit')">
                <font-awesome-icon icon="fa-solid fa-pen-to-square" />
            </div>
            <div v-if="hasDelete" class="icon" @click="$emit('delete')">
                <font-awesome-icon icon="fa-solid fa-xmark"/>
            </div>
        </div>
        <div class="list">
            <p>{{ title }}</p>
            <p v-if="subtitle">{{ subtitle }}</p>
        </div>
    </div>
</template>

<style lang="scss">
.card {
  /*width: 400px;*/
  height: 100px;
  border: 1px solid #5f8a17;
  border-left: 15px solid #5f8a17;
  border-radius: 10px;
  margin-top: 20px;
  margin-bottom: 20px;

  .list-icons {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-top: 10px;
    cursor: pointer;

    .icon {
      width: 20px;
      height: 20px;
      font-size: 16px;
      margin: 0 8px;
      color: var(--cor-fonte);
    }
  }
  .list {
    text-align: start;
    font-weight: 700;
    margin-left: 30px;
    margin-top: 5px;
    font-size: 20px;

    p {
        margin-bottom: 10px;
    }
  }
}
</style>