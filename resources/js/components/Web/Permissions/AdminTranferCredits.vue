<template>
    <main>
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="mt-4 title-dashboard">Players</h1>
                <div class="box1 mt-4">
                </div>
            </div>

            <div class="row">

                <div class="col-md-12 main-b">
                    <div class="row">

                        <div class="col-xl-12 col-md-12 ">

                            <div class="graph__wrapper-width pd">

                                <div class="table-container p-4">
                                    <table class="table-rwd" id="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>funds</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(user, index) in users" :key="index">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ user.username }}</td>
                                                <td>{{ user.email }}</td>
                                                <td>{{ user.phone }}</td>
                                                <td>{{ user.funds }}</td>

                                                <td>
                                                    <div class=" row">
                                                        <div class=" col-xl-6 col-md-6 ">
                                                            <span @click.prevent="showPopup(user.id) "><span
                                                                    title="Add Funds"
                                                                    style="font-size: x-large;color:green">
                                                                    <ion-icon class="create" name="add-outline">
                                                                    </ion-icon>
                                                                </span></span>
                                                        </div>

                                                        <div class="col-xl-6 col-md-6">
                                                            <span @click.prevent="showPopup2(user.id) "><span
                                                                    title="Subtract Funds" style="font-size: x-large;">
                                                                    <ion-icon class="delete" name="remove-outline">
                                                                    </ion-icon>
                                                                </span></span>
                                                        </div>

                                                    </div>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>


                                </div>

                            </div>

                        </div>

                        <div id="popup1" v-if="popup == true" class="overlay">
                            <div class="popup">
                                <h2>Add Funds transfer</h2>
                                <a class="close" href="#" @click.prevent="closePopup()">&times;</a>
                                <div class="email-feild account-feild w-100"><input type="text" name="funds"
                                        v-model="state.funds" required="" @keyup.enter="addTranferCredit()"></div>
                                <div v-if="v$.funds.$error" style="text-align:center">
                                    <b style="color:red;">
                                        {{ v$.funds.$errors[0].$message }}
                                    </b>
                                </div>
                                <!-- </div> -->
                                <div class="pop-tos">
                                    <div class="tos1"><a href="#" @click.prevent="closePopup()">Cancel</a>
                                    </div>
                                    <div class="tos2">
                                        <a style="color:white" @click="addTranferCredit()">Confirm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="popup1" v-if="popup2 == true" class="overlay">
                            <div class="popup">
                                <h2>Subtract Funds transfer</h2>
                                <a class="close" href="#" @click.prevent="closePopup2()">&times;</a>
                                <!-- <div class="content-pop"> -->
                                <div class="email-feild account-feild w-100"><input type="text" name="funds"
                                        v-model="state.funds" required="" @keyup.enter="subTranferCredit()"></div>
                                <div v-if="v$.funds.$error" style="text-align:center">
                                    <b style="color:red;">
                                        {{ v$.funds.$errors[0].$message }}
                                    </b>
                                </div>
                                <!-- </div> -->
                                <div class="pop-tos">
                                    <div class="tos1"><a href="#" @click.prevent="closePopup2()">Cancel</a>
                                    </div>
                                    <div class="tos2">
                                        <a style="color:white" @click="subTranferCredit()">Confirm</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
        <div class="loader-wrapper" style="display: flex;">
            <span class="loader"><span class="loader-inner"></span></span>
        </div>
    </main>
</template>
<script>
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import useVuelidate from "@vuelidate/core";
import axios from 'axios';
import {
    required,
    email,
    minLength,
    helpers
} from "@vuelidate/validators";
import {
    onMounted,
    ref,
    reactive,
    onUnmounted,
    onBeforeMount
} from 'vue'
import store from '../../../stores'
import {
    useRouter, useRoute
} from 'vue-router';
export default {
    name: 'AdminTranferCredits',
    setup() {
        const users = ref([])
        const state = reactive({
            funds:0
        })
        const uid = ref(0)
        const player = ref([])
        const user = reactive(store.getters["auth/currentUser"])
        const popup = ref(false)
        const popup2 = ref(false)
        const router = useRouter()
        const $externalResults = ref({})
        const route = useRoute()


        const rules = {
            funds: {
                required: helpers.withMessage('Funds must be required', required),
                
            },
        }
        const v$ = useVuelidate(rules, state , {
            $externalResults
        })

        onMounted(() => {
            if (user.is_phone_verified === 0) {
                router.push('/verify/phone')
            }
            else if (user.is_email_verified === 0) {
                router.push('/verify/email')
            }
            getTranferCredit()
        })

        const getTranferCredit = async () => {
            await axios.get('admin_plyers_credit',)
                .then((response) => {
                    // console.log(response.data)
                    users.value = response.data.users;
                })
            $('#table').DataTable();
        }

        const addTranferCredit = async () => {
            v$.value.$clearExternalResults()
            v$.value.$validate()
            if (!v$.value.$error) {
                const data = {
                    userId: uid.value,
                    funds: state.funds
                }

                await axios.post('admin_edit_credit', data)
                    .then((response) => {
                        if (response.data.success == true) {
                            console.log(response.data)
                            closePopup()
                            getTranferCredit()
                            state.funds = 0
                        } else {
                            $externalResults.value = {
                                funds: [response.data.message]
                            }
                        }
                            
                       
                        })
            $('#table').DataTable();
        }
}
        const subTranferCredit = async () => {

            v$.value.$clearExternalResults()
            v$.value.$validate()
            if (!v$.value.$error) {
                const data = {
                    userId: uid.value,
                    funds: state.funds
                }

                await axios.post('admin_minus_credit', data)
                    .then((response) => {
                        // console.log(response.data)
                        if (response.data.success == true) {

                            closePopup2()
                            getTranferCredit()
                            state.funds = 0
                        // player.value = response.data.users;
                        } else {
                            $externalResults.value = {
                                funds: [response.data.message]
                            }
                        }
                        

                    })
           
                $('#table').DataTable();
            }
        }


        const showPopup = (id) => {
            popup.value = true;
            uid.value= id
        }

        const showPopup2 = (id) => {
            popup2.value = true;
            uid.value = id
        }

        const closePopup = () => {
            v$.value.$clearExternalResults()
            popup.value = false;
            state.funds = 0
        }
        const closePopup2 = () => {
            v$.value.$clearExternalResults()
            popup2.value = false;
            state.funds = 0
        }

        return {
            users,
            popup,
            closePopup,
            closePopup2,
            popup2,
            showPopup2,
            showPopup,
            showPopup,
            player,
            addTranferCredit, 
            state,
            subTranferCredit,
            v$
        }

    }
}

</script>
<style scoped>

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
.button{
        /* display: flex; */
            align-items: center;
            justify-content: center;
            padding: 5px 3px;
            background: rgb(4, 138, 79);
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
            font-size: 20px;
            font-weight: 500;
            border: 1px solid rgb(4, 138, 79);
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease-out;
            width: 82px;
            margin: auto
}

.col-xl-6 {
    flex: 0 0 50%;
    max-width: 31%;
}
</style>

