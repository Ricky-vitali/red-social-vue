<template>
<div class="displayComent">
<ul>
    <li>
        <ul>
            <li>
                <p>{{ comment.user_user }}</p>
                <form action="DELETE" @submit.prevent="this.delete()">
                    <input type="submit" value="Borrar"/>
                </form>
            </li>
            <li><p>{{ comment.content }}</p></li>
            <li><p>{{ comment.created_at }}</p></li>
        </ul>
    </li>
</ul>    
</div>
</template>

<script>

import commentService from '@/services/comments';

export default {
    name: 'Comment',
    props:['comment'],

    data:function(){
        return{
            notification:{
                status:null,
                message:null
            }
        }
    },
    methods:{
        delete(){
                commentService.delete(this.comment.id)
                    .then(res => {
                        if(res.success){
                            window.location.reload();
                        }else{
                            if(res.errors){
                                this.notification.success = 'errors';
                                this.notification.errors = res.errors;
                            }else{
                                this.notification.success = 'errors';
                                this.notification.errors = 'Opss... Ocurrio un problema';
                            }

                            this.$emit('notification', this.notification);
                        }
                    });
            }
    }
  
}
</script>

<style lang="scss">
     .displayComent{
        width:45%;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius:5px;
        background-color:white;
        padding: 5px;
        margin-top: 10px;
        margin-left:auto;
        margin-right:auto;

       ul{
           list-style: none;

            >li:first-of-type{
            font-size:15px;
            display:grid;
            grid-template-columns: 1fr 70px;

            >p{
                display:flex;
                align-self:center;
            }


             >form{
                display:flex;
                justify-self:flex-end;
                height:30px;
                width:30px;

                >input[type=submit]{
                    width:20px;
                    height:20px;
                    background-image: url(../../src/assets/icons/borrar.png);
                    background-repeat: no-repeat;
                    background-size:contain;
                    background-position:center;
                    background-color:transparent;
                    border: 1px solid transparent;
                    cursor: pointer;
                    outline:none;
                    font-size:0;
                 
                }
            }

       

       }

           >li:nth-of-type(3){
                color: rgba(0, 0, 0, 0.500);
                display:flex;
                justify-self:flex-end;
            }
        
    }
    }
</style>