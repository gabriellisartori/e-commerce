<template>
  <div class="about">
    <h2 class="title">Nossa proposta</h2>
    <span class="description">{{ description }}</span>
  </div>
</template>

<script>
export default {
  data() {
    return {
      description: "",
    };
  },
  methods: {
    async getData() {
      const { data } = await this.$http.get("/establishments");
      this.description = data.description;
    },
  },
  mounted() {
    this.getData();
  },
};
</script>

<style lang="scss">
.about {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px;
  margin: 80px;
  border-radius: 10px;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

  .title {
    font-family: "Sabatons";
    font-size: 3rem;
    margin-bottom: 3rem;
    @font-face {
      font-family: "Sabatons";
      src: local("Sabatons Sans Stamp"), local("Sabatons-Sans-Stamp"),
        url("../../assets/fonts/sabatons/Sabatons-Stamp.woff2") format("woff2"),
        url("../../assets/fonts/sabatons/Sabatons-Stamp.woff") format("woff"),
        url("../../assets/fonts/sabatons/Sabatons-Stamp.ttf")
          format("truetype");
      font-weight: normal;
      font-style: normal;
      font-display: swap;
    }
  }

  .description {
    font-size: 2rem;
    text-align: center;
    line-height: 3rem;
    font-family: "Sabatons";
    margin-bottom: 2rem;
    @font-face {
      font-family: "Sabatons";
      src: local("Sabatons Sans Stamp"), local("Sabatons-Sans-Stamp"),
        url("../../assets/fonts/sabatons//Sabatons-Stamp.woff2") format("woff2"),
        url("../../assets/fonts/sabatons//Sabatons-Stamp.woff") format("woff"),
        url("../../assets/fonts/sabatons//Sabatons-Stamp.ttf")
          format("truetype");
      font-weight: normal;
      font-style: normal;
      font-display: swap;
    }
  }
}
</style>