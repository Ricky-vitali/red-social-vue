<template>
    <Header/>
    <h2>Publicacion</h2>
        <Post
          :post="post"
          :comments="comments"
          :key="post.id"
        ></Post>
  
    
</template>

<script>
import authService from '@/services/auth';
import postService from '@/services/posts';
import NavMenu from '@/components/NavMenu.vue';
import Header from '@/components/Header.vue';
import Post from '@/components/Post.vue';


export default {
  name: 'Home',
  components: {
    NavMenu,Post, Header
  },

  created: function(){
      postService.byId(this.$route.params.id)
        .then(res => {
            if(res.success){
              this.comments  = res.comments.slice();
              this.comments = this.comments.reverse();
              this.post = res.post;
            }else{
              console.log('errors');
            }
        })
  },

  data: function(){
    return{
      post:[],
      comments:[]
    }
  }
  
}
</script>

<style lang="scss">
  h3{
    margin-top: 10px;
    color: #615dfa;
    text-align: center;
    font-size: 22px;
  }
</style>