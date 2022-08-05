<template>
<main>
    <div class="container">
        <h1 class="mt-4 title-dashboard">Dashboard</h1>

        <div v-if="Role == 'Player'" class="row">
            <div class="col-md-12 main-b">
                <div class="row active-card">
                    <div class="col-xl-3 col-md-4 col-sm-4">
                        <div class="card card__one--wrapper text-white mb-4">
                            <div class="card-body">
                                <div class="flex__wrapper-two">
                                    <div>
                                        <p class="card-label-one">Available Credit</p>
                                        <h3 class="card-heading-one">${{funds}}</h3>
                                    </div>
                                    <div>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-4">
                        <div class="card card__two--wrapper text-white mb-4">
                            <div class="card-body">
                                <div class="flex__wrapper-two">
                                    <div>
                                        <p class="card-label-one">Active Offers</p>
                                        <h3 class="card-heading-one">$0.00</h3>
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
                    <div class="active-title">
                        <h1>Active Offers</h1>
                    </div>

                    <div class="active-description">
                        <div v-if="offers.length === 0" class="active-info">
                            <p>You don't have active offer</p>
                        </div>
                        <div v-else class="acivity-details">
                            <template v-for="offer in offers" :key="offer.id">

                                <div class="activity-info">
                                    <div class="activity-shop">
                                        <div class="acivity-price">${{ offer.price }}</div>
                                    </div>
                                    <div class="activity-shop">
                                        <template v-for="(method, index) in offer.methods" :key="index">
                                            <div class="activity-date" v-if="method == 'apple_pay'">Apple Pay</div>
                                            <div class="activity-date" v-if="method == 'chime'">Chime</div>
                                            <div class="activity-date" v-if="method == 'paypal'">Paypal</div>
                                            <div class="activity-date" v-if="method == 'square_cash'">Square Cash
                                            </div>
                                            <div class="activity-date" v-if="method == 'venmo'">Venmo</div>
                                            <div class="activity-date" v-if="method == 'zelle'">Zelle</div>
                                        </template>
                                    </div>
                                    <div class="activity-shop">
                                        <div class="activity-date">
                                            <router-link :to="'/edit-offer/' + offer.id">edit</router-link>
                                        </div>
                                        <div class="activity-date"><a href="" @click.prevent="removeOffer(offer.id)">remove</a></div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <router-link to="/create-offers">
                            <div class="active-btn"><a href="">Create New Offer</a></div>

                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col-md-12 main-b">
                <div class="row">

                    <div class="col-xl-12 col-md-12 ">
                        <div class="active-title-2">
                            <h1>Activity</h1>
                        </div>
                        <div class="graph__wrapper-width">
                            <div class="hide-cancel">
                                <div class="hide-detail">
                                    <input type="checkbox" v-model="checked" value="1">
                                    <p>Hide canceled Trades</p>
                                </div>
                            </div>
                            <div class="acivity-details" v-for="history in orderBy" :key="history.id">

                                <div class="activity-info">
                                    <div class="activity-shop">
                                        <div class="activity-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
                                        <div class="activity-name">{{history.method}}</div>
                                    </div>
                                    <div class="activity-shop">
                                        <div class="activity-date">{{
                                            $moment(history.created_at).format("YYYY.MM.DD")
                                            }}</div>
                                        <div class="activity-time">{{
                                            $moment(history.created_at).format("hh:mm a")
                                            }}
                                        </div>
                                    </div>
                                    <div class="activity-shop">
                                        <div class="acivity-price">${{history.price}}</div>
                                        <div class="activity-next-icon"><a href="#"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></div>
                                    </div>
                                    <div class="activity-shop">
                                        <div class="acivity-price">{{history.status}}</div>
                                        <div class="activity-next-icon"><a href="#"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>

            </div>

        </div>

        <div v-if="Role == 'Operator'" class="row">
            <div class="col-md-12 main-b">
                <div class="row active-card">
                    <div class="col-xl-3 col-md-4 col-sm-4">
                        <div class="card card__one--wrapper text-white mb-4">
                            <div class="card-body">
                                <div class="flex__wrapper-two">
                                    <div>
                                        <p class="card-label-one">Username</p>
                                        <h3 class="card-heading-one">{{user.username}}</h3>
                                    </div>
                                    <div>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-3 col-md-4 col-sm-4">
                        <div class="card card__two--wrapper text-white mb-4">
                            <div class="card-body">
                                <div class="flex__wrapper-two">
                                    <div>
                                        <p class="card-label-one">Serve Users</p>
                                        <h3 class="card-heading-one">0</h3>
                                    </div>
                                    <div>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>

                <div class="active-details">
                    <div class="active-title">
                        <h1>Active Users</h1>
                    </div>

                    <div class="active-description">
                        <div v-if="users === 0" class="active-info">
                            <p>You don't have active user</p>
                        </div>
                        <div v-else class="acivity-details">

                            <div class="activity-info" v-if="mOff">
                                <div class="activity-shop">
                                    <div class="acivity-price">Offer</div>
                                </div>
                                <div class="activity-shop">
                                    <div class="acivity-price">${{matchOffer.price}}</div>
                                </div>
                                <div class="activity-shop">

                                    <div class="activity-date">
                                        <select v-model="method" style="width: 120px;padding: 10px;outline: none;border: 1px solid rgb(241, 238, 238);">
                                            <option v-for="(method,index) in matchOffer.methods" :key="index">{{ method }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="activity-info" v-if="buy">
                                <div class="activity-shop">
                                    <div class="acivity-price">Buyer</div>
                                </div>
                                <div class="activity-shop">
                                    <div class="acivity-price">{{buyer.username}}</div>
                                </div>
                                <div class="activity-shop">
                                    <div class="activity-date"><a href="#" v-if="fundsAdded == 0" class="btn btn-success" @click.prevent="addFunds()">add</a></div>
                                </div>
                            </div>

                            <div class="activity-info" v-if="sell">
                                <div class="activity-shop">
                                    <div class="acivity-price">Seller</div>
                                </div>
                                <div class="activity-shop">
                                    <div class="acivity-price">{{seller.username}}</div>
                                </div>
                                <div class="activity-shop">
                                    <div class="activity-date"><a href="#" v-if="subtract == 1" class="btn btn-success" @click.prevent="subFunds()">substract</a></div>
                                </div>
                            </div>

                            <div class="activity-info d-flex justify-content-center">
                                <div class="activity-shop">
                                    <div class="acivity-price">
                                        <router-link class="btn btn-primary" to="/trade-in-process">
                                            Continue Chat
                                        </router-link>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div v-if="Role == 'Admin'" class="row">
            <div class="col-md-12 main-b">
                <div class="row active-card">
                    <div class="col-xl-3 col-md-4 col-sm-4">
                        <div class="card card__one--wrapper text-white mb-4">
                            <div class="card-body">
                                <div class="flex__wrapper-two">
                                    <div>
                                        <p class="card-label-one">Players</p>
                                        <h3 class="card-heading-one">{{players}}</h3>
                                    </div>
                                    <div>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-4">
                        <div class="card card__two--wrapper text-white mb-4">
                            <div class="card-body">
                                <div class="flex__wrapper-two">
                                    <div>
                                        <p class="card-label-one">Operators</p>
                                        <h3 class="card-heading-one">{{operators}}</h3>
                                    </div>
                                    <div>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="overlay" v-if="respond == true && Role == 'Player'">
        <div class="popup">
            <h2>Offer Response</h2>
            <a class="close" href="#">&times;</a>
            <div class="content-pop">
                <div class="tex"> <b>Offer Matched !</b></div>
            </div>
            <div class="pop-tos">
                <div class="tos1"><a @click.prevent="cancelTrade()">Cancel</a></div>
                <div class="tos2">
                    <router-link to="/trade-in-process">Respond Now</router-link>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay" v-if="respond == true && Role == 'Operator'">
        <div class="popup">
            <h2>Trade Request</h2>
            <a class="close" href="#">&times;</a>
            <div class="content-pop">
                <div class="tex"> <b>{{buyer.username}} wants to buy game credits</b></div>
            </div>
            <div class="pop-tos">
                <!-- <div class="tos1"><a @click.prevent="cancelTrade()">Cancel</a></div> -->
                <div class="tos2">
                    <router-link to="/trade-in-process">Respond Now</router-link>
                </div>
            </div>
        </div>
    </div>
</main>
</template>

<script>
import {
    onMounted,
    ref,
    reactive,
    onUnmounted,
    onBeforeMount,
    watch
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
    remove,
    update,
    get
} from "firebase/database";
export default {
    name: 'Dashboard',
    setup() {
        const user = reactive(store.getters["auth/currentUser"])
        const Role = user.role
        const offers = ref([])
        const users = ref(0)
        const subtract = ref(0)
        const offerId = ref(0)
        const method = ref('')
        const orderBy = ref([])
        const fundsAdded = ref(0)
        const router = useRouter()
        const funds = ref(0.0);
        const respond = ref(false);
        const matchOffer = ref({});
        const buyer = ref({});
        const seller = ref({});
        const buy = ref(0);
        const sell = ref(0);
        const players = ref(0);
        const operators = ref(0);
        const mOff = ref(0);
        const db = getDatabase();
        const Fb_ref = storageRef(db, 'chat_matches')
        const checked = ref([])

        onMounted(() => {
            if (user.is_phone_verified === 0) {
                router.push('/verify/phone')
            } else if (user.is_email_verified === 0) {
                router.push('/verify/email')
            }
            if (Role == 'Admin') {
                getPlayers()
                getOperators()
            }
            if (Role == 'Player') {
                getFunds()
                getOffers();
                getHistory()
                remove(storageRef(db, 'order_complete/' + user.id))
            }
            if (Role == 'Operator') {
                const isFundsAdded = localStorage.getItem('isFundsAdded')
                if(isFundsAdded && isFundsAdded == 1)
                {
                    fundsAdded.value = 1
                    subtract.value = 1
                }
                const buyerr = JSON.parse(localStorage.getItem('buyer'));
                const sellerr = JSON.parse(localStorage.getItem('seller'));
                const requestedOffer = JSON.parse(localStorage.getItem('requested-offer'));
                const matchedOffer = JSON.parse(localStorage.getItem('matched-offer'));
                if (requestedOffer) {
                    if (buyerr) {
                        users.value = 1;
                        buy.value = 1;
                        buyer.value = buyerr;
                    }
                    if (sellerr) {
                        users.value = 1;
                        sell.value = 1;
                        seller.value = sellerr;
                    }
                    if (requestedOffer) {
                        mOff.value = 1;
                        matchOffer.value = requestedOffer;
                        method.value = requestedOffer.methods[0];
                    }
                } else {
                    router.push('/dashboard')
                }

                // console.log(buyerr)
                // console.log(sellerr)
                // console.log(requestedOffer)

            }

        })

        watch(checked, (newVal,oldVal) => {
            if(newVal == 1)
            {
                getCancelHistory()
            }
            else{
                getHistory()
            }
        })

        const getOffers = async () => {
            await axios.get('get-offers', )
                .then((response) => {
                    offers.value = response.data.offers;
                })
        }
        const getPlayers = async () => {
            await axios.get('get_player_count', )
                .then((response) => {
                    players.value = response.data;
                })
        }
        const getOperators = async () => {
            await axios.get('get_operator_count', )
                .then((response) => {
                    operators.value = response.data;
                })
        }

        const getHistory = async () => {
            await axios.get('get-history', )
                .then((response) => {
                    console.log(response.data.history)
                    orderBy.value = response.data.history;
                })
        }

        const getCancelHistory = async () => {
            await axios.get('order-cancel-history', )
                .then((response) => {
                    orderBy.value = response.data.history;
                })
        }

        const getFunds = async () => {

            await axios.get('get-funds')
                .then((response) => {
                    funds.value = response.data;
                })
        }

        const cancelTrade = async () => {
            const operator = JSON.parse(localStorage.getItem('operator'))
            await axios.post('change_operator_status',{
                                id: operator.id
                            })

            await axios.post('trade-cancel', {
                offerId : offerId.value,
                user_id : buyer.value.id
                })
                .then((response) => {
                    if (response.data.status == true) {
                        respond.value = false;
                        matchOffer.value = {};
                        localStorage.removeItem('matched-offer');
                        localStorage.removeItem('buyer');
                        localStorage.removeItem('operator');
                        const db = getDatabase();
                        const Fb_ref2 = storageRef(db, 'order_cancel/' + offerId.value)

                        const fb_push = push(Fb_ref2)
                        set(fb_push, {
                            trade: 'cancel',
                        });

                        remove(storageRef(db, 'chat_matches'))


                    }
                })

        }

        const getBuyer = async (bid) => {

            await axios.post('get_buyer', {
                    buyer_id: bid
                })
                .then((response) => {
                    if (response.data.status == true) {
                        users.value = 1;
                        buy.value = 1;
                        buyer.value = response.data.buyer;
                        localStorage.setItem('buyer', JSON.stringify(response.data.buyer));
                    }
                })
        }

        const getSeller = async (sid) => {

            await axios.post('get_seller', {
                    seller_id: sid
                })
                .then((response) => {
                    if (response.data.status == true) {
                        users.value = 1;
                        sell.value = 1;
                        seller.value = response.data.seller;
                        localStorage.setItem('seller', JSON.stringify(response.data.seller));
                    }
                })
        }

        const getOperator = async (oid) => {

            await axios.post('get_operator', {
                    operator_id: oid
                })
                .then((response) => {
                    if (response.data.status == true) {
                        localStorage.setItem('operator', JSON.stringify(response.data.operator));
                    }
                })
        }

        const removeOffer = async (offerId) => {
            const data = {
                offerId: offerId
            }
            await axios.post('remove-offer', data)
                .then((response) => {

                    getOffers()

                    Toast.fire({
                        text: response.data.message,
                        timer: 3000,
                        icon: 'success',
                        position: 'top-end',
                    });
                })
        }

        onValue(Fb_ref, (snapshot) => {
            snapshot.forEach((childSnapshot) => {
                const childKey = childSnapshot.key;
                const childData = childSnapshot.val();
                if (childData.operator == user.id && user.role == 'Operator') {
                    if (childData.offerId == 0) {
                        getBuyer(childData.buyer)
                        const price = childData.price;
                        const methods = childData.methods;
                        const reqOffer = {
                            price: price,
                            methods: methods.split(',')
                        }
                        matchOffer.value = {
                            price : price,
                            methods: methods.split(',')
                        }
                        mOff.value = 1;
                        offerId.value = childData.offerId
                        respond.value = true;
                        method.value = methods.split(',')[0];
                        localStorage.setItem('requested-offer', JSON.stringify(reqOffer))
                        remove(storageRef(db, 'chat_matches/' + childKey))
                    } else {
                        getBuyer(childData.buyer)
                        getSeller(childData.seller)
                        const price = childData.price;
                        const methods = childData.methods;
                        const reqOffer = {
                            offer: {
                                id: childData.offerId,
                                price: price
                            },
                            matched_methods: methods.split(',')
                        }
                        mOff.value = 1;
                        offerId.value = childData.offerId
                        matchOffer.value = {
                            price : price,
                            methods: methods.split(',')
                        }
                        method.value = methods.split(',')[0];
                        localStorage.setItem('matched-offer', JSON.stringify(reqOffer))
                        if(childData.seller_response == 0)
                        respond.value = true;
                        update(storageRef(db, 'chat_matches/' + childKey), {
                            operator_response: 1
                        })
                    }
                } else if (childData.seller == user.id && user.role == 'Player') {
                    // if (childData.seller_response == 0) {
                        getBuyer(childData.buyer)
                        getOperator(childData.operator)
                        const price = childData.price;
                        const methods = childData.methods;
                        const reqOffer = {
                            offer: {
                                id: childData.offerId,
                                price: price
                            },
                            matched_methods: methods.split(',')
                        }
                        offerId.value = childData.offerId
                        localStorage.setItem('matched-offer', JSON.stringify(reqOffer))
                        respond.value = true;
                        update(storageRef(db, 'chat_matches/' + childKey), {
                            seller_response: 1
                        })
                    // }
                }
                get(storageRef(db, 'chat_matches/' + childKey), (snapshot) => {
                    const data = snapshot.val()
                    const key = snapshot.key
                    if (snapshot.exists() && data.seller_response == 0 && data.operator_response == 0) {
                        remove(storageRef(db, 'chat_matches/' + key))
                    }
                })

            });

        });

        const addFunds = async () => {
            await axios.post('add-funds', {
                user_id: buyer.value.id,
                price: matchOffer.value.price
            })
            localStorage.setItem('isFundsAdded',1)
            fundsAdded.value = 1
            if(offerId.value == 0)
            {
                await axios.post('change_operator_status')
            }
            const data = {
                user_id: buyer.value.id,
                offer_id: offerId.value,
                price: matchOffer.value.price,
                payment_method: method.value
            }
            await axios.post('order-history', data).then((response) => {
                if (response.data.status == true) {
                    const db = getDatabase();
                        const Fb_ref2 = storageRef(db, 'order_complete/buyer/' + buyer.value.id)

                        const fb_push = push(Fb_ref2)
                        set(fb_push, {
                            trade: 'complete',
                        });

                    if(offerId.value != 0)
                    {
                            subtract.value = 1
                        Toast.fire({
                            text: '$' + data.price + ' added to buyer account.',
                            timer: 2000,
                            icon: 'success',
                            position: 'top-end',
                        });


                    }
                    else{
                        // localStorage.removeItem('buyer');
                        // localStorage.removeItem('requested-offer');
                        // localStorage.removeItem('matched-with');
                        // localStorage.removeItem('operator');
                        // localStorage.removeItem('isFundsAdded');
                        remove(storageRef(db, 'chat_messages/' + '0_' + user.id + '_0_' + buyer.value.id));
                        users.value = 0;
                        sell.value = 0;
                        buy.value = 0;
                        mOff.value = 0;
                        respond.value = false;
                        buyer.value = {};
                        seller.value = {};
                        matchOffer.value = {};
                        router.push('/trade-complete')
                    }




                }
            })
        }

        const subFunds = async () => {
            await axios.post('sub-funds', {
                user_id: seller.value.id,
                price: matchOffer.value.price
            })

            await axios.post('change_operator_status')


                    // localStorage.removeItem('buyer');
                    // localStorage.removeItem('seller');
                    // localStorage.removeItem('matched-offer');
                    // localStorage.removeItem('isFundsAdded')
                    Toast.fire({
                        text: 'Trade completed successfully.',
                        timer: 2000,
                        icon: 'success',
                        position: 'top-end',
                    });
                    const db = getDatabase();
                    const Fb_ref2 = storageRef(db, 'order_complete/seller/' + seller.value.id)

                    const fb_push = push(Fb_ref2)
                    set(fb_push, {
                        trade: 'complete',
                    });
                    remove(storageRef(db, 'chat_messages/' + '0_' + user.id + '_0_' + buyer.value.id));
                    users.value = 0;
                    sell.value = 0;
                    buy.value = 0;
                    mOff.value = 0;
                    respond.value = false;
                    buyer.value = {};
                    seller.value = {};
                    matchOffer.value = {};


                    remove(storageRef(db, 'chat_matches'))

                    router.push('/trade-complete')

        }

        return {
            offers,
            removeOffer,
            funds,
            respond,
            cancelTrade,
            orderBy,
            Role,
            user,
            buyer,
            users,
            buy,
            sell,
            seller,
            matchOffer,
            mOff,
            addFunds,
            method,
            players,
            operators,
            subFunds,
            subtract,
            fundsAdded,
            checked
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
</style>
