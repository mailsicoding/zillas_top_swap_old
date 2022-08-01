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
                                <div class="zelle-mail">
                                        {{state.methods}}
                                    </div>
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
                                                    <div v-if="message.username === user.username" class="chat-log_item chat-log_item-own z-depth-0">
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
                                                        <a href="#" @click.prevent="addMessage"><img src="assets/images/send.png" alt="" id="send"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- <div class="pop-proces">
                                <div class="box1">
                                    <a class="button" @click.prevent="showPopup()">I have Sent the credits</a>
                                </div>

                            </div> -->
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
    onValue,
    get,
    remove
} from "firebase/database";

export default {
    name: 'trade-in-process',
    setup() {
        const user = reactive(store.getters["auth/currentUser"])
        const messages = ref([])
        const message = ref('')
        const popup = ref(false)
        const router = useRouter()
        const state = reactive({
            offer_id: '',
            operator_id: '',
            seller_id: '',
            buyer_id: '',
            username: '',
            price: '',
            methods: '',
        })
        const operator = JSON.parse(localStorage.getItem('operator'));
        const buyer = JSON.parse(localStorage.getItem('buyer'));
        let hasScrolledToBottom = ref('')
        const db = getDatabase();
        if(user.role == 'Operator' && buyer)
        var Fb_ref = storageRef(db, 'chat_messages/' + '0_' + user.id + '_0_' + buyer.id )
        else if(user.role == 'Player' && operator)
        var Fb_ref = storageRef(db, 'chat_messages/' + '0_' + operator.id + '_0_' + user.id )

        // console.log('hasScrolledToBottom', hasScrolledToBottom)
        onMounted(() => {
            if (user.is_phone_verified === 0) {
                router.push('/verify/phone')
            } else if (user.is_email_verified === 0) {
                router.push('/verify/email')
            } else {
                const operator = JSON.parse(localStorage.getItem('operator'));
                const buyer = JSON.parse(localStorage.getItem('buyer'));
                const matchedWith = localStorage.getItem('matched-with');
                const requestedOffer = JSON.parse(localStorage.getItem('requested-offer'));
                if (buyer && requestedOffer) {
                    state.username = buyer.username
                    state.offer_id = 0
                    state.operator_id = user.id
                    state.seller_id = 0
                    state.buyer_id = buyer.id
                    state.price = requestedOffer.price
                    const meth = requestedOffer.methods;
                    state.methods = meth.toString()


                    get(Fb_ref).then((snapshot) => {

                            messages.value = snapshot.val()
                    })

                } else if (matchedWith && matchedWith == 'operator' && requestedOffer) {
                    state.username = operator.username
                    state.offer_id = 0
                    state.operator_id = operator.id
                    state.seller_id = 0
                    state.buyer_id = user.id
                    state.price = requestedOffer.price
                    const meth = requestedOffer.methods;
                    state.methods = meth.toString()


                    get(Fb_ref).then((snapshot) => {

                            messages.value = snapshot.val()
                    })

                } else {
                    router.push('/dashboard')
                }

            }
        })
        onUpdated(() => {
            OnlineChat()
            scrollBottom()
        })

        const addMessage = async () => {
            const data = {
                message: message.value
            }
            if (message.value != '') {

                const fb_push = push(Fb_ref)

                set(fb_push, {
                    offer_id: state.offer_id,
                    operator_id: state.operator_id,
                    seller_id: state.seller_id,
                    buyer_id: state.buyer_id,
                    type: 'chat',
                    id: user.id,
                    username: user.username,
                    message: data.message
                });
                message.value = ''
            }


        }

        const OnlineChat = () => {
        onValue(Fb_ref, (snapshot) => {

                    messages.value = snapshot.val()
                });
        }


        // const delete_chat = ()=>{
        //      const db = getDatabase();
        //        Fb_ref = storageRef(db, 'chat_' + state.offer_id + '/'+state.id+'_'+state.match_user_id)
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
                console.log(response.data)
                // this.offerId=response.data.id
                // if (response.data.status == true) {
                //     // state.price = '';
                //     // state.user_id = '';
                // }
            })
        }




        onValue(storageRef(db,'order_complete/' + user.id),(snapshot) => {

                    if(user.role == 'Player' && snapshot.exists())
                    {
                    // localStorage.removeItem('requested-offer');
                    // localStorage.removeItem('matched-with');
                    // localStorage.removeItem('operator');

                    remove(Fb_ref)

                    Toast.fire({
                        text: 'Trade completed successfully.',
                        timer: 2000,
                        icon: 'success',
                        position: 'top-end',
                    });

                    router.push('/trade-complete')

                    }
        })

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
