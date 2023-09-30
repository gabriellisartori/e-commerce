<script>
import PageHeaderEstablishment from '@/components/pageHeaders/PageHeaderEstablishment.vue';

export default {
  components: {
    PageHeaderEstablishment,
  }
};

</script>

<template>
    <PageHeaderEstablishment class="menu-home"/>
    <div class="contentHome">
      <div class="infos-content">
        <div class="speciale">
          <h2>SPECIALE DO MÊS DE </h2>
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
          <p>R$ 60,00 </p>
        </div>

        <div class="vertical-bottom-line"></div>
        <hr class="horizontal-bottom-line">
      </div>
        <img class="img-background" src="../../assets/pizza-home.png">
    </div>

    <div class="triangle"></div>
</template>

<style lang="scss">
.menu-home{
  .home{
    border-bottom: 3px solid var(--cor-primaria);
  }
}
.contentHome{
  display: grid;
  grid-template-columns: 1fr 1fr;
  background-color: var(--cor-site);
  overflow: hidden;

  .infos-content{
    margin-left: 150px;
    margin-top: 80px;

    .speciale{
      h2{
        font-weight: 700;
        font-size: 22px;
      }

      p{
        color: var(--cor-secundaria);
        font-weight: 700;
        font-size: 62px;
        margin-left: 50px;
      }
    }

    ul{
      line-height: 2.0;
      font-weight: 700;
      list-style: disc;
      margin-top: 30px;
      font-size: 14px;
    }

    .value{
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

    .vertical-bottom-line{
      border-right: 1px solid #333;
      height: 153px;
      width: 12px;
      margin-left: -56px;
      position: relative;
      bottom: 109px;
    }

    .horizontal-bottom-line{
      width: 53%;
      float: left;
      margin-left: -91px;
      position: relative;
      bottom: 146px;
    }
  }

  .img-background{
    position: absolute;
    bottom: -25px;
    right: 0px;
    width: 50.5%;
    overflow: hidden;
  }
}

.triangle{
  position: absolute;
  bottom: 0;
  left: 25%;
  right: 0;
  width: 0;
  height: 0;
  border-left: 25vw solid transparent;
  border-right: 25vw solid transparent;
  border-bottom: 15vh solid #0D0D0D;
}
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">