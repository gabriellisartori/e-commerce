<template>
  <div class="contact">
    <h2 class="title">Contato</h2>
    <div class="contact-container">
      <div class="contact-info">
        <div class="item">
          <font-awesome-icon class="icon" icon="fa-solid fa-phone" />
          <span>{{ phone }}</span>
        </div>
        <div class="item">
          <font-awesome-icon class="icon" icon="fa-solid fa-envelope" />
          <span>{{ email }}</span>
        </div>
        <div class="item">
          <font-awesome-icon class="icon" icon="fa-solid fa-map-location" />
          <span>{{ street }}</span>
        </div>
        <span class="address item" v-if="complement">{{ complement }}</span>
        <span class="address item">{{ city }}</span>
        <span class="address item">{{ zip_code }}</span>
      </div>
      <div>
        <iframe
          class="map"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3481.5167514806185!2d-51.88179732541925!3d-29.23776567533968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x951c5ae22b89287f%3A0xca7af2f039c6cfe9!2sR.%20Duque%20de%20Caxias%2C%201400%20-%20Santo%20Ant%C3%A3o%2C%20Encantado%20-%20RS%2C%2095960-000!5e0!3m2!1spt-BR!2sbr!4v1700519316730!5m2!1spt-BR!2sbr"
          style="border: 0"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      phone: "",
      email: "",
      street: "",
      complement: "",
      city: "",
      zip_code: "",
    };
  },
  methods: {
    async getData() {
      const { data } = await this.$http.get("/establishments/contact");
      this.phone = data.phone_number;
      this.email = data.email;
      this.street = data.street;
      this.complement = data.complement;
      this.city = data.city;
      this.zip_code = data.zip_code;
    },
  },
  mounted() {
    this.getData();
  },
};
</script>

<style lang="scss">
.contact {
  .title {
    font-family: "Sabatons";
    font-size: 2rem;
    margin-bottom: 2rem;
    @font-face {
      font-family: "Sabatons";
      src: local("Sabatons Sans Stamp"), local("Sabatons-Sans-Stamp"),
        url("../../assets/fonts/sabatons/Sabatons-Stamp.woff2") format("woff2"),
        url("../../assets/fonts/sabatons/Sabatons-Stamp.woff") format("woff"),
        url("../../assets/fonts/sabatons/Sabatons-Stamp.ttf") format("truetype");
      font-weight: normal;
      font-style: normal;
      font-display: swap;
    }
  }
  &-container {
    display: flex;
    margin-top: 20px;
    width: 100%;

    @media screen and (max-width: 1024px) {
      flex-direction: column;
      align-items: left;
    }
  }

  &-info {
    display: flex;
    flex-direction: column;
    font-size: 1.1rem;
    line-height: 1.5rem;
    margin-right: 3rem;

    @media screen and (max-width: 1024px) {
      margin-right: 0;
      margin-bottom: 20px;
      font-size: 0.8rem;
    }

    .icon {
      margin-right: 10px;
      color: var(--cor-secundaria);
    }

    .address {
      margin-left: 28px;
    }

    .item {
      margin-bottom: 16px;
    }
  }

  .map {
    height: 400px;
    width: 800px;

    @media screen and (max-width: 1024px) {
      height: 300px;
      width: 600px;
    }

    @media screen and (max-width: 768px) {
      height: 200px;
      width: 300px;
    }
  }
}
</style>