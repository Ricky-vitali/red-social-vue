<template>
    <div class="">
<Notification v-if="notification.status !== null" :text="notification.message" :type="notification.status"></Notification>

   
        <article>
            <div class="displayPost">
                <ul>
                    <li>
                        <p>{{ post.user_user }}</p>
                    </li>
                    <li><p>{{ post.content }}</p></li>
                    <li><p>{{ post.created_at }}</p></li>
                </ul>
            </div>
        </article>
        
            <div class="displayComentForm">
                <form action="POST" @submit.prevent="this.comment(comment)">
                    
                        <label for="content">Crear un Comentario</label>
                        <textarea name="content" id="content" placeholder="Escribe un Comentario" v-model="this.createCommentData.content"></textarea>
                        <ul v-if="errors.content.status === 'error'" class="errorForm">
                            <li v-for="error in errors.content.messages"><p>{{ error }}</p></li>
                        </ul>
                        <input type="submit" value="Comentar"/>

                </form>
            </div>
            <article>
                <h3>Comentarios</h3>
                        <Comment
                            v-for="comment in comments"
                            :comment="comment"
                            :key="comment.id"
                            @notification="notificationDisplay($event)"
                        ></Comment>
            </article>
        
    </div>
</template>

<script>
    import Comment from '@/components/Comment.vue';
    import commentService from '@/services/comments.js';
    import postService from '@/services/posts.js';
    import Notification from '@/components/Notification.vue';

    export default {
        name: 'Post',
        props: ['post', 'comments'],
        components: {
            Comment,Notification
        },
        data: function(){
            return{
                createCommentData:{
                    content:null,
                    post_id:this.$route.params.id,
                },
                errors:{
                    content:{
                        status:null,
                        messages:[]
                    }
                },
                notification:{
                    status:null,
                    message:null
                }
            }
        },
        methods: {
            notificationDisplay(data){
                console.log(data);
                if(data.errors){  
                    this.notification.status = 'error';
                    this.notification.message = data.errors;
                }else{
                    this.notification.status = 'error';
                    this.notification.message = 'Opss... Ocurrio un problema';
                }
            },

        

            comment(){
                commentService.comment(this.createCommentData)
                    .then(res => {
                        if(res.success){
                            window.location.reload()
                        }else{
                            if(res.errors){
                                this.notification.status = 'error';
                                this.notification.message = res.errors;
                            }else if(res.errors_validation){
                                this.errors.content.status = 'error';
                                this.errors.content.messages = res.errors_validation.content;
                            }else{
                                this.notification.status = 'error';
                                this.notification.message = 'Opss... Ocurrio un problema';
                            }
                        }
                    })
            },
            delete(){
                postService.delete(this.post.id)
                    .then(res => {
                        if(res.success){
                            this.$router.push('/');
                        }else{
                            if(res.errors){
                                this.notification.status = 'error';
                                this.notification.message = res.errors;
                            }else if(res.errors_validation){
                                this.errors.content.status = 'error';
                                this.errors.content.messages = res.errors_validation.content;
                            }else{
                                this.notification.status = 'error';
                                this.notification.message = 'Opss... Ocurrio un problema';
                            }
                        }
                    });
            },

        }
    }


</script>

<style lang="scss">


 .displayComentForm{
        width:50%;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius:5px;
        background-color:white;
        margin-top: 10px;
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