<template>
    <article>
        <div class="displayPost">
            <ul>
                <li>
                    <p>{{ users.user}}:</p>

                </li>
            </ul>
        </div>
    </article>
</template>

<script>

import postService from '@/services/posts.js';

export default {
    name: 'UserTable',
    props: ['user'],

    data: function () {
        return {
            notification: {
                status: null,
                message: null
            }
        }
    },

    methods: {
        delete() {
            postService.delete(this.post.id)
                .then(res => {
                    if (res.success) {
                        window.location.reload()
                    } else {
                        if (res.errors) {
                            this.notification.success = 'errors';
                            this.notification.errors = res.errors;
                        } else {
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
.displayPost {
    width: 50%;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    background-color: white;
    padding: 5px;
    margin-top: 10px;
    margin-left: auto;
    margin-right: auto;

    >ul {
        list-style: none;

        >li:first-of-type {
            font-size: 15px;
            display: grid;
            grid-template-columns: 1fr 70px;

            >p {
                font-weight: 600;
                display: flex;
                align-self: center;
            }

            >form {
                display: flex;
                justify-self: flex-end;
                height: 30px;
                width: 30px;

                >input[type=submit] {
                    width: 20px;
                    height: 20px;
                    background-image: url(../../src/assets/icons/borrar.png);
                    background-repeat: no-repeat;
                    background-size: contain;
                    background-position: center;
                    background-color: transparent;
                    border: 1px solid transparent;
                    cursor: pointer;
                    outline: none;
                    font-size: 0;
                }
            }
        }

        >li:nth-of-type(2) {
            margin-top: 10px;
            margin-left: 10px;
            font-size: 14px;
        }

        >li:nth-of-type(3) {
            font-size: 15px;
            margin-top: 10px;
        }

        >li:last-of-type {
            margin-top: 20px;
            font-size: 13px;
            display: grid;
            grid-template-columns: 70px 1fr;


            a {
                color: black;
                text-decoration: none;
            }

            a:hover {

                color: #0098cb;
                text-decoration: none;
            }


            >p:last-of-type {
                color: rgba(0, 0, 0, 0.500);
                display: flex;
                justify-self: flex-end;
            }
        }
    }

}
</style>