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
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Message</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(contact, index) in contacts" :key="index">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ contact.name }}</td>
                                                <td>{{ contact.email }}</td>
                                                <td>{{ contact.message }}</td>
                                                <td>
                                                    <!-- <router-link :to="'/edit_contact/' + contact.id">
                                                        <ion-icon class="pencil" name="pencil-outline"></ion-icon>
                                                    </router-link> -->
                                                    <!-- <a href="" class="view">
                                                        <ion-icon name="eye-outline"></ion-icon>
                                                    </a> -->
                                                    <a href="#" @click="delete_contact(contact.id)">
                                                        <ion-icon class="delete" name="trash-outline"></ion-icon>
                                                    </a>
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
import axios from 'axios'
import {
    onMounted,
    ref,
    reactive,
    onUnmounted,
} from 'vue'
import {
    useRoute, useRouter
} from 'vue-router'

export default {
    name: 'contacts',
    setup() {
        const contacts = ref([])
        const router = useRouter()
        const route = useRoute()


        onMounted(() => {
            getContacts()
        })
        // onUnmounted(() => {
        //     // getContacts()
        // })
        const getContacts = async () => {
            axios.get('/api/contact')
                .then((response) => {
                    contacts.value = response.data.contact;
                })
        }

        const delete_contact = async (id) => {
            axios.delete('/api/contact/'+ id)
                .then((response) => {
                    getContacts()
                    Toast.fire({
                        text: response.data.message,
                        timer: 3000,
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
