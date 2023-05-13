<template>
    <nav class="navMenu">
        <ul>   
            <li><router-link :to="`/profile`">{{ this.user.user }}</router-link></li>
            <li class=""><router-link :to="`/`">Inicio</router-link></li>
            <li class=""><router-link :to="`/panel`">Panel</router-link></li>
            <li @click="logout()">Cerrar sesión</li>
        </ul>
    </nav>

</template>

<script>

    import userService from '@/services/users';
    import authService from '@/services/auth';

    export default {
        name: 'NavMenu',
    
        created: function(){

            authService.verificarAutenticacion()
                .then(res => {
                if (res !== null) {
                    this.user.id = res.id;
                    this.user.user = res.user;
                    this.user.name = res.name;
                    this.user.surname = res.surname;
                    this.user.email = res.email;
                } else {
                     this.$router.push('/login');
                }
                });
        },

        data: function() {
            return {
                user:{
                    id: null,
                    user: null,
                    name: null,
                    surname: null,
                    email: null,
                },
                ProfileMenu:{
                    status:null,
                }
            }
        },
        methods: {
            logout (){
                authService.logout()
                    .then(res => {
                        if(res.success){
                            this.$router.push('/login');
                        }else{
                            console.log(res.errors);
                        }

                        console.log(res);
                    })
            }
        }
    }


</script>

<style lang="scss">

    .navMenu{
        ul{
            position: absolute;
            float: right;
            margin-right: 20px;
            top: 0;
            right: 5%;
            margin-right: 100px; 

            li{
                    display: inline-block;
                    font-size: 18px;
                    line-height: 80px;
                    margin: 0 5px;
                    padding-right: 10px;
                    padding-left: 10px;
                    color: whitesmoke;

            }

            a{
                color: whitesmoke;
                text-decoration: none;
            }
            a:hover{
                color: rgb(110, 168, 255);
                text-decoration: none;
                cursor: pointer;
            }

        }


    }
   
</style>