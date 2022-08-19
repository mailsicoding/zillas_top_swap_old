<template>
    <main>

        <div class="container">

            <div class="account-title match-title">
                <h4>Trade Methods</h4>
            </div>
            <div class="row">
                <div class="col-md-12 main-b">
                    <div class="row active-card">
                        <div class="col-xl-3 col-md-4 col-sm-6">
                            <div class="card card__one--wrapper text-white mb-4">
                                <div class="card-body">
                                    <div class="flex__wrapper-two">
                                        <div>
                                            <p class="card-label-one">Merchant Account</p>
                                            <h3 class="card-heading-one">{{ currentuser.username }}</h3>
                                        </div>
                                        <div>
                                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-4 col-sm-6">
                            <div class="card card__two--wrapper text-white mb-4">
                                <div class="card-body">
                                    <div class="flex__wrapper-two">
                                        <div>
                                            <p class="card-label-one">Amount Requested</p>
                                            <h3 class="card-heading-one" v-if="state.price != ''">${{ state.price }}
                                            </h3>
                                            <h3 class="card-heading-one" v-else>$0.00</h3>
                                        </div>
                                        <div>
                                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="active-details">

                        <div class="active-description">

                            <div class="no-match-p method">
                                <p>Activity more methods will increase your chances of finding a match</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 main-b">
                    <div class="row">
                        <div v-if="offers.length > 0" class="w-100">
                            <div class="col-xl-12 col-md-12 mb-2">
                                <div class="graph__wrapper-width">
                                    <div class="active-details">
                                        <div class="active-title">
                                            <h1>Matched Offers List</h1>
                                        </div>

                                        <div class="active-description">
                                            <div class="acivity-details">
                                                <div class="activity-info">
                                                    <div class="activity-shop">
                                                        <div class="acivity-price"><strong>Price</strong></div>
                                                    </div>
                                                    <div class="activity-shop">
                                                        <div class="acivity-name"><strong>Seller</strong></div>
                                                    </div>
                                                    <div class="activity-shop">
                                                        <div class="acivity-method"><strong>Payment Method</strong>
                                                        </div>
                                                    </div>
                                                    <div class="activity-shop">
                                                        <div class="acivity-date"><strong>Action</strong></div>
                                                    </div>
                                                </div>
                                                <template v-for="offer in offers" :key="offer.id">
                                                    <div class="activity-info">
                                                        <div class="activity-shop">
                                                            <div class="acivity-price">${{ offer.price }}</div>
                                                        </div>
                                                        <div class="activity-shop">
                                                            <div class="acivity-name">{{ offer.users.username }}</div>
                                                        </div>
                                                        <div class="activity-shop">
                                                            <template v-for="method in offer.offer_methods"
                                                                :key="method.id">
                                                                <div class="method-active"
                                                                    v-if="method.name == 'apple_pay'">
                                                                    Apple
                                                                    Pay</div>
                                                                <div class="method-active"
                                                                    v-if="method.name == 'chime'">
                                                                    Chime
                                                                </div>
                                                                <div class="method-active"
                                                                    v-if="method.name == 'paypal'">
                                                                    Paypal
                                                                </div>
                                                                <div class="method-active"
                                                                    v-if="method.name == 'square_cash'">
                                                                    Square
                                                                    Cash
                                                                </div>
                                                                <div class="method-active"
                                                                    v-if="method.name == 'venmo'">
                                                                    Venmo
                                                                </div>
                                                                <div class="method-active"
                                                                    v-if="method.name == 'zelle'">
                                                                    Zelle
                                                                </div>
                                                            </template>
                                                        </div>
                                                        <div class="activity-shop">
                                                            <div class="activity-date"><a href=""
                                                                    @click.prevent="chat(offer.id)">Chat</a></div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="email-feild d-flex flex-wrap w-100">
                            <!-- <label for="price"> Amount</label> -->
                            <input type="number" name="price" id="price" v-model="state.price" placeholder="Amount"
                                required>
                            <span
                                style="width: 100%; display: flex; justify-content: start; color: red; margin-left: 10px;"
                                v-if="v$.price.$error">
                                {{ v$.price.$errors[0].$message }}
                            </span>
                            <input type="hidden" name="user_id" v-model="state.user_id">
                            <div class="icon"><img :src="'images/user.png'" alt=""></div>

                        </div>
                        <div class="col-xl-12 col-md-12 ">

                            <div class="graph__wrapper-width">

                                <div class="acivity-details">
                                    <div class="activity-info method-info">
                                        <div class="activity-shop">
                                            <div class="activity-name">Apply Pay</div>
                                        </div>

                                        <div class="activity-shop">
                                            <div class="method-img"><input type="checkbox" v-model="state.methods"
                                                    class="check-method" id="switch1" value="apple_pay" /><label
                                                    for="switch1" class="label-method">Toggle</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity-info method-info">
                                        <div class="activity-shop">
                                            <div class="activity-name">Chime</div>
                                        </div>

                                        <div class="activity-shop">
                                            <div class="method-img"><input type="checkbox" value="chime"
                                                    v-model="state.methods" class="check-method" id="switch2" /><label
                                                    for="switch2" class="label-method">Toggle</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity-info method-info">
                                        <div class="activity-shop">
                                            <div class="activity-name">Venmo </div>
                                        </div>

                                        <div class="activity-shop">
                                            <div class="method-img"><input type="checkbox" value="venmo"
                                                    v-model="state.methods" class="check-method" id="switch3" /><label
                                                    for="switch3" class="label-method">Toggle</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity-info method-info">
                                        <div class="activity-shop">
                                            <div class="activity-name"></div>Square Cash
                                        </div>

                                        <div class="activity-shop">
                                            <div class="method-img"><input type="checkbox" value="square_cash"
                                                    v-model="state.methods" class="check-method" id="switch4" /><label
                                                    for="switch4" class="label-method">Toggle</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity-info method-info">
                                        <div class="activity-shop">
                                            <div class="activity-name">PayPal</div>
                                        </div>

                                        <div class="activity-shop">
                                            <div class="method-img"><input type="checkbox" value="paypal"
                                                    v-model="state.methods" class="check-method" id="switch5" /><label
                                                    for="switch5" class="label-method">Toggle</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="activity-info method-info">
                                        <div class="activity-shop">
                                            <div class="activity-name">Zelle</div>
                                        </div>

                                        <div class="activity-shop">
                                            <div class="method-img"><input type="checkbox" value="zelle"
                                                    v-model="state.methods" class="check-method" id="switch6" /><label
                                                    for="switch6" class="label-method">Toggle</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="zelle-details">
                                        <p>Trades made with Zelle can only be processed on business days</p>
                                        <span
                                            style="width: 100%; display: flex; justify-content: start; color: red; margin-left: 50px;"
                                            v-if="v$.methods.$error">
                                            {{ v$.methods.$errors[0].$message }}
                                        </span>
                                    </div>
                                </div>

                                <div class="no-match-btn con">
                                    <div class="btn1"><button class="btn btn-primary"
                                            @click="matchRequestOffer()">Continue</button></div>
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
import useVuelidate from "@vuelidate/core";
import { useRouter, useRoute } from 'vue-router'
import {
    ref,
    reactive,
    computed,
    onMounted
} from "vue";

import {
    required,
    helpers
} from "@vuelidate/validators";
import store from '../../stores'

export default {
    name: 'CreateOffers',
    setup() {
        const offers = ref([])
        const matched_methods = ref([])
        const path = ref('match-offers')
        const route = useRoute()
        const router = useRouter()
        const state = reactive({
            price: '',
            methods: [],
            offerId: 0,
        })
        const currentuser = reactive(store.getters["auth/currentUser"])

        const rules = {
            price: {
                required: helpers.withMessage('The Amount field is required', required),
            },
            methods: {
                required: helpers.withMessage('Atleast one payment Method is required', required),
            },
        }

        const v$ = useVuelidate(rules, state)

        onMounted(() => {
            if (currentuser.is_phone_verified === 0) {
                router.push('/verify/phone')
            } else if (currentuser.is_email_verified === 0) {
                router.push('/verify/email')
            } else {
                const operator = JSON.parse(localStorage.getItem('operator'));
                const matchedWith = localStorage.getItem('matched-with');
                if (operator && matchedWith) {
                    router.push('/trade-in-process')
                }
            }
        })

        const matchRequestOffer = async () => {
            v$.value.$validate()
            // console.log("waseem",state);
            if (!v$.value.$error) {
                let result = await axios.post(path.value, state)
                if (result.data.success == true) {
                    Toast.fire({
                        text: result.data.message,
                        timer: 5000,
                        icon: 'success',
                        position: 'top-end',
                    });
                    offers.value = result.data.offer
                    matched_methods.value = result.data.matched_methods

                    // localStorage.setItem('matched-offer',JSON.stringify(result.data.offer))
                    // localStorage.setItem('matched-with','user')
                    // localStorage.setItem('requested-offer',JSON.stringify(state))
                    // router.push('/match-found')
                }
                else {
                    localStorage.setItem('matched-with', 'operator')
                    localStorage.setItem('requested-offer', JSON.stringify(state))
                    //   Toast.fire({
                    //             text: 'Offer Not Matched',
                    //             timer: 5000,
                    //             icon: 'success',
                    //             position: 'top-end',
                    //         });
                    router.push('/no-match-found')
                }
            }

        }

        const chat = async (offerId) => {

            const data = {
                offerId: offerId
            }
            await axios.post('chat-seller', data)
                .then((result) => {
                    console.log(result.data.offer)
                    console.log(state)
                    localStorage.setItem('matched-offer', JSON.stringify(result.data.offer))
                    localStorage.setItem('matched-with', 'user')
                    localStorage.setItem('requested-offer', JSON.stringify(state))
                    router.push('/match-found')
                })
        }


        return {
            state,
            v$,
            currentuser,
            matchRequestOffer,
            offers,
            matched_methods,
            chat
        }
    },

}
</script>
