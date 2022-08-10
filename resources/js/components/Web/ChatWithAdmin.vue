<template>
    <div id="container">
        <div id="aside">
            <header class="d-flex">
                <!-- <input type="text" placeholder="search"> -->
                <input type="text" placeholder="search.." name="search" v-model="state.search" @keyup.enter="search">
                <button type="submit" @click="search"><i class="fa fa-search"></i></button>
            </header>
            <ul>
                <li v-for="user in users" :key="user.id" :id='user.id' :username='user.username' class="pointer"  @click="chat_room">
                    <img :src="'https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/chat_avatar_01.jpg'" alt="user image">
                    <div>
                        <h2>{{user.username}}</h2>
                        <h3 v-if="user.isLogin==true">
                            <span class="status orange"></span>
                            online
                        </h3>
                        <h3 v-else>
                            <span class="status orange"></span>
                            ofline
                        </h3>

                    </div>
                </li>
            </ul>
        </div>
        <div id="main">
            <header>
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/chat_avatar_01.jpg" alt="">
                <div>
                    <h2>.</h2>
                    <h3>Chat with {{state.username}}</h3>
                </div>
                <!-- <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_star.png" alt=""> -->
            </header>
            <ul id="chat" >
                <li class="you" v-for="mess in messages" :key="mess.id">
                    <div v-if="mess.username === user.username" >
                        <div class="entete">
                        <span class="status green"></span>
                        <h2>{{mess.username}}</h2>
                        <!-- <h3>10:12AM, Today</h3> -->
                        </div>
                        <div class="triangle"></div>
                        <div class="message">
                            {{mess.message}}
                        </div>
                    </div>
                    <div v-else>
                        <div class="entete">
                        <span class="status green"></span>
                        <h2>{{mess.username}}</h2>
                        <!-- <h3>10:12AM, Today</h3> -->
                        </div>
                        <div class="triangle"></div>
                        <div class="message">
                            {{mess.message}}
                        </div>
                    </div>

                </li>
            </ul>
            <footer>
                <textarea placeholder="Type your message" v-model="message"></textarea>
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_picture.png" alt="">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_file.png" alt="">
                <a href="#" @click="addMessage">Send</a>
            </footer>
        </div>
    </div>
</template>

<script>
    import {
        ref,
        onMounted,
        onUnmounted,
        onUpdated,
        reactive
    } from 'vue'
    import store from '../../stores'
    import {
        useRouter
    } from 'vue-router'
    import app from '../../firebase'
    import {
        getDatabase,
        ref as storageRef,
        set,
        push,
        onValue
    } from "firebase/database";

    export default {
        name: 'ChatiWithAdmin',
        setup() {
            const messages = ref([])
            const message = ref('')
            const popup = ref(false)
            const users = ref([])

            const router = useRouter()
            const state = reactive({
                id: ' ',
                offer_id: ' ',
                match_user_id: ' ',
                username: '',
                price: '',
                search:'',
                chat_user:''
            })
            let hasScrolledToBottom = ref('')
            // console.log('hasScrolledToBottom', hasScrolledToBottom)
            const user = reactive(store.getters["auth/currentUser"])
            let messaageInterval
            onMounted(() => {
                // messaageInterval = setInterval(() => {
                //     window.location.reload()
                // }, 10000)
                if (user.is_phone_verified === 0) {
                    router.push('/verify/phone')
                } else if (user.is_email_verified === 0) {
                    router.push('/verify/email')
                } else {
                        getUsers()
                }
            })
            const chat_room = () => {
                $('.pointer').on('click',function(){
                    state.chat_user = $(this).attr('id');
                    state.username = $(this).attr('username');
                    const db = getDatabase();
                    const Fb_ref = storageRef(db, 'admin_chat/'+1+'_'+state.chat_user)
                    onValue(Fb_ref, (snapshot) => {
                        const data = snapshot.val();
                        messages.value = data
                    });
                })
            }
            const currentuser = reactive(store.getters["auth/currentUser"])

            const addMessage = async () => {
                const data = {
                    message: message.value
                }
                const db = getDatabase();
                const Fb_ref = storageRef(db, 'admin_chat/'+1+'_'+state.chat_user)

                if (message.value != '') {
                    const fb_push = push(Fb_ref)
                    set(fb_push, {
                        type: 'chat',
                        id: currentuser.id,
                        username: currentuser.username,
                        // image: currentuser.image,
                        message: data.message
                    });
                    message.value = ''
                }

                // onValue(Fb_ref, (snapshot) => {
                //     const data = snapshot.val();
                //     messages.value = data
                // });

            }
            // const delete_chat = ()=>{
            //      const db = getDatabase();
            //        const Fb_ref = storageRef(db, 'chat_' + state.offer_id + '/'+state.id+'_'+state.match_user_id)
            //        remove(Fb_ref)
            // }
            const showPopup = () => {
                popup.value = true;
            }


            const scrollBottom = () => {
                if (messages.value) {
                    let el = hasScrolledToBottom.value;
                    console.log('ele', el);
                    el.scrollTop = el.scrollHeight;
                }
            }
            const getUsers = async () => {
            await axios.get('all_users',)
                .then((response) => {
                    users.value = response.data.users;
                })
            }


            const search = async () => {
            const data = {
                name:state.search
            }
            await axios.post('search_admin_chat',data)
                .then((response) => {
                    users.value = response.data.users;
            })
            }

            onUnmounted(() => {})
            return {
                messages,
                message,
                addMessage,
                users,
                user,
                state,
                hasScrolledToBottom,
                showPopup,
                popup,
                search,
                chat_room,
            }
        }
    }

</script>

<style>
    * {
        box-sizing: border-box;
    }


    #container {
        width: 1000px;
        height: 800px;
        background: #eff3f7;
        margin: 0 auto;
        font-size: 0;
        border-radius: 5px;
        overflow: hidden;
    }

    #aside {
        width: 350px;
        height: 800px;
        background-color: #3b3e49;
        display: inline-block;
        font-size: 15px;
        vertical-align: top;
    }

    #main {
        width: 650px;
        height: 800px;
        display: inline-block;
        font-size: 15px;
        vertical-align: top;
    }

    #aside header {
        padding: 30px 20px;
    }

    #aside input {
        width: 100%;
        height: 50px;
        line-height: 50px;
        padding: 0 50px 0 20px;
        background-color: #5e616a;
        border: none;
        border-radius: 3px;
        color: #fff;
        /* background-image: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_search.png); */
        background-repeat: no-repeat;
        background-position: 170px;
        background-size: 40px;
    }

    #aside input::placeholder {
        color: #fff;
    }

    #aside ul {
        padding-left: 0;
        margin: 0;
        list-style-type: none;
        overflow-y: scroll;
        height: 690px;
    }

    #aside li {
        padding: 10px 0;
    }

    #aside li:hover {
        background-color: #5e616a;
    }

    h2,
    h3 {
        margin: 0;
    }

    #aside li img {
        border-radius: 50%;
        margin-left: 20px;
        margin-right: 8px;
    }

    #aside li div {
        display: inline-block;
        vertical-align: top;
        margin-top: 12px;
    }

    #aside li h2 {
        font-size: 14px;
        color: #fff;
        font-weight: normal;
        margin-bottom: 5px;
    }

    #aside li h3 {
        font-size: 12px;
        color: #7e818a;
        font-weight: normal;
    }

    .status {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 7px;
    }

    .green {
        background-color: #58b666;
    }

    .orange {
        background-color: #ff725d;
    }

    .blue {
        background-color: #6fbced;
        margin-right: 0;
        margin-left: 7px;
    }

    #main header {
        height: 110px;
        padding: 30px 20px 30px 40px;
    }

    #main header>* {
        display: inline-block;
        vertical-align: top;
    }

    #main header img:first-child {
        border-radius: 50%;
    }

    #main header img:last-child {
        width: 24px;
        margin-top: 8px;
    }

    #main header div {
        margin-left: 10px;
        margin-right: 145px;
    }

    #main header h2 {
        font-size: 16px;
        margin-bottom: 5px;
    }

    #main header h3 {
        font-size: 14px;
        font-weight: normal;
        color: #7e818a;
    }

    #chat {
        padding-left: 0;
        margin: 0;
        list-style-type: none;
        overflow-y: scroll;
        height: 535px;
        border-top: 2px solid #fff;
        border-bottom: 2px solid #fff;
    }

    #chat li {
        padding: 10px 30px;
    }

    #chat h2,
    #chat h3 {
        display: inline-block;
        font-size: 13px;
        font-weight: normal;
    }

    #chat h3 {
        color: #bbb;
    }

    #chat .entete {
        margin-bottom: 5px;
    }

    #chat .message {
        padding: 20px;
        color: #fff;
        line-height: 25px;
        max-width: 90%;
        display: inline-block;
        text-align: left;
        border-radius: 5px;
    }

    #chat .me {
        text-align: right;
    }

    #chat .you .message {
        background-color: #58b666;
    }

    #chat .me .message {
        background-color: #6fbced;
    }

    #chat .triangle {
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 10px 10px 10px;
    }

    #chat .you .triangle {
        border-color: transparent transparent #58b666 transparent;
        margin-left: 15px;
    }

    #chat .me .triangle {
        border-color: transparent transparent #6fbced transparent;
        margin-left: 375px;
    }

    #main footer {
        height: 155px;
        padding: 20px 30px 10px 20px;
    }

    #main footer textarea {
        resize: none;
        border: none;
        display: block;
        width: 100%;
        height: 80px;
        border-radius: 3px;
        padding: 20px;
        font-size: 13px;
        margin-bottom: 13px;
    }

    #main footer textarea::placeholder {
        color: #ddd;
    }

    #main footer img {
        height: 30px;
        cursor: pointer;
    }

    #main footer a {
        text-decoration: none;
        text-transform: uppercase;
        font-weight: bold;
        color: #6fbced;
        vertical-align: top;
        margin-left: 333px;
        margin-top: 5px;
        display: inline-block;
    }
    #aside button {
    float: left;
    width: 20%;
    padding: 10px;
    background: #2196F3;
    color: white;
    font-size: 17px;
    border: 1px solid grey;
    border-left: none;
    cursor: pointer;
    }
    .pointer{
        cursor:pointer !important;
    }
</style>
