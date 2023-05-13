<template>
    <div class="notification" :class="'notification'+type">
      <p>{{ text }}</p>
      <button type="button" class="close" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
</template>

<script>
export default {
  name: 'Notification',
  props: {
    text: {
      type: String,
      required: true
    },
    type: {
      type: String
    },
  }
}
</script>

<style lang="scss">

    .notification{
        width:100%;
        background-color:blue;
        padding:10px 10px 10px 10px;
        display:grid;
        grid-template-columns: 1fr 20px;
        border:1px solid transparent;
        border-radius:5px;
        margin-bottom:10px;
        >button{
            display:block;
            width:20px;
            height:20px;
            background-color:transparent;
            outline:none;
            border:1px solid transparent;

        }

        >p{
            font-size:15px
        }
    }

    .notificationerror{
        margin-left:auto;
        margin-right:auto;
        width: 50%;
        border: 1px solid red;
        background-color:rgba(248, 68, 68, 0.5);
    }

    .notificationsuccess{
         margin-left:auto;
        margin-right:auto;
        width: 50%;
        background-color:rgb(132, 255, 132) !important;
        border: 1px solid rgb(0, 255, 0);
    }
</style>
