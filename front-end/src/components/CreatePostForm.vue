<template>
    <div class="displayPostForm">
        <form action="POST" @submit.prevent="post(post)">
            
                <label for="content">Crear un Post</label>
                <textarea name="content" id="content" placeholder="Escribe un mensaje" v-model="this.createPostData.content"></textarea>
                <ul v-if="errors.content.status === 'error'" class="errorForm">
                    <li v-for="error in errors.content.messages"><p>{{ error }}</p></li>
                </ul>
                <input type="submit" value="Publicar"/>
            
        </form>
    </div>
</template>

<script>
import postService from '@/services/posts';

export default {
    name: 'CreatePostForm',
    data: function(){
        return{
            createPostData:{
                content:null
            },
            errors: {
                content: {
                    status:null,
                    messages:[]
                },
            }
        }
    },
    methods: {
        post(){

            this.errors.content.status = null;
            this.errors.content.messages = [];

            postService.post(this.createPostData)
                .then(res => {
                    if(res.success){
                        window.location.reload()
                    }else{
                        
                        if(res.errors){

                            console.log('mandar error al padre');

                        }else if(res.errors_validation){
                            this.errors.content.status = 'error';
                            this.errors.content.messages = res.errors_validation.content;
                        }else{
                            data = [];
                            data['type'] = 'errors';
                            data['message'] = 'Opss... Ocurrio un problema';
                            this.$emit("notification", data);
                        }
                    }
                })
        }
    }
}
</script>

<style lang="scss">
    .displayPostForm{
        width:50%;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius:5px;
        background-color:white;
        margin-left:auto;
        margin-right:auto;
        >form{

            >label{
                     display: none;
                    }
         
                textarea{
                    width:100%;
                    resize:none;
                    height:80px;
                    outline:none;
                    border:1px solid transparent;
                    font-size:14px;
                    padding:5px 5px 5px 5px;
                    
                }   

        
                input[type=submit]{
                    width: 100%;
                    height: 30px;
                    border: 0;
                    background-color: #0098cb;
                    color: whitesmoke;
                    font-size:14px;



                }
            
        }
    }
</style>