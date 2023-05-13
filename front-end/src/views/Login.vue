<template>

    <section>
        <div class="displayLogin">        
            <div class="formContainer">
                <h2>Iniciar Sesion</h2>
                <LoginForm/>
                <router-link :to="`/register`">Crear Cuenta</router-link>
            </div>
        </div>
    </section>
</template>

<script>
import LoginForm from '@/components/LoginForm.vue';
import authService from '@/services/auth';
import Header from '@/components/Header.vue';

export default {
  name: 'Login',
   components: {
    LoginForm, Header
  },
  
}
</script>

<style lang="scss">
    .displayLogin{
        display:block;
        width:100%;
        height:calc(100vh - 50px);

        >h2{
             text-align: center;
        }

         .formContainer{
           
            >form{
                
                display:grid;

                    >label{
                        margin-top: 10px;
                        margin-bottom: 5px;
                        margin-left:auto;
                        margin-right:auto;
                    }

                    >input[type=email], >input[type=password]{
                        width: 320px;
                        height:35px;
                        margin-left:auto;
                        margin-right:auto;
                        outline:none;
                        border:1px solid rgba(0, 0, 0, 0.3);
                        border-radius:5px;
                        padding: 20px;
                    }

                    >input[type=submit]{
                        width: 320px;
                        height: 35px;
                        margin-left:auto;
                        margin-right:auto;
                        margin-top: 20px;
                        background-color: #0098cb;
                        color: whitesmoke;
                        border: 0;
                        outline:none;
                        border-radius: 5px;
                        font-size:15px;
                    }
                
                
            }
                >a{
                    display:block;
                    text-align:center;
                    text-decoration:none;
                    color:black;
                    height:35px;
                    width:100%;
                    padding-top:8px;
                    font-size:14px;
                }
                >a:hover{
                    color: #0098cb;
                }
            
        }
    }

</style>