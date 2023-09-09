<script setup>
  import { ref } from 'vue';
  import BaseInput from '@/components/BaseInput.vue';
  import BasePassword from '@/components/BasePassword.vue';

  const username = ref('');
  const password = ref('');

  const handleSubmit = async () => {
    try {
      const response = await fetch('http://api/auth/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          username: username.value,
          password: password.value,
        }),
      });

      const data = await response.json();

      // apenas teste
      localStorage.setItem('token', data.token);

    } catch (error) {
      console.error('Erro ao efetuar login:', error);
    }
  };
</script>

<template>
    <div class="container">
        <div class="column left">
            <div class="content">
                <div class="triangle"></div>
                <div>
                    <div class="content-img">
                        <img class="img-background" src="../assets/login.jpeg">
                    </div>
                    <div class="mark">
                        <img src="../assets/logo-pizza.png">
                        <div class="bars">
                            <div class="bar -green"></div>
                            <div class="bar -white"></div>
                            <div class="bar -red"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="column right">
            <div class="vertical-top-line"></div>
            <hr class="horizontal-top-line">
            <form class="form-login" @submit.prevent="handleSubmit">
                <h2>FAÇA SEU LOGIN</h2>
                <BaseInput 
                    label="E-mail" 
                    class="input" 
                />
                <label>Senha</label>
                <BasePassword
                    v-model="password"
                    :label="'Senha'"
                    :placeholder="'Digite sua senha'"
                />

                <div class="buttons">
                    <button type="submit" class="button login">
                        ENTRAR
                    </button>
                    <RouterLink to="/registrar">Criar conta</RouterLink>
                </div>
            </form>
            <div class="vertical-bottom-line"></div>
            <hr class="horizontal-bottom-line">
        </div>
  </div>
</template>

<style lang="scss">
.container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    height: 100vh; 

    .column {

      &.left{
        display: flex;
        flex-direction: column;
        background-color: #5F8A17;

        .content{
            /* display: flex;
            flex-direction: row;
            align-items: stretch; */

            .triangle{
                border-top: 50vh solid transparent;
                border-bottom: 50vh solid transparent;
                border-left: 100px solid #0D0D0D;
                z-index: 2;
                position: absolute;
            }

            .content-img{
                width: 100%;
                right: 98px;
                height: 50vh;
                z-index: 1;
            
                .img-background{
                    width: 100%;
                    height: 50vh;
                    -o-object-fit: cover;
                    object-fit: cover;
                }
            }

            .mark{
                height: 40%;
                flex-direction: row;
                display: flex;
                justify-content: center;
                align-items: center;
                position: absolute;
                bottom: 0;
                width: 45%;

                img{
                    width: 30%;
                }

                .bars{
                    display: flex;
                    position: absolute;
                    bottom: 0;
                    right: 0px;

                    .bar{
                        height: 95px;
                        width: 8px;

                        &.-green{
                            background-color: #009246;
                        }

                        &.-white{
                            background-color: #F1F2F1;
                        }

                        &.-red{
                            background-color: #CE2B37;
                        }
                    }
                }
            }
        
            
        }
        
      }

      &.right{
        background-color: #FBFBFB;

        .vertical-top-line{
            border-right: 1px solid #333;
            height: 100px;
            margin-right: 38px;
            position: relative;
            top: 63px;
        }

        .horizontal-top-line{
            width: 25%;
            position: relative;
            float: right;
            margin-right: 18px;
            bottom: 25px;
        }

        .form-login{
            /* height: 80%; */
            width: 50%;
            margin: 0 auto;
            /* margin-top: 90px; */
            padding: 30px;

            h2{
                font-size: 20px;
                font-weight: 700;
            }

            .input{
                margin-top: 60px;
            }

            .buttons{
                display: flex;
                flex-direction: column;
                align-items: center;

                .login{
                    background-color: #5F8A17;
                    width: 80%;
                    height: 45px;
                    border: 1px solid transparent;
                    border-radius: 16px;
                    margin-top: 35px;
                    color: #FFFFFF;
                    font-weight: 700;
                }

                a{
                    width: 80%;
                    text-align: end;
                    color: #7A7373;
                    text-decoration: none;
                    margin-top: 10px;
                    font-weight: 700;
                }
            }
        }

        .vertical-bottom-line{
            border-right: 1px solid #333;
            height: 110px;
            width: 10px;
            margin-left: 55px;
            position: relative;
            bottom: 94px;
        }

        .horizontal-bottom-line{
            width: 25%;
            float: left;
            margin-left: 35px;
            position: relative;
            bottom: 115px;
        }
      }
    }
}
</style>