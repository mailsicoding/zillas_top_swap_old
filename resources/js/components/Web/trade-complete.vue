<template>
    <main>
             <div class="container">

                <div class="account-title match-title">
                  <h4>Trade Complete</h4>
                </div>
                <div class="row">
                  <div class="col-md-12 main-b">

                     <div class="active-details">
                       <div class="management">
                        <img src="assets/img/presentation.png" alt="">
                       </div>
                       <div class="active-description">
                         <div class="active-info"><p><b>Trade Complete</b></p></div>
                         <div class="active-info"><p><b class="price-bold">${{state.price}}</b></p></div>
                         <div class="no-match-p"><p>Credited back to your merchant account</p></div>
                       </div>
                     </div>
                  </div>
                  <div class="col-md-12 main-b">
                    <div class="row">
                     <div class="experiance-box">
                       <div class="experi-details">
                         <b class="experi-data">How was your experience with {{state.username}}?</b>
                       </div>
                       <div class="ealanaj-icon">
                         <div class="sad1"><img src="assets/images/happiness.png" alt=""></div>
                         <div class="sad2"><img src="assets/images/sad2.png" alt=""></div>
                       </div>
                     </div>
                    </div>

                  </div>

                </div>

              </div>

            </main>
</template>
<script>
import { onMounted, reactive } from 'vue'
import { useRouter } from 'vue-router'
export default {
    name: 'trade-complete',
    setup(){
        const state = reactive({
            username : '',
            price : '',
        })
        const router = useRouter()

        onMounted(()=>{
                const offer = JSON.parse(localStorage.getItem('matched-offer'));
                const operator = JSON.parse(localStorage.getItem('operator'));
                const buyer = JSON.parse(localStorage.getItem('buyer'));
                const seller = JSON.parse(localStorage.getItem('seller'));
                const matchedWith = localStorage.getItem('matched-with');
                const requestedOffer = JSON.parse(localStorage.getItem('requested-offer'));
                if(requestedOffer){
                    state.price = requestedOffer.price
                    if(buyer)
                    {
                        state.username = buyer.username
                    }
                    if(operator)
                    {
                        state.username = operator.username
                    }
                } else if(offer){
                    state.price = offer.offer.price
                    if(buyer && seller)
                    state.username = seller.username
                    else if(operator && seller)
                    state.username = seller.username
                    else
                    state.username = buyer.username

                }else {
                    router.push('/dashboard')
                }
                localStorage.removeItem('buyer');
                localStorage.removeItem('seller');
                localStorage.removeItem('requested-offer');
                localStorage.removeItem('matched-with');
                localStorage.removeItem('matched-offer');
                localStorage.removeItem('matched-offer-user');
                localStorage.removeItem('isFundsAdded')
                localStorage.removeItem('operator');
        })

        return {
            state
        }
    }
}
</script>
