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
                                        <div class="activity-name">
                                            <span v-if="trade.operator != ''"><b>Operator : </b> {{ trade.operator }}</span>
                                            <span v-if="trade.buyer != ''"><br><b>Buyer : </b> {{ trade.buyer }}</span>
                                            <span v-if="trade.seller != ''"><br><b>Seller : </b> {{ trade.seller }}</span>
                                        </div>
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
                                        <div class="no-match-p">
                                            <p> <button class="btn btn-success">{{ countDown }}</button></p>
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
                            <div class="pop-proces" v-if="trade.buyer == ''">
                                <div class="box1">
                                    <a class="button" style="font-size:17px" @click.prevent="showPopup()">I have Sent the Payment</a>
                                </div>

                            </div>

                            <div class="pop-proces" v-if="trade.buyer != '' && trade.operator != ''">
                                <div class="box1">
                                    <a class="button" style="font-size:17px" @click.prevent="showPopup2()">I have Recieved the Payment</a>
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
            <a class="close" href="#" @click.prevent="closePopup()">&times;</a>
            <div class="content-pop" v-for="(method,index) in state.methodsArr" :key="index">
                <input type="radio" v-model="state.pmethod" name="pmethod" :value="method" class="pop-chec">
                <div class="tex">i can confirm that i have sent <b>USD {{ state.price }}</b> via <b>{{method}}</b> to
                    {{state.seller}}</div>
            </div>
            <div class="pop-tos">
                <div class="tos1"><a href="#" @click.prevent="closePopup()">Cancel</a></div>
                <div class="tos2">
                    <a style="color:white" @click.prevent="confirmPayment()">Confirm</a>
                </div>
            </div>
        </div>
    </div>
    <div id="popup1" v-if="popup2 == true" class="overlay">
        <div class="popup">
            <h2>confirm transfer</h2>
            <a class="close" href="#" @click.prevent="closePopup2()">&times;</a>
            <div class="content-pop" v-for="(method,index) in state.methodsArr" :key="index">
                <input type="radio" v-model="state.pmethod" name="pmethod" :value="method" class="pop-chec">
                <div class="tex">i can confirm that i have recieved <b>USD {{ state.price }}</b> via <b>{{method}}</b> from
                    {{state.buyer}}</div>
            </div>
            <div class="pop-tos">
                <div class="tos1"><a href="#" @click.prevent="closePopup2()">Cancel</a></div>
                <div class="tos2">
                    <a style="color:white" @click.prevent="confirmRecieved()">Confirm</a>
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
        const popup2 = ref(false)
        const countDown = ref(0.0)
        const router = useRouter()
        const state = reactive({
            offer_id: 0,
            operator_id: 0,
            seller_id: 0,
            buyer_id: 0,
            username: '',
            price: '',
            methods: '',
            methodsArr: '',
            seller: 'Seller',
            buyer: 'Buyer',
            pmethod: '',
        })
        const minutes = ref(0)
        const trade = reactive({
            operator: '',
            buyer: '',
            seller: '',
        });
        let hasScrolledToBottom = ref('')
        const db = getDatabase();
        let interval;

        // console.log('hasScrolledToBottom', hasScrolledToBottom)
        onMounted(() => {
            if (user.is_phone_verified === 0) {
                router.push('/verify/phone')
            } else if (user.is_email_verified === 0) {
                router.push('/verify/email')
            } else {
                const operator = JSON.parse(localStorage.getItem('operator'));
                const offer = JSON.parse(localStorage.getItem('matched-offer'));
                const seller = JSON.parse(localStorage.getItem('seller'));
                const buyer = JSON.parse(localStorage.getItem('buyer'));
                const matchedWith = localStorage.getItem('matched-with');
                const paymentSent = localStorage.getItem('payment-sent');
                const paymentRecieved = localStorage.getItem('payment-recieved');
                const requestedOffer = JSON.parse(localStorage.getItem('requested-offer'));
                if(offer){
                    if(matchedWith && matchedWith == 'user'){
                        state.username = user.username
                        state.offer_id = offer.offer.id
                        state.operator_id = operator.id
                        state.seller_id = seller.id
                        state.buyer_id = user.id
                        state.price = offer.offer.price
                        const meth = offer.matched_methods;
                        state.methods = meth.toString()
                        state.methodsArr = offer.matched_methods
                        state.pmethod = offer.matched_methods[0]

                        trade.operator = operator.username
                        trade.seller = seller.username
                        if(!paymentSent)
                        {
                            minutes.value = 10
                            countDownTimer()
                        }


                        get(storageRef(db, 'chat_messages/' + state.offer_id + '_' + state.operator_id + '_' + state.seller_id + '_' + state.buyer_id)).then((snapshot) => {

                                messages.value = snapshot.val()
                        })
                    }
                    else if(seller && buyer){
                        state.username = buyer.username
                        state.offer_id = offer.offer.id
                        state.operator_id = user.id
                        state.seller_id = seller.id
                        state.buyer_id = buyer.id
                        state.price = offer.offer.price
                        const meth = offer.matched_methods;
                        state.methods = meth.toString()
                        state.methodsArr = offer.matched_methods
                        state.pmethod = offer.matched_methods[0]

                        trade.buyer = buyer.username
                        trade.seller = seller.username


                        get(storageRef(db, 'chat_messages/' + state.offer_id + '_' + state.operator_id + '_' + state.seller_id + '_' + state.buyer_id)).then((snapshot) => {

                                messages.value = snapshot.val()
                        })
                    }
                    else if(buyer){
                        state.username = buyer.username
                        state.offer_id = offer.offer.id
                        state.operator_id = operator.id
                        state.seller_id = user.id
                        state.buyer_id = buyer.id
                        state.price = offer.offer.price
                        const meth = offer.matched_methods;
                        state.methods = meth.toString()
                        state.methodsArr = offer.matched_methods
                        state.pmethod = offer.matched_methods[0]

                        trade.operator = operator.username
                        trade.buyer = buyer.username


                        get(storageRef(db, 'chat_messages/' + state.offer_id + '_' + state.operator_id + '_' + state.seller_id + '_' + state.buyer_id)).then((snapshot) => {

                                messages.value = snapshot.val()
                        })
                    }
                    else{
                        router.push('/dashboard')
                    }
                }
                else if (buyer && requestedOffer) {
                    state.username = buyer.username
                    state.operator_id = user.id
                    state.buyer_id = buyer.id
                    state.price = requestedOffer.price
                    const meth = requestedOffer.methods;
                    state.methods = meth.toString()
                    state.methodsArr = requestedOffer.methods
                    state.pmethod = requestedOffer.methods[0]

                    trade.buyer = buyer.username

                    get(storageRef(db, 'chat_messages/' + state.offer_id + '_' + state.operator_id + '_' + state.seller_id + '_' + state.buyer_id)).then((snapshot) => {

                            messages.value = snapshot.val()
                    })

                } else if (matchedWith && matchedWith == 'operator' && requestedOffer) {
                    state.username = operator.username
                    state.operator_id = operator.id
                    state.buyer_id = user.id
                    state.price = requestedOffer.price
                    const meth = requestedOffer.methods;
                    state.methods = meth.toString()
                    state.methodsArr = requestedOffer.methods
                    state.pmethod = requestedOffer.methods[0]

                    trade.operator = operator.username

                        if(!paymentSent)
                        {
                            minutes.value = 10
                            countDownTimer()
                        }

                    get(storageRef(db, 'chat_messages/' + state.offer_id + '_' + state.operator_id + '_' + state.seller_id + '_' + state.buyer_id)).then((snapshot) => {

                            messages.value = snapshot.val()
                    })

                } else {
                    router.push('/dashboard')
                }

            }
        })

        onUnmounted(()=> {
            if(user.role != 'Operator')
            {
                return;
            }
        })

        onUpdated(() => {
            OnlineChat()
            onValue(storageRef(db, 'order_cancel/' + state.offer_id), (snapshot) => {
                if(snapshot.exists()){
                remove(storageRef(db, 'order_cancel/' + state.offer_id))
                delete_chat()
                if(user.role == 'Player')
                {
                    localStorage.removeItem('buyer');
                    localStorage.removeItem('seller');
                    localStorage.removeItem('requested-offer');
                    localStorage.removeItem('matched-with');
                    localStorage.removeItem('matched-offer');
                    localStorage.removeItem('matched-offer-user');
                    localStorage.removeItem('isFundsAdded')
                    localStorage.removeItem('operator');
                    Toast.fire({
                        text: 'Seller has cancelled the trade.',
                        timer: 2000,
                        icon: 'success',
                        position: 'top-end',
                    });
                    router.push('/dashboard')
                }
                if(user.role == 'Operator')
                {
                    localStorage.removeItem('buyer');
                    localStorage.removeItem('seller');
                    localStorage.removeItem('matched-offer');
                    localStorage.removeItem('isFundsAdded')
                    Toast.fire({
                        text: 'Seller has cancelled the trade.',
                        timer: 2000,
                        icon: 'success',
                        position: 'top-end',
                    });
                    router.push('/dashboard')
                }
                }
        });
            scrollBottom()
        })

        const addMessage = async () => {
            const data = {
                message: message.value
            }
            if (message.value != '') {

                const fb_push = push(storageRef(db, 'chat_messages/' + state.offer_id + '_' + state.operator_id + '_' + state.seller_id + '_' + state.buyer_id))

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
        onValue(storageRef(db, 'chat_messages/' + state.offer_id + '_' + state.operator_id + '_' + state.seller_id + '_' + state.buyer_id), (snapshot) => {

                    messages.value = snapshot.val()
                });
        }

        const countDownTimer = () => {
                    interval = setInterval(function () {
                        var d = new Date();
                        var seconds = d.getMinutes() * 60 + d.getSeconds(); //convet 00:00 to seconds for easier caculation
                        var fiveMin = 60 * minutes.value; //five minutes is 300 seconds!
                        var timeleft = fiveMin - seconds % fiveMin; // let's say 01:30, then current seconds is 90, 90%300 = 90, then 300-90 = 210. That's the time left!
                        var result = parseInt(timeleft / 60) + ':' + timeleft % 60; //formart seconds into 00:00

                        if (result == '0:1') {
                            clearTimer()
                        }
                        countDown.value = result;

                    }, 1000)
                }

        const delete_chat = ()=>{
            const db = getDatabase();

            remove(storageRef(db, 'chat_messages/' + state.offer_id + '_' + state.operator_id + '_' + state.seller_id + '_' + state.buyer_id))
        }

        const clearTimer = () => {
            minutes.value = 0
            clearInterval(interval)
        }

        const showPopup = () => {
            popup.value = true;
        }

        const showPopup2 = () => {
            popup2.value = true;
        }

        const closePopup = () => {
            popup.value = false;
        }
        const closePopup2 = () => {
            popup2.value = false;
        }

        const scrollBottom = () => {
            if (messages.value) {
                let el = hasScrolledToBottom.value;
                console.log('ele', el);
                el.scrollTop = el.scrollHeight;
            }
        }
        const confirmPayment = async () => {
            message.value = 'I can confirm that I have sent USD '+ state.price +' via '+ state.pmethod + ' to ' + state.seller
            addMessage()
            popup.value = false
            clearTimer()
        }
        const confirmRecieved = async () => {
            message.value = 'I can confirm that I have recieved USD '+ state.price +' via '+ state.pmethod + ' from ' + state.buyer
            addMessage()
            popup2.value = false
            clearTimer()
        }


        onValue(storageRef(db,'order_complete/seller/' + user.id),(snapshot) => {

                    if(user.role == 'Player' && snapshot.exists())
                    {
                    // localStorage.removeItem('matched-offer');
                    // localStorage.removeItem('buyer');
                    // localStorage.removeItem('operator');
                    localStorage.setItem('trade-complete',1)

                    remove(storageRef(db,'order_complete/seller/' + user.id))
                    // remove(storageRef(db, 'chat_messages/' + state.offer_id + '_' + state.operator_id + '_' + state.seller_id + '_' + state.buyer_id))

                    Toast.fire({
                        text: 'Trade completed successfully.',
                        timer: 2000,
                        icon: 'success',
                        position: 'top-end',
                    });

                    router.push('/trade-complete')

                    }
        })

        onValue(storageRef(db,'order_complete/buyer/' + user.id),(snapshot) => {

                    if(user.role == 'Player' && snapshot.exists())
                    {
                    // localStorage.removeItem('requested-offer');
                    // localStorage.removeItem('matched-with');
                    // localStorage.removeItem('operator');
                    // localStorage.removeItem('seller');
                    // localStorage.removeItem('matched-offer');
                    // localStorage.removeItem('matched-offer-user');
                    localStorage.setItem('trade-complete',1)

                    remove(storageRef(db,'order_complete/buyer/' + user.id))

                    // remove(storageRef(db, 'chat_messages/' + state.offer_id + '_' + state.operator_id + '_' + state.seller_id + '_' + state.buyer_id))

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
            showPopup2,
            popup,
            popup2,
            confirmPayment,
            trade,
            closePopup,
            closePopup2,
            confirmRecieved,
            countDown
        }
    }
}
</script>
<style>
.overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    transition: opacity 500ms;
    visibility: visible;
    opacity: 1;
}

.pop-tos {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 20px;
}

.pop-tos a {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 20px;
    background: rgb(4, 138, 79);
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    border: 1px solid rgb(4, 138, 79);
    border-radius: 10px;
    text-decoration: none;
    cursor: pointer;
    width: 142px;
}

.pop-tos a:hover {
    background-color: transparent;
    border: 1px solid rgb(4, 138, 79);
    transition: all .5s ease-in-out;
    color: rgb(4, 138, 79);
}

.pop-tos .tos1 a:hover {
    background-color: transparent;
    border: 1px solid rgb(4, 138, 79);
    transition: all .5s ease-in-out;
    color: rgb(4, 138, 79);
}

.tos1 {
    padding-right: 10px;
    color: #fff;
}
.tos2 {
    color: #fff;
}
.pop-tos .tos2 a:hover {
    background-color: transparent;
    border: 1px solid rgb(4, 138, 79);
    transition: all .5s ease-in-out;
    color: rgb(4, 138, 79)!important;
}
</style>
