<template>
    <main>
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="mt-4 title-dashboard" v-if="path == 'add_user'">Add User</h1>
                <h1 class="mt-4 title-dashboard" v-else>Edit User</h1>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12 col-lg-6">
                    <div class="user_input">
                        <input type="text" name="name" v-model="state.username" placeholder="username" required  
                        @keyup.enter="signup()" >
                    </div>
                    <div v-if="v$.username.$error">
                        <b style="color:red;">
                            {{ v$.username.$errors[0].$message }}
                        </b>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 col-lg-6">
                    <div class="user_input">
                        <input type="email" name="email" v-model="state.email" placeholder="Email" required  @keyup.enter="signup()">
                    </div>
                    <div v-if="v$.email.$error">
                        <b style="color:red;">
                            {{ v$.email.$errors[0].$message }}
                        </b>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 col-lg-6">
                    <div class="user_input">
                        <select  v-model="state.code" style="width: 120px;padding: 20px;outline: none;border: 1px solid rgb(241, 238, 238);">
                    <option>+1</option>
                    <option>+92</option>
              </select>
                        <input type="number" v-model="state.phone" placeholder="xxxxxxxxxx" class="f-num" required=""  @keyup.enter="signup()">

                    </div>
                    <div v-if="v$.phone.$error">
                        <b style="color:red;">
                            {{ v$.phone.$errors[0].$message }}
                        </b>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 col-lg-6">
                    <div class="user_input">
                        <input type="password" name="password" v-model="state.password" placeholder="Password" required  autocomplete="false"  @keyup.enter="signup()">
                    </div>
                    <div v-if="v$.password.$error">
                        <b style="color:red;">
                            {{ v$.password.$errors[0].$message }}
                        </b>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-lg-6">
                    <div class="user_input">
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                            v-model="state.role">
                            <option value="3">Admin</option>
                            <option value="2">Operator</option>
                            <option value="1">Player</option>
                        </select>
                    </div>
                    <div v-if="v$.role.$error">
                        <b style="color:red;">
                            {{ v$.role.$errors[0].$message }}
                        </b>
                    </div>
                </div>

                <div class="login-form-btn">
                    <div class="btn"><a @click.prevent="signup()">Save</a></div>
                </div>

            </div>

        </div>

    </main>
</template>
<script>
import axios from 'axios';
import useVuelidate from "@vuelidate/core";
import {
    reactive,
    ref,
    onMounted
} from "vue";
import {
    required,
    email,
    minLength,
    maxLength,
    helpers,
    alphaNum,
    integer
} from "@vuelidate/validators";
import {
    useRouter, useRoute
} from 'vue-router';
import store from '../../../stores'

export default {
    name: 'addUser',
    setup() {
        const state = reactive({
            username: '',
            email: '',
            code: '+1',
            phone: '',
            password: '',
            role: '1',
            userId: 0
        })
        // console.log(state.userId)
        const router = useRouter()
        const route = useRoute()
        const user = reactive(store.getters["auth/currentUser"])
        const path = ref('add_user')

        onMounted(() => {
            if (user.is_phone_verified === 0) {
                router.push('/verify/phone')
            }
            else if (user.is_email_verified === 0) {
                router.push('/verify/email')
            }
            else {
                if(route.params.userId)
                edit_user()
            }
        })

        const $externalResults = ref({})
        const rules = {
            username: {
                required: helpers.withMessage('Name must be required', required),
                alphaNum: helpers.withMessage("Username must not contain spaces and dashes.", alphaNum),
            },
            email: {
                required: helpers.withMessage('Email must be required', required),
                email: helpers.withMessage("Enter valid email address.", email),
            },
            phone: {
                required: helpers.withMessage("Phone field is required.", required),
                integer: helpers.withMessage("Phone Number must conatin numbers.", integer),
                minLength: minLength(10),
                maxLength: maxLength(10),
            },

            password: {
                required: helpers.withMessage('Password must be required', required),
                minLength: minLength(8)
            },
            role: {
                required: helpers.withMessage('Role must be required', required),
            },
        }
        const v$ = useVuelidate(rules, state, {
            $externalResults
        })


        const signup = async () => {
            v$.value.$clearExternalResults()
            v$.value.$validate()
            if (!v$.value.$error) {
                let result = await axios.post(path.value, state)
                if (result.data.success == true) {
                    router.push({
                        name: 'users'
                    })
                    Toast.fire({
                        text: result.data.message,
                        timer: 5000,
                        icon: 'success',
                        position: 'top-end',
                    });
                }
                else {
                    $externalResults.value = result.data.message
                }

            } else {
                // console.log('Form failed validation')
            }

        }
        const edit_user = async () => {
            if (route.params.userId) {
                const data = {
                    userId: route.params.userId
                }
                await axios.post('edit-user', data)
                    .then((response) => {
                        path.value = 'update-user'
                        state.username = response.data.user.username
                        state.email = response.data.user.email
                        state.password = response.data.user.password
                        let text = response.data.user.phone;
                        state.code =  text.substr(0, 3);
                        state.phone = text.substr(3, 13);
                        state.role = response.data.user.role[0].id
                        state.userId = data.userId
                    })
                    // console.log(state)
            }
        }


        return {
            state,
            signup,
            v$,
            path
        }

    }
}

</script>
