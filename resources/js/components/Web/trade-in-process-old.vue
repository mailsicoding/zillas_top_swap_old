<template>
    <main>
        <div class="container">
            <!-- <div class="top-text-btn">
                <div class="view-text">
                    <p>Viewing MatchPay for:</p>
                </div>
                <div class="view-btn"><a href="">IGN</a></div>
            </div> -->

            <div class="row">
                <div class="col-md-12 main-b">
                    <div class="row">

                        <div class="col-xl-12 col-md-12 process-col ">

                            <div class="graph__wrapper-width">
                                <div class="account-title">
                                    <h4>Trading in process</h4>
                                </div>
                                <div class="acivity-details process-details">
                                    <div class="activity-info process-info">
                                        <div class="activity-shop">
                                            <div class="activity-name">{{ state.username }}</div>
                                        </div>

                                        <div class="activity-shop">
                                            <div class="acivity-price"><b>${{ state.price }}</b></div>
                                        </div>

                                    </div>
                                    <!-- <div class="zelle-mail">
                                        ZELLE:
                                        <a href="">endri_alanaj@yahoo.com</a>
                                    </div> -->
                                </div>

                                <div class="col-md-12 main-b">

                                    <div class="active-details">

                                        <div class="active-description">
                                            <div class="active-info">
                                                <p><b>{{ state.username }} shared the trading instructions</b></p>
                                            </div>
                                            <div class="no-match-p">
                                                <p>Please make the transfer before the timer runs out</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-box">
                                    <div class="col col-md-12 col-lg-12 col-xl-12 mx-auto my-auto process-chat">
                                        <div class="card my-2 msgcard">
                                            <div class="card-body chat-card">

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
                                                            <a href="#" @click.prevent="addMessage"><img
                                                                    src="assets/images/send.png" alt="" id="send"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="pop-proces">
                                    <div class="box1">
                                        <a class="button" @click.prevent="showPopup()">I have Sent the credits</a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
        <div id="popup1" v-if="popup == true" class="overlay">
            <div class="popup">
                <h2>confirm transfer</h2>
                <a class="close" href="#">&times;</a>
                <div class="content-pop">
                    <input type="checkbox" class="pop-chec">
                    <div class="tex">i can confirm that i have sent <b>USD {{ state.price }}</b> via <b>Zelle</b> to
                        ealanaj</div>
                </div>
                <div class="pop-tos">
                    <div class="tos1"><a href="#">Cancel</a></div>
                    <div class="tos2">
                        <router-link to="/trade-complete" @click="historyMatch">Confirm</router-link>
                    </div>
                </div>
            </div>
        </div>
    </main>
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
        name: 'trade-in-process',
        setup() {
            const messages = ref([])
            const message = ref('')
            const popup = ref(false)
            const router = useRouter()
            const state = reactive({
                id: ' ',
                offer_id: ' ',
                match_user_id: ' ',
                username: '',
                price: '',
            })
            let hasScrolledToBottom = ref('')
            // // console.log('hasScrolledToBottom', hasScrolledToBottom)
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
                    const offer = JSON.parse(localStorage.getItem('matched-offer'));
                    // console.log(offer)
                    if (offer) {
                         axios.post('get-match-offer-user', {
                            offerId: offer.offer.id
                        }).then(response => {
                            localStorage.setItem('matched-offer-user', JSON.stringify(response.data))
                            // console.log(response.data);
                            state.id = response.data.id
                            state.match_user_id = offer.offer.match_user_id
                            state.offer_id = offer.offer.id
                            state.username = response.data.username
                            state.price = offer.offer.price
                            const db = getDatabase();
                            const Fb_ref = storageRef(db, 'chat_' + state.offer_id + '/' + state.id +
                                '_' + state.match_user_id)
                            onValue(Fb_ref, (snapshot) => {
                                const data = snapshot.val();
                                // console.log(data)
                                messages.value = data
                            });
                        })

                    }
                    else
                    {
                        router.push('/dashboard')
                    }
                    const db = getDatabase();
                    const Fb_ref = storageRef(db, 'chat_' + state.offer_id + '/' + state.id + '_' + state
                        .match_user_id)

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

                    onValue(Fb_ref, (snapshot) => {
                        const data = snapshot.val();
                        messages.value = data
                    })
                }
            })
            onUpdated(() => {
                scrollBottom()
            })
            const currentuser = reactive(store.getters["auth/currentUser"])

            const addMessage = async () => {
                const data = {
                    message: message.value
                }
                const db = getDatabase();
                const Fb_ref = storageRef(db, 'chat_' + state.offer_id + '/' + state.id + '_' + state
                    .match_user_id)

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

                onValue(Fb_ref, (snapshot) => {
                    const data = snapshot.val();
                    messages.value = data
                });

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
                    // console.log('ele', el);
                    el.scrollTop = el.scrollHeight;
                }
            }
            const historyMatch = async () => {
                const offer = JSON.parse(localStorage.getItem('matched-offer'));
                const data = {
                    user_id: offer.offer.user_id,
                    offer_id: offer.offer.id,
                    price: offer.offer.price
                }
                await axios.post('order-history', data, {
                    offerId: offer.offer.id
                }).then((response) => {
                    // console.log(response.data)
                    // this.offerId=response.data.id
                    // if (response.data.status == true) {
                    //     // state.price = '';
                    //     // state.user_id = '';
                    // }
                })
            }

            onUnmounted(() => {})
            return {
                messages,
                message,
                addMessage,
                user,
                state,
                hasScrolledToBottom,
                showPopup,
                popup,
                historyMatch,
            }
        }
    }

</script>
