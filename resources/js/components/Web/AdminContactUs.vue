<template>
    <main>
        <div class="container ">
            <div class="">

                <div class="chat-box">

                    <div class="col col-md-12 col-lg-12 col-xl-12 mx-auto my-auto process-chat">

                        <div class="card my-2 msgcard">
                            <div class="card-body chat-card">
                                <div class="account-title">
                                    <h4> Admin Contact Us</h4>
                                </div>
                                <div id="messages_container" class="chat-log" ref="hasScrolledToBottom">
                                    <!-- <div class="chat-log_item chat-log_item-own z-depth-0">
                                                            <div class="row justify-content-end mx-1 d-flex">
                                                                <div class="col-auto px-0">
                                                                    <span class="chat-log_author">
                                                                        @waseemasghar
                                                                    </span>
                                                                </div>
                                                                <div class="col-auto px-0">
                                                                </div>
                                                            </div>
                                                            <hr class="my-1 py-0 col-8" style="opacity: 0.1">
                                                            <div class="chat-log_message">
                                                                <p>{{ message.message }}</p>
                                                            </div>
                                                            <hr class="my-1 py-0 col-8" style="opacity: 0.1">
                                                            <div class="row chat-log_time m-0 p-0 justify-content-end">
                                                                23:15
                                                            </div>
                                                        </div> -->
                                    <template v-for="message in messages" :key="message.id">
                                        <div v-if="message.username === user.username"
                                            class="chat-log_item chat-log_item-own z-depth-0">
                                            <div class="row justify-content-end mx-1 d-flex">
                                                <div class="col-auto px-0">
                                                    <span class="chat-log_author">
                                                        @{{ message.username }}
                                                    </span>
                                                </div>
                                                <div class="col-auto px-0">
                                                </div>
                                            </div>
                                            <hr class="my-1 py-0 col-8" style="opacity: 0.1">
                                            <div class="chat-log_message">
                                                <p>{{ message.message }}</p>
                                            </div>
                                            <hr class="my-1 py-0 col-8" style="opacity: 0.1">
                                            <div class="row chat-log_time m-0 p-0 justify-content-end">
                                                23:15
                                            </div>
                                        </div>
                                        <div v-else class="chat-log_item chat-log_item z-depth-0">
                                            <div class="row justify-content-end mx-1 d-flex">
                                                <div class="col-auto px-0">
                                                    <span class="chat-log_author">
                                                        @{{ message.username }}
                                                    </span>
                                                </div>
                                                <div class="col-auto px-0">
                                                </div>
                                            </div>
                                            <hr class="my-1 py-0 col-8" style="opacity: 0.1">
                                            <div class="chat-log_message">
                                                <p>{{ message.message }}
                                                </p>
                                            </div>
                                            <hr class="my-1 py-0 col-8" style="opacity: 0.1">
                                            <div class="row chat-log_time m-0 p-0 justify-content-end">
                                                23:15
                                            </div>
                                        </div>
                                    </template>
                                </div>

                            </div>
                            <div class="card-footer chat-feet" style="background-color: #D5F4E7">
                                <div class="row">
                                    <div class="chat-form-footer">
                                        <input type="text" v-model="message">
                                        <div class="chat-lower-btn">
                                            <a href="#" @click.prevent="addMessage"><img src="assets/images/send.png"
                                                    alt="" id="send"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import axios from 'axios';
import {
    reactive,
    ref,
    onUpdated,
    onMounted
} from 'vue';

import {
    useRouter,
    useRoute
} from 'vue-router';
import {
    getDatabase,
    ref as storageRef,
    set,
    push,
    onValue,
    get,
    remove
} from "firebase/database";

import store from '../../stores';

export default {
    name: 'add_contact_us',
    setup() {
        // const state = reactive({
        //     admin_id: '',

        // })
        const router = useRouter()
        const messages = ref([])
        const message = ref('')
        const route = useRoute()
        const user = reactive(store.getters["auth/currentUser"])
        console.log(user)

        let hasScrolledToBottom = ref('')
        const db = getDatabase();

        onUpdated(() => {
            OnlineChat()
            scrollBottom()
        })

        const addMessage = async () => {
            const data = {
                message: message.value
            }
            if (message.value != '') {

                const fb_push = push(storageRef(db, 'contact_us/' + '_' + 1 + '_' + user.id))

                set(fb_push, {
                    id: user.id,
                    username: user.username,
                    message: data.message
                });
                message.value = ''
            }

        }

        const OnlineChat = () => {
            onValue(storageRef(db, 'contact_us/' + '_' + 1 + '_' + user.id), (snapshot) => {

                messages.value = snapshot.val()
                console.log(messages.value)
            });
        }

        const scrollBottom = () => {
            if (messages.value) {
                let el = hasScrolledToBottom.value;
                console.log('ele', el);
                el.scrollTop = el.scrollHeight;
            }
        }

        return {
            messages,
            message,
            addMessage,
            hasScrolledToBottom,
            user
        }
    }
}
</script>

<style>
.row {
    /* display: flex; */
    flex-wrap: wrap;
    margin-right: -0.75rem;
    margin-left: -0.75rem;
}
</style>
