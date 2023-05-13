<template>

    <section>
        <div class="displayRegister">
            <Notification v-if="notification.status !== null" :text="notification.message" :type="notification.status"></Notification>
            
                <h2>Registrate</h2>    
            <div class="registerContainer">
                <RegisterForm 
                    @registrado="auth($event)"
                />
                <router-link :to="`/login`">Ya tengo cuenta</router-link>
            </div>
        </div>
    </section>
</template>

<script>
import RegisterForm from '@/components/RegisterForm.vue';
import authService from '@/services/auth';
import Header from '@/components/Header.vue';
import Notification from '@/components/Notification.vue';

export default {
  name: 'Register',
   components: {
    RegisterForm, Header, Notification
  },
  data:function(){
      return{
          notification:{
              status:null,
              message:null
          }
      }
  },
  methods:{
      auth (credentials){
          authService.login(credentials.email, credentials.password)
            .then(res => {
                if(res.success){
                    this.$router.push('/');
                }else{
                    if(res.errors){
                        this.notification.status = 'error';
                        this.notification.message = res.error;
                    }else{
                        this.notification.status = 'error';
                        this.notification.message = 'Oops... ocurrio un problema';
                    }
                }
            })
      }
  }
}
</script>
<style lang="scss">

    .displayRegister{
        display:block;
        width:100%;
        height:calc(100vh - 50px);

            >h2{
                text-align: center;
            }

        >.registerContainer{
            
            >form{
                display:grid;
                  
                    >label{
                        margin-top: 10px;
                        margin-bottom: 5px;
                        margin-left:auto;
                        margin-right:auto;
                    }

                    >input[type=text],>input[type=email], >input[type=password]{
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
