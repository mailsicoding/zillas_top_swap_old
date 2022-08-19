<template>
    <main>
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="mt-4 title-dashboard">Contact List</h1>
                <div class="box1 mt-4">
                    <!-- <router-link class="btn btn-primary" to="/add_contact_us">
                        Add
                    </router-link> -->
                </div>
            </div>

            <div class="row">

                <div class="col-md-12 main-b">
                    <div class="row">

                        <div class="col-xl-12 col-md-12 ">

                            <div class="graph__wrapper-width pd">

                                <div class="table-container">
                                    <table class="table-rwd" id="table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(contact, index) in contacts" :key="index">
                                                <td v-for="(contact2, index2) in contact" :key="index2">{{ contact2.chat_name }}</td>
                                                <td v-for="(contact2, index2) in contact" :key="index2">{{ contact2.chat_email }}</td>
                                                <td v-for="(contact2, index2) in contact" :key="index2">{{ contact2.message }}</td>
                                                <td v-for="(contact2, index2) in contact" :key="index2">
                                                    
                                                    <router-link :to="'/admin/contact/' + index" class="btn btn-success" >
                                                        Chat
                                                    </router-link>
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

    </main>
</template>
<script>
import store from '../../stores'
import axios from 'axios'
import {
    onMounted,
    ref,
    onUpdated,
    reactive,
    onUnmounted,
} from 'vue'
import {
    useRoute, useRouter
} from 'vue-router'
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
    name: 'contacts',
    setup() {
        const contacts = ref([])
        const router = useRouter()
        const route = useRoute()
        const currentuser = reactive(store.getters["auth/currentUser"])
        const db = getDatabase();


        onMounted(() => {
            if (currentuser.is_phone_verified === 0) {
                router.push('/verify/phone')
            } else if (currentuser.is_email_verified === 0) {
                router.push('/verify/email')
            } else {
            OnlineChat()
            }
        })

        onUpdated(() => {
            OnlineChat()
        })



        const OnlineChat = () => {
            onValue(storageRef(db, 'contact_list'), (snapshot) => {
                contacts.value = snapshot.val()
            });
        }


        const delete_contact = async (id) => {
            axios.delete('/api/contact/'+ id)
                .then((response) => {
                    getContacts()
                    Toast.fire({
                        text: response.data.message,
                        timer: 5000,
                        icon: 'success',
                        position: 'top-end',
                    });
                })
        }
        return {
            contacts,
            delete_contact
        }
    }
}
</script>
