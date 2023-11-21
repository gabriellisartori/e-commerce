<template>
  <div class="profile">
    <h2 class="title">Meu perfil</h2>
    <div class="profile-content">
      <div class="profile-content-options" :class="{'is-client': ! isEstablishment}">
        <p @click="openData('basic')">Dados básicos</p>
        <p v-if="isEstablishment" @click="openData('address')">Endereço</p>
        <p v-if="isEstablishment" @click="openData('about')">Proposta</p>
      </div>
      <div class="profile-content-data" v-if="(basic || address || about) && isEstablishment">
        <BasicDataEstablishment v-if="basic" />
        <AddressEstablishment v-if="address" />
        <AboutEstablishment v-if="about" />
      </div>
      <div class="profile-content-data" v-else>
        <ClientProfile />
      </div>
    </div>
  </div>
</template>

<script>
import BasicDataEstablishment from "@/components/profile/BasicDataEstablishment.vue";
import AddressEstablishment from "@/components/profile/AddressEstablishment.vue";
import AboutEstablishment from "@/components/profile/AboutEstablishment.vue";
import ClientProfile from "@/components/profile/ClientProfile.vue";

export default {
  components: {
    BasicDataEstablishment,
    AddressEstablishment,
    AboutEstablishment,
    ClientProfile
  },
  data() {
    return {
      basic: true,
      address: false,
      about: false,
    };
  },
  computed: {
    isEstablishment() {
      return this.$auth.user().establishment_id !== null;
    }
  },
  methods: {
    openData(type) {
      if (type === "basic") {
        this.basic = true;
        this.address = false;
        this.about = false;
      } else if (type === "address") {
        this.basic = false;
        this.address = true;
        this.about = false;
      } else if (type === "about") {
        this.basic = false;
        this.address = false;
        this.about = true;
      }
    }
  },
};
</script>

<style lang="scss">
.profile {
  &-content {
    display: flex;
    width: 100%;
    margin-top: 20px;
    margin-bottom: 20px;

    .is-client {
      max-height: 35px;
    }

    &-options {
      display: flex;
      flex-direction: column;
      width: 20%;
      background-color: #5f8a17;
      border-radius: 16px;
      box-shadow: #3b5e0f 0px 0px 5px;
      margin-right: 16px;
      padding: 10px;
      max-height: 100px;

      p {
        font-size: 1.1rem;
        font-weight: 700;
        margin-top: 8px;
        margin-bottom: 8px;
        cursor: pointer;
        color: #ffffff;

        &:hover {
          color: #3b5e0f;
        }
      }
    }

    &-data {
      display: flex;
      flex-direction: column;
      width: 80%;
      border: #3b5e0f solid 1px;
      border-radius: 16px;
      box-shadow: #3b5e0f 0px 0px 5px;
    }
  }
}
</style>
