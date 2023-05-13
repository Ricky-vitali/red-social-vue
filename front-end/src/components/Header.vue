<template>
    <header>
        <h1><router-link :to="`/`">Red Social</router-link></h1>
         <NavMenu/> 
    </header>
</template>

<script>

import NavMenu from '@/components/NavMenu.vue';

export default {
  name: 'Header',
  components: {
    NavMenu
  },
 
}
</script>

<style lang="scss">

  header{
    width:100%;
    height:50px;
    background-color: #615dfa;
    display:block;
      >h1{
        display:block;
        font-size:30px;
        height:50px;
        width:fit-content;
        margin-left:10%;
        padding-top:6px;
          >a{
            display:block;
            color:whitesmoke;
            text-decoration:none;
          }
      }
  }

</style>