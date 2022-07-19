<template>
    <main>
        <div class="container ">


            <div class="row">
                <div class="account-detail">
                    <div class="account-info">
                        <div class="account-title">
                            <h4>Contact Us</h4>
                        </div>
                        <div class="account-conatct-detail">
                            <div class="account-description">
                                <p></p>
                            </div>
                            <div class="account-form">
                                <form>
                                    <div class="email-feild account-feild">
                                        <div class="user_input">
                                            <input type="text" name="name" v-model="state.name" id="Name"
                                                placeholder="Name" required>
                                            <!-- <div class="icon"><img src="img/Layer174.png" alt=""></div> -->
                                        </div>
                                        <div v-if="v$.name.$error">
                                            <b style="color:red;">
                                                {{ v$.name.$errors[0].$message }}
                                            </b>
                                        </div>
                                    </div>
                                    <div class="email-feild account-feild">
                                        <div class="user_input">
                                            <input type="email" name="email" v-model="state.email" id="Email"
                                                placeholder="Email" required>
                                            <!-- <div class="icon"><img src="img/Layer175.png" alt=""></div> -->
                                        </div>
                                        <div v-if="v$.email.$error">
                                            <b style="color:red;">
                                                {{ v$.email.$errors[0].$message }}
                                            </b>
                                        </div>
                                    </div>
                                    <div class="email-feild account-feild">
                                        <div class="user_input">
                                            <input type="text" name="message" v-model="state.message" id="Message"
                                                placeholder="Message" required>
                                            <!-- <div class="icon"><img src="img/Layer174.png" alt=""></div> -->
                                        </div>
                                        <div v-if="v$.message.$error">
                                            <b style="color:red;">
                                                {{ v$.message.$errors[0].$message }}
                                            </b>
                                        </div>
                                    </div>

                                    <div class="login-form-btn account-f-btn">
                                        <div class="btn account-b">
                                            <a @click.prevent="contactus()">Submit</a>
                                        </div>
                                    </div>
                                </form>
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
import useVuelidate from '@vuelidate/core';
import {
    reactive,
    ref,
    onMounted
} from 'vue';

import {
    required,
    name,
    email,
    message,
    helpers
} from '@vuelidate/validators';

import {
    useRouter, useRoute
} from 'vue-router';

import store from '../../stores';

export default {
    setup() {
        const state = reactive({
            name: '',
            email: '',
            message: ''
        })
        const router = useRouter()
        const route = useRoute()
        const user = reactive(store.getters["auth/currentUser"])
        const path = ref("contact")
        console.log(path);

        const $externalResults = ref({})
        const rules = {
            name: {
                required: helpers.withMessage('Name is Required', required),
            },
            email: {
                required: helpers.withMessage('email is required', required),
                email: helpers.withMessage('Enter valid email address', email),
            },
            message: {
                required: helpers.withMessage('Message is required', required),
            },
        }
        const v$ = useVuelidate(rules, state, {
            $externalResults
        })

        const contactus = async () => {
            v$.value.$clearExternalResults()
            v$.value.$validate()
            if (!v$.value.$error) {
                let result = await axios.post(path.value, state)
                if (result.data.success == true) {
                    router.push({
                        name: 'contact'
                    })
                    Toast.fire({
                        text: result.data.message,
                        timer: 2000,
                        icon: 'success',
                        position: 'top-end',
                    });
                } else {
                    $externalResults.value = result.data.message
                    console.log("errorExternal");
                }
            } else {
                console.log('form failed validation')
            }
        }

        return {
            state,
            contactus,
            v$,
        }
    }
}
</script>
