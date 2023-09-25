<script>
import BaseCard from '@/components/BaseCard.vue'
import CategoryDeleteModal from './CategoryDeleteModal.vue';

export default {
  components: {
    BaseCard,
    CategoryDeleteModal
},
  data() {
    return {
        showDeleteModal: false 
    };
  },
  methods: {
    openModal() {
      this.showDeleteModal = true;
    },
    closeModal() {
      this.showDeleteModal = false;
    }
  }
}
</script>

<template>
 <BaseCard>
        <div class="icons">
            <img src="../assets/icons/edit.png">
            <img src="../assets/icons/exit.png" @click="openModal">
        </div>
        <p class="item">Salgada</p>
    </BaseCard>

    <CategoryDeleteModal v-if="showDeleteModal" @close="closeModal"></CategoryDeleteModal>
</template>