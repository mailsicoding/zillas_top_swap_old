<template>
    <main>
        <div class="container">

            <div class="account-title match-title">
                <h4>Match Found</h4>
            </div>
            <div class="row">
                <div class="col-md-12 main-b">

                    <div class="active-details">
                        <div class="management">
                            <img src="assets/img/stay-home.png" alt="">
                        </div>
                        <div class="active-description">
                            <div class="active-info">
                                <p><b>Waiting for {{ username }}</b></p>
                            </div>

                            <div class="no-match-p">
                                <p>We're waiting for {{ username }} to come online</p>
                            </div>
                        </div>
                        <div class="mtch-btn"><a href="#">{{ countDown }}</a></div>
                    </div>
                </div>

            </div>

        </div>

    </main>
</template>

<script>
import store from '../../stores'
import {
    ref
} from '@vue/reactivity'
import {
    useRouter
} from 'vue-router'
import {
    onMounted,
    onBeforeMount,
    reactive
} from '@vue/runtime-core'

import app from '../../firebase'
import {
    getDatabase,
    ref as storageRef,
    set,
    push,
    onValue
} from "firebase/database";

export default {
    name: 'match-found',
    setup() {
        const currentuser = reactive(store.getters["auth/currentUser"])
        const username = ref('')
        const countDown = ref('00:00')
        const router = useRouter()
        const is_operator_login = ref(0)
        const is_user_login = ref(0)
        const operator = ref({})
        const matched_user = ref({})

        onMounted(() => {
            if (currentuser.is_phone_verified === 0) {
                router.push('/verify/phone')
            } else if (currentuser.is_email_verified === 0) {
                router.push('/verify/email')
            } else {
                matchedUser();
            }
        })

        onBeforeMount(() => {
            countDownTimer()
        })

        const matchedUser = async () => {
            const offer = JSON.parse(localStorage.getItem('matched-offer'));
            const matchedWith = localStorage.getItem('matched-with');
            if (offer && matchedWith) {

                await axios.post('get-match-offer-user', {
                    offerId: offer.offer.id
                }).then(response => {
                    localStorage.setItem('matched-offer-user', JSON.stringify(response.data))
                    // // console.log(response.data)
                    username.value = response.data.username
                    is_user_login.value = response.data.isLogin
                    matched_user.value = response.data
                })
                await axios.get('find_operator').then(response => {
                    if (Object.keys(response.data).length) {
                        operator.value = response.data
                        is_operator_login.value = 1
                    }
                })

                if (is_operator_login.value == 0) {
                    localStorage.removeItem('matched-offer-user')
                    localStorage.removeItem('matched-with')
                    localStorage.removeItem('matched-offer')
                    localStorage.removeItem('requested-offer')
                    Toast.fire({
                        text: 'Operator is busy. Please Try again later',
                        timer: 5000,
                        icon: 'success',
                        position: 'top-end',
                    });
                    await axios.post('change_offer_status', { id: offer.offer.id })
                    router.push('/match-request')
                } else if (is_user_login.value == 0) {
                    localStorage.removeItem('matched-offer-user')
                    localStorage.setItem('matched-with', 'operator')
                    localStorage.removeItem('offer')
                    localStorage.setItem('operator', JSON.stringify(operator.value))
                    const requestedOffer = JSON.parse(localStorage.setItem('requested-offer'))
                    Toast.fire({
                        text: 'Matched user is logged out. Continue Trade with Admin',
                        timer: 5000,
                        icon: 'success',
                        position: 'top-end',
                    });
                    const db = getDatabase();
                    const Fb_ref = storageRef(db, 'chat_matches')

                    const fb_push = push(Fb_ref)
                    const methods = requestedOffer.methods;
                    set(fb_push, {
                        operator: operator.value.id,
                        buyer: currentuser.id,
                        seller: 0,
                        offerId: 0,
                        price: requestedOffer.price,
                        methods: methods.toString(),
                        operator_response: 0,
                        seller_response: 0
                    });

                    const fb_push2 = push(storageRef(db, 'chat_messages/' + 0 + '_' + response.data.id + '_' + 0 + '_' + currentuser.id))

                    set(fb_push2, {
                        offer_id: 0,
                        operator_id: response.data.id,
                        seller_id: 0,
                        buyer_id: currentuser.id,
                        type: 'chat',
                        id: currentuser.id,
                        username: currentuser.username,
                        message: 'I wants to buy game credits of $' + requestedOffer.price
                    });

                    router.push('/trade-in-process')
                } else {
                    localStorage.setItem('operator', JSON.stringify(operator.value))
                    localStorage.setItem('seller', JSON.stringify(matched_user.value))
                    const requestedOffer = JSON.parse(localStorage.getItem('requested-offer'))
                    Toast.fire({
                        text: 'Continue Trade with Player',
                        timer: 5000,
                        icon: 'success',
                        position: 'top-end',
                    });
                    const db = getDatabase();
                    const Fb_ref = storageRef(db, 'chat_matches')

                    const fb_push = push(Fb_ref)
                    const methods = offer.matched_methods;
                    set(fb_push, {
                        operator: operator.value.id,
                        buyer: currentuser.id,
                        seller: matched_user.value.id,
                        offerId: offer.offer.id,
                        price: offer.offer.price,
                        methods: methods.toString(),
                        operator_response: 0,
                        seller_response: 0
                    });

                    const fb_push2 = push(storageRef(db, 'chat_messages/' + offer.offer.id + '_' + operator.value.id + '_' + matched_user.value.id + '_' + currentuser.id))

                    set(fb_push2, {
                        offer_id: offer.offer.id,
                        operator_id: operator.value.id,
                        seller_id: matched_user.value.id,
                        buyer_id: currentuser.id,
                        type: 'chat',
                        id: currentuser.id,
                        username: currentuser.username,
                        message: 'I am interested in your offer.'
                    });

                    router.push('/trade-in-process')
                }

            } else {
                router.push('/dashboard')
            }
        }

        const countDownTimer = () => {
            const interval = setInterval(function () {
                var d = new Date();
                var seconds = d.getMinutes() * 60 + d.getSeconds(); //convet 00:00 to seconds for easier caculation
                var fiveMin = 60 * 2; //five minutes is 300 seconds!
                var timeleft = fiveMin - seconds % fiveMin; // let's say 01:30, then current seconds is 90, 90%300 = 90, then 300-90 = 210. That's the time left!
                var result = parseInt(timeleft / 60) + ':' + timeleft % 60; //formart seconds into 00:00

                if (result == '0:1') {
                    router.push('/trade-in-process')
                }
                countDown.value = result;

            }, 1000)
        }

        return {
            username,
            countDown
        }
    }

}
</script>
