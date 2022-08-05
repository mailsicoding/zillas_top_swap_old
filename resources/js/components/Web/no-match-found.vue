<template>
<main>
    <div class="container">
        <div class="account-title match-title">
            <h4>No Match Found</h4>
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
                                        <h3 class="card-heading-one">{{currentuser.username}}</h3>
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
                                        <h3 class="card-heading-one">${{amount}}</h3>
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
                    <div class="no-match-seacrh">
                        <img src="assets/images/search.png" alt="">
                    </div>
                    <div class="active-description">
                        <div class="active-info">
                            <p><b>Sorry We couldn't find an exact match.</b></p>
                        </div>
                        <div class="no-match-p"><br>
                            <button class="btn btn-success" @click.prevent="matchOperator()">Buy From Admin</button><br>
                            <button class="btn btn-info mt-3" @click.prevent="matchAgain()">Match Again</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</main>
</template>

<script>
import store from '../../stores'
import { onMounted, reactive, ref } from '@vue/runtime-core'
import { useRouter } from 'vue-router'
import app from '../../firebase'
import { getDatabase,ref as storageRef, set,push,onValue } from "firebase/database";
export default {
    name: 'no-match-found',
    setup() {
        const currentuser = reactive(store.getters["auth/currentUser"])
        const amount = ref(0.0)
        const router = useRouter()

        onMounted(() => {
            if (currentuser.is_phone_verified === 0) {
                router.push('/verify/phone')
            } else if (currentuser.is_email_verified === 0) {
                router.push('/verify/email')
            } else {
            const requestedOffer = JSON.parse(localStorage.getItem('requested-offer'));
            const matchedWith = localStorage.getItem('matched-with');
            if (requestedOffer && matchedWith) {
                amount.value = requestedOffer.price
            }
            else{
                router.push('/dashboard');
            }
            }
        })

        const matchOperator = async() => {
            await axios.get('find_operator').then(response => {
                if(Object.keys(response.data).length)
                {
                    localStorage.setItem('operator' , JSON.stringify(response.data))
                    const requestedOffer = JSON.parse(localStorage.getItem('requested-offer'));
                    const db = getDatabase();
                    const Fb_ref = storageRef(db, 'chat_matches')

                    const fb_push = push(Fb_ref)
                        const methods = requestedOffer.methods;
                        set(fb_push, {
                            operator: response.data.id,
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
                }
                else{
                    Toast.fire({
                            text: 'Operator is busy. Please Try again later',
                            timer: 2000,
                            icon: 'success',
                            position: 'top-end',
                        });
                    matchAgain()
                }
            })
        }

        const matchAgain = async() => {
            localStorage.removeItem('requested-offer')
            localStorage.removeItem('matched-with')
            router.push('/match-request')
        }

        return {
            currentuser,
            amount,
            matchOperator,
            matchAgain
        }

    }

}
</script>
