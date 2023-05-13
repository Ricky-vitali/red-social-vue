<template>
  <div>
    <Header/>
    
    <div class="HomeDisplay">
      <h2>Publicaciones</h2>
        <Notification v-if="notification.status !== null" :text="notification.message" :type="notification.status"></Notification>
        <div>
            <CreatePostForm />
            
              <PostItem
                v-for="post in posts"
                :post="post"
                :key="post.id"
                @notification="notificationDisplay($event)"
              ></PostItem>
            
        </div>
    </div>
    </div>
</template>

<script>
import authService from '@/services/auth';
import postService from '@/services/posts';
import NavMenu from '@/components/NavMenu.vue';
import PostItem from '@/components/PostItem.vue';
import Header from '@/components/Header.vue';
import CreatePostForm from '@/components/CreatePostForm.vue';
import Notification from '@/components/Notification.vue';

export default {
  name: 'Home',
  components: {
    NavMenu, PostItem, Header, CreatePostForm, Notification
  },

  created: function(){
      postService.getAll()
        .then(res => {
            if(res.success){
              this.posts  = res.posts.slice();
              this.posts = this.posts.reverse();
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
  },

  data: function(){
    return{
      posts:[],
      notification:{
        status: null,
        message: null
      }
    }
  },

  methods:{
    notificationDisplay(data){
      if(data.errors){  
        this.notification.status = 'error';
        this.notification.message = data.errors;
      }else{
        this.notification.status = 'error';
        this.notification.message = 'Opss... Ocurrio un problema';
      }
    }
  }
  
}
</script>

<style lang="scss">

  .HomeDisplay{
    width:100%;
    height:calc(100vh - 100px);
    padding: 10px 10px 10px 10px;
    overflow-y:scroll;

    h2{
      text-align: center;
      color: #615dfa;
      font-size: 22px;
    }
   

  }
</style>