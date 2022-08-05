<template>
    <main>
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="mt-4 title-dashboard">Funds</h1>
                <!-- <div class="box1 mt-4">
                    <router-link class="btn btn-primary" to="/add_user">
                        Add
                    </router-link>
                </div> -->
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
                                                <th>Add Funds</th>
                                                <th>Subtract Funds</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(user, index) in users" :key="index">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ user.username }}</td>
                                                <td>{{ user.email }}</td>
                                                <td>{{ user.phone }}</td>
                                                <td>
                                                    <button class="btn btn-success">Add</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success">Subtract</button>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div v-if="emailPopup === 0" class="overlay2">
            <div class="popup_phone">
                <h2>Add Funds</h2>
                <div class="edit">
                    <div class="row">
                        <div class="col-sm-6 we">
                            <p class="mb-0">We sent code to</p>
                            <h6>{{email}}</h6>
                        </div>
                        <div class="col-sm-6 edit_link">
                            <router-link class="btn_link" to="/account-setting">Edit</router-link>
                        </div>
                    </div>
                </div>

                <div class=" col-sm-12 code">
                    <h3>Enter Your Code</h3>
                    <form class="code_form">

                        <input type="number" v-model="emailCode.e1" @input="changeTab(2)" ref="ei1" maxlength="1" placeholder="-" required="">
                        <input type="number" v-model="emailCode.e2" ref="ei2"  @input="changeTab(3)" maxlength="1" placeholder="-" required="">
                        <input type="number" v-model="emailCode.e3" ref="ei3"  @input="changeTab(4)" maxlength="1" placeholder="-" required="">
                        <input type="number" v-model="emailCode.e4" ref="ei4"  @input="changeTab(5)" maxlength="1" placeholder="-" required="">
                        <input type="number" v-model="emailCode.e5" ref="ei5"  @input="changeTab(6)" maxlength="1" placeholder="-" required="">
                        <input type="number" v-model="emailCode.e6" ref="ei6"  @input="changeTab(1)" maxlength="1" placeholder="-" required="">

                    </form>
                    <h6 style="color: red;" v-if="v1$.$error">
                            {{ v1$.$errors[0].$message }}
                    </h6>
                    <h6>Expires in 5 minutes</h6>


                </div>
                <div class="pop-btn">

                    <div class="box1">
                        <a class="Verify" @click.prevent="verifyEmail()">Verify</a>
                    </div>
                    <div class="box1">
                        <a class="Resend" @click.prevent="resendEmailOTP()">Resend Code</a>
                    </div>
                    <div class="box1 text-center">
                        <a class="Log Out" @click.prevent="logout()">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import axios from 'axios';
import {
    onMounted,
    ref,
    reactive,
    onUnmounted,
    onBeforeMount
} from 'vue'
import store from '../../stores'
import {
    useRouter, useRoute
} from 'vue-router';
export default {
    name: 'funds',
    setup() {
        const users = ref([])
        const user = reactive(store.getters["auth/currentUser"])

        const router = useRouter()
        const route = useRoute()

        onMounted(() => {
            if (user.is_phone_verified === 0) {
                router.push('/verify/phone')
            }
            else if (user.is_email_verified === 0) {
                router.push('/verify/email')
            }
            getOperators()
        })

        const getOperators = async () => {
            await axios.get('getOperators',)
                .then((response) => {
                    users.value = response.data.users;
                })
            $('#table').DataTable();
        }

        return {
            users,
        }

    }
}

</script>
<style>
.overlay1 {
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
.overlay2 {
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
 .popup_phone {
    margin: 70px auto;
    padding: 50px;
    background: #fff;
    border-radius: 5px;
    width: 545px;
     height:565;
    position: relative;
}
 .popup_phone h2 {
    margin-top: 0;
    color: #333;
    text-align: left;
    font-size: 20px;
}

 .popup_phone h3 {
    margin-top: 0;
    color: #333;
    text-align: center;
    font-size: 20px;
     padding: 10px 0px 10px 0px
}
 .popup_phone .close {
    position: absolute;
    top: 20px;
    right: 30px;
    transition: all 200ms;
    font-size: 30px;
    font-weight: bold;
    text-decoration: none;
    color: #333;
}
          we p{
    font-size:14px;
    font-weight: 400;
    text-decoration: none;
    color: #949494;
          }
          .edit {
              background-color: #eeeeee;
                  padding: 10px 20px 10px 20px;
              border-radius: 5px;
          }

          .edit_link{
              text-align: right;
                  padding-top: 12px;
          }

          .edit_link a{
              color: #15b0b1;
          }
 .trade-feild input {
    padding: 15px !important;
}

.code input {
        width: 53px;
    height: 50px;
    padding: 11px;
    border-radius: 10px;
    outline: none;
    border: 1px solid #bfbfbf;
    margin-left: 10px;
}
.code_form {
 display: flex;
justify-content: center;
          }
.code h3{
 text-align: center
          }
      .code code_form{
              text-align: center
          }
          .code{
              width: 100%
          }
 .code h6{
     font-size: 14px;
    font-weight: 300;
     color: ##a3a3a3;
     text-align:center;
     padding: 10px 0px 10px 0px

          }
 .Verify {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 60px;
    background: #e6e6e6;
    border-radius: 4px;
    text-decoration: none;
    color: #b1b1b1;
    font-size: 20px;
    font-weight: 500;
    border-radius: 10px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease-out;
    width: 350px;
    margin: auto;
}
 .Verify:hover {
    background-color: transparent;
    border: 1px solid #e6e6e6;
    transition: all .5s ease-in-out;
    color: #adadad;
    text-decoration: none;
}
  .Resend {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 60px;
    background: transparent;
    border-radius: 4px;
    text-decoration: none;
    color: #00aaab;
    font-size: 20px;
    font-weight: 500;
    border: 1px solid #00aaab;
    border-radius: 10px;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease-out;
    width: 350px;
    margin: auto;
}
 .Resend:hover {
    background-color: transparent;
    border: 1px solid #e6e6e6;
    transition: all .5s ease-in-out;
    color: #adadad;
    text-decoration: none;
}

  @media(min-width:320px) and (max-width:575px) {
	  .popup_phone
	  {
		  width: 98%;
		  padding-left: 43px;
	  }
	 .Verify {

    width: 80%;
}
	  .Resend
	   {

    width: 80%;
		   padding: 12px 12px;
}
		  }
.code input {
    width: 53px;
    height: 50px;
    padding: 11px;
    border-radius: 10px;
    outline: none;
    border: 1px solid #bfbfbf;
    margin-left: 10px;
    text-align: center;
}
       /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
     </style>
