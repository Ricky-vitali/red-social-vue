<template>
    <form action="#" @submit.prevent="register(registro)">
        
            <label for="user">Ingrese su Nombre de Usuario</label>
            <input type="text" name="user" id="user" v-model="this.registerData.user" placeholder="Nombre de usuario"/>
            <ul v-if="errors.user.status === 'error'" class="errorForm">
                <li v-for="error in errors.user.messages"><p>{{ error }}</p></li>
            </ul>

            <label for="name">Ingrese su Nombre</label>
            <input type="text" name="name" id="name" v-model="this.registerData.name" placeholder="Nombre"/>
            <ul v-if="errors.name.status === 'error'" class="errorForm">
                <li v-for="error in errors.name.messages"><p>{{ error }}</p></li>
            </ul>
        
            <label for="email">Ingrese su Apellido</label>
            <input type="text" name="surname" id="surname" v-model="this.registerData.surname" placeholder="Apellido"/>
            <ul v-if="errors.surname.status === 'error'" class="errorForm">
                <li v-for="error in errors.surname.messages"><p>{{ error }}</p></li>
            </ul>
       
            <label for="email">Ingrese su email</label>
            <input type="email" name="email" id="email" v-model="this.registerData.email" placeholder="Correo electronico"/>
            <ul v-if="errors.email.status === 'error'" class="errorForm">
                <li v-for="error in errors.email.messages"><p>{{ error }}</p></li>
            </ul>
        
            <label for="password">Ingrese su Contraseña</label>
            <input type="password" name="password" id="password" v-model="this.registerData.password" placeholder="Contraseña"/>
            <ul v-if="errors.password.status === 'error'" class="errorForm">
                <li v-for="error in errors.password.messages"><p>{{ error }}</p></li>
            </ul>
        
            <label for="confirm_password">Confirmar su Contraseña</label>
            <input type="password" name="confirm_password" id="confirm_password" v-model="this.registerData.confirm_password" placeholder="Confirmar contraseña"/>
            <ul v-if="errors.confirm_password.status === 'error'" class="errorForm">
                <li v-for="error in errors.confirm_password.messages"><p>{{ error }}</p></li>
            </ul>

            <input type="submit" value="Registrarme"/>
    </form>

</template>

<script>

    import userService from '@/services/users';

    export default {
        name: 'RegisterForm',
    
        data: function() {
            return {
                registerData:{
                    user: null,
                    name: null,
                    surname: null,
                    email: null,
                    password: null,
                    confirm_password:null
                },
                errors: {
                    user: {
                        status:null,
                        messages:[]
                    },
                    name: {
                        status:null,
                        messages:[]
                    },
                    surname: {
                        status:null,
                        messages:[]
                    },
                    email: {
                        status:null,
                        messages:[]
                    },
                    password: {
                        status:null,
                        messages:[]
                    },
                    confirm_password:{
                        status:null,
                        messages:[]
                    }
                },
                status: {
                    msg: null,
                    type: 'success',
                }
            }
        },
        methods: {
            register(){

                this.errors.user.status = null;
                this.errors.user.messages = [];

                this.errors.name.status = null;
                this.errors.name.messages = [];

                this.errors.surname.status = null;
                this.errors.surname.messages = [];

                this.errors.email.status = null;
                this.errors.email.messages = [];

                this.errors.password.status = null;
                this.errors.password.messages = [];

                this.errors.confirm_password.status = null;
                this.errors.confirm_password.messages = [];

                userService.register(this.registerData)
                    .then(res => {
                        
                        if(res.success){
                            this.$emit('registrado', this.registerData);
                        }else{
                            if(res.errors_validation.user !== undefined){
                                this.errors.user.status = 'error';
                                this.errors.user.messages = res.errors_validation.user;
                            }
                            if(res.errors_validation.name !== undefined){
                                this.errors.name.status = 'error';
                                this.errors.name.messages = res.errors_validation.name;
                            }
                            if(res.errors_validation.surname !== undefined){
                                this.errors.surname.status = 'error';
                                this.errors.surname.messages = res.errors_validation.surname;
                            }
                            if(res.errors_validation.email !== undefined){
                                this.errors.email.status = 'error';
                                this.errors.email.messages = res.errors_validation.email;
                            }
                            if(res.errors_validation.password !== undefined){
                                this.errors.password.status = 'error';
                                this.errors.password.messages = res.errors_validation.password;
                            }
                            if(res.errors_validation.confirm_password !== undefined){
                                this.errors.confirm_password.status = 'error';
                                this.errors.confirm_password.messages = res.errors_validation.confirm_password;
                            }
                            
                        }
                    })
            }
        }
    }


</script>