<script>
export default {
  components: {
  },
  mounted () {
    document.body.classList.add('background');
  },
  unmounted () {
    document.body.classList.remove('background');
  }
};

</script>

<template>
  <div class="contentHome">
    <div class="infos-content">
      <div class="speciale">
        <h2>SPECIALE DO MÊS DE</h2>
        <p>AGOSTO</p>
      </div>
      <ul>
        <li>MOLHO DE TOMATE</li>
        <li>MOLHO DE TOMATE</li>
        <li>MOLHO DE TOMATE</li>
        <li>MOLHO DE TOMATE</li>
        <li>MOLHO DE TOMATE</li>
      </ul>

      <div class="value">
        <p>R$ 60,00</p>
      </div>

      <div class="vertical-bottom-line"></div>
      <hr class="horizontal-bottom-line" />
    </div>
  </div>
</template>

<style lang="scss">
.background {
  background-image: url("../../assets/home-background.png");
  background-repeat: no-repeat;
  background-size: cover;
  overflow: hidden;

  @media screen and (max-width: 820px) {
    background-image: none;
  }

  @media screen and (min-width: 1024px) {
    background-position: 0px -310px;
  }

  @media screen and (min-width: 1440px) {
    background-position: -140px 0px;
  }

  @media screen and (min-width: 1920px) {
    background-position: -100px 0px;
  }

  @media screen and (min-width: 2000px) {
    background-position: 0px -100px;
  }

  @media screen and (min-width: 2240px) {
    background-position: 0px -150px;
  }

  @media screen and (min-width: 2400px) {
    background-position: 0px -200px;
  }

  @media screen and (min-width: 2560px) {
    background-position: 0px -750px;
    
  }
}

.contentHome {
  display: grid;
  grid-template-columns: 1fr 1fr;
  overflow: hidden;

  .infos-content {
    margin-left: 150px;
    margin-top: 80px;

    .speciale {
      h2 {
        font-weight: 700;
        font-size: 22px;
      }

      p {
        color: var(--cor-secundaria);
        font-weight: 700;
        font-size: 62px;
        margin-left: 50px;
      }
    }

    ul {
      line-height: 2;
      font-weight: 700;
      list-style: disc;
      margin-top: 30px;
      font-size: 14px;
    }

    .value {
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: var(--cor-secundaria);
      width: 150px;
      height: 60px;
      border-radius: 16px;
      color: var(--cor-site);
      font-size: 20px;
      float: right;
      margin-right: -34px;
      z-index: 1;
      position: relative;
      font-weight: 700;
    }

    .vertical-bottom-line {
      border-right: 1px solid #333;
      height: 153px;
      width: 12px;
      margin-left: -56px;
      position: relative;
      bottom: 109px;
    }

    .horizontal-bottom-line {
      width: 53%;
      float: left;
      margin-left: -91px;
      position: relative;
      bottom: 146px;
    }
  }
}
</style>
