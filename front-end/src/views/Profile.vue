<template>
    <div>
    <Header/>
    <div class="displayProfile">
        <h2>Perfil</h2>

        <Notification v-if="notification.status !== null" :text="notification.message" :type="notification.status"></Notification>
        <div>
            <div>
                <img src="@/assets/icons/profileDefault.jpg" alt="Imagen de perfil"/>
            </div>
            <div>
                    <div>
                        <div v-if="this.forms.user === null">
                            <p>Usuario: {{ this.user.user }}</p>
                        </div>
                        <div v-else>
                            <form action="PUT" @submit.prevent="sendEditUser()">
                                <input type="text" name="user" v-model="data.user" :placeholder="this.user.user"/>
                                <input type="submit" value="Guardar usuario"/>
                            </form>
                            <ul v-if="errors.user.status === 'error'" class="errorForm">
                                <li v-for="error in errors.user.messages"><p>{{ error }}</p></li>
                            </ul>
                        </div>
                        <button @click="this.editUser()">Editar usuario</button>
                    </div>
                
                    <div>
                        <p>Nombre: {{ user.name }}</p>
                    </div>
                    <div>
                        <p>Apellido: {{ user.surname }}</p>
                    </div>
                    <div>
                        <p>Correo electronico: {{ user.email }}</p>
                    </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import Header from '@/components/Header.vue';
import NavMenu from '@/components/NavMenu.vue';
import authService from '@/services/auth';
import userService from '@/services/users';

import Notification from '@/components/Notification.vue';

export default {
    name: 'Profile',
    components:{Header, NavMenu,Notification},

    created: function(){
        authService.verificarAutenticacion()
        .then(res => {
            if(res){
              this.user.id = res.id;
              this.user.user = res.user;
              this.user.name = res.name;
              this.user.surname = res.surname;
              this.user.email = res.email;
            }else{
              this.$router.push('/login');
            }
        })
    },

    data: function(){
        return{
            user:{
                id:null,
                user: null,
                name: null,
                surname: null,
                email:null,
            },
            forms:{
                user:null,
                biography:null
            },
            data:{
                user:null,
                biography:null
            },
            notification:{
                status:null,
                message:null
            },
            errors:{
                user:{
                    status:null,
                    message:null
                },
            }
        }
    },

    methods:{
        sendEditUser(){
            
            this.errors.user.status = null;
            this.errors.user.messages = [];


            userService.editUser(this.data.user)
            .then(res => {
                console.log(res);
                if(res.success){
                    this.notification.status = 'success';
                    this.notification.message = res.message;
                    this.user.user = this.data.user;
                }else{
                    if(res.errors){
                        this.notification.status = 'error';
                        this.notification.message = res.errors;
                    }else if(res.errors_validation){
                        if(res.errors_validation.user !== undefined){
                            this.errors.user.status = 'error';
                            this.errors.user.messages = res.errors_validation.user;
                        }
                    }else{
                        this.notification.status = 'error';
                        this.notification.message = 'Opss... Ocurrio un problema';
                    }
                }
            })
        },

        editUser(){
            if(this.forms.user === null){
                this.forms.user = true;
            }else{
                this.forms.user = null;
            }
        },
    }
  
}
</script>

<style lang="scss">

    h2{
      margin-top: 10px;
      text-align: center;
      color: #615dfa;
      font-size: 22px;
    }

.displayProfile{

    
    width:100%;
    height:calc(100vh - 100px);
   

    >div{
        margin-top: 25px;
        background-color: whitesmoke;

    >div:first-of-type{
      width:50%;
      margin-left:auto;
      margin-right:auto;
      padding:10px 10px 10px 10px;
      background-color:white;

      >img{
          width:150px;
          height:150px;
          display:block;
          margin-left:auto;
          margin-right:auto;
          border-radius: 50%;
      }
    }

    >div:last-of-type{
        width:50%;
        margin-left:auto;
        margin-right:auto;
        padding:10px 10px 10px 10px;
        background-color:white;
        display:grid;
        grid-template-columns:1fr;
        grid-gap:10;

        >div:first-of-type{
            width:100%;
            display:grid;
            grid-template-columns:1fr 40px;
            grid-template-rows:1fr;

            >button{
                width:30px;
                height:30px;
                display:block;
                background-image: url(../../src/assets/icons/edit.png);
                font-size:0;
                background-color:transparent;
                border:1px solid transparent;
                outline:none;
                background-repeat: no-repeat;
                background-size:contain;
                background-position:center;
            }

            form{
                display:grid;
                grid-template-columns:1fr 50px;
                width:100%;

                >input[type=text]{
                    border:1px solid rgba(0,0,0,0.1);
                    border-radius:5px;
                    height:30px;
                    padding:5px 5px 5px 5px;
                    outline:none;
                }

                >input[type=submit]{
                    width:30px;
                    height:30px;
                    display:block;
                    background-image: url(../../src/assets/icons/tic.png);
                    font-size:0;
                    background-color:transparent;
                    border:1px solid transparent;
                    outline:none;
                    background-repeat: no-repeat;
                    background-size:contain;
                    background-position:center;
                    margin-left:5px;
                }
            }
            >div{
                display:inline-block;
                width:fit-content;
                align-self:center;
                justify-self:flex-start;
                width:90%;
            }
        }

        >div:nth-of-type(2), >div:nth-of-type(3), >div:nth-of-type(4){
            height:40px;
            display:grid;
            grid-template-rows:1fr;
            grid-template-columns:1fr;

            >p{
                width:fit-content;
                display:flex;
                align-self:center;
            }
        }
    }
    }
}
</style>