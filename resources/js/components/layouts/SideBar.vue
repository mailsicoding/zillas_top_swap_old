<template>

    <nav class="sb-sidenav accordion sidebar--gradient" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="text-center mr-top-2" onmouseover="document.getElementById('profile-image').style.display = 'block'"
                 onmouseleave="document.getElementById('profile-image').style.display = 'none'">
                    <div id="profile-image">
        <span style="line-height: 87px;"><span title="Change Picture" style="font-size: x-large;" onclick="document.getElementById('choose-image').click()">
                                                        <ion-icon class="create" name="camera-outline"></ion-icon>
                                                    </span></span>
                                                    <input type="file" @change="changePhoto" style="display:none" accept="image/*" id="choose-image">
    </div>
                    <img class="dashboard-icon-border" :src="user.image" alt="" style="width:87px;height:87px" />
                    <p class="heading-wrapper--one text-capitalize">{{user.username}}</p>
                    <!-- <p class="label__wrapper--one">Steven tailr</p> -->
                </div>


                <router-link v-if="can('Dashboard') == true" class="nav-link" to="/dashboard">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-tachometer-alt" aria-hidden="true"></i>
                    </div>
                    Dashboard
                </router-link>
                <router-link v-if="can('Users') == true" class="nav-link" to="/users">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    Users
                </router-link>
                <router-link v-if="can('Users') == true" class="nav-link" to="/admin_tranfer_credit">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    Transfer Credits
                </router-link>
                <router-link v-if="can('Roles') == true" class="nav-link" to="/roles">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    Roles
                </router-link>
                <router-link v-if="can('Getting Match') == true" class="nav-link" to="/match-request">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </div>
                    Getting Match
                </router-link>


                <!-- <router-link  v-if="can('Dashboard') == true" class="nav-link"  to="/trade-setting"><div  class="sb-nav-link-icon ">
                      <i class="fa fa-tachometer-alt" aria-hidden="true"></i>
                    </div>
                    Trade Setting
                  </router-link> -->

                <router-link v-if="can('Account Setting') == true" class="nav-link" to="/account-setting">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-tachometer-alt" aria-hidden="true"></i>
                    </div>
                    Account Setting
                </router-link>

                <!-- <router-link v-if="can('Funds') == true" class="nav-link" to="/funds">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-tachometer-alt" aria-hidden="true"></i>
                    </div>
                    Funds
                </router-link> -->

                <router-link v-if="can('Users')" class="nav-link" to="/contacts">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-tachometer-alt" aria-hidden="true"></i>
                    </div>
                    Contact Us
                </router-link>
                <router-link v-if="can('Getting Match')" class="nav-link" to="/add_contact_us">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-tachometer-alt" aria-hidden="true"></i>
                    </div>
                    Contact Us
                </router-link>
                <!-- <router-link class="nav-link" to="/admin_user_chat">
                    <div class="sb-nav-link-icon ">
                        <i class="fas fa-comment" aria-hidden="true"></i>
                    </div>
                    <span v-if="user.role == 'Admin'">Chat with Users</span>
                    <span v-else>Chat with Admin</span>
                </router-link> -->


            </div>
        </div>
    </nav>

</template>
<script>
import { onMounted, ref, reactive } from 'vue'
import store from '../../stores'
export default {
    name: 'SideBar',
    setup() {
        const result = ref(false)
        const permissions = ref([])
        const user = ref({})

        onMounted(() => {
            user.value = store.getters["auth/currentUser"];
            getPermissions();
        })

        const can = (permissionName) => {
            var perms = permissions.value;
            for (let index = 0; index < perms.length; index++) {
                const element = perms[index];
                if (element == permissionName)
                    return true;
            }
            return false;
        }

        const getPermissions = async (permissionName) => {
            await axios.get('user/permissions')
                .then((response) => {
                    permissions.value = response.data;
                })
        }

        const changePhoto = async (e) => {

            let file = e.target.files[0];
            let data = new FormData();
            data.append('profile_image', file, file.name);
            await axios.post('api/user/change-photo',data,{
    headers: {
      'Content-Type': 'multipart/form-data'
    }})
                .then((response) => {
                    if(response.data.success == true)
                    {
                        Toast.fire({
                                text: response.data.message,
                                timer: 5000,
                                icon: 'success',
                                position: 'top-end',
                            });
                        localStorage.removeItem("currentUser");
                        const strUser = JSON.stringify(response.data.user);
                        localStorage.setItem("currentUser",strUser);
                        store.commit("auth/setCurrentUser",response.data.user);
                        user.value = response.data.user
                        setTimeout(()=>{
                            window.location.href = '/dashboard'
                        },3000)
                    }
                    else{
                        Toast.fire({
                                text: response.data.message,
                                timer: 5000,
                                icon: 'error',
                                position: 'top-end',
                            });
                    }
                })
        }

        return {
            can,
            user,
            changePhoto
        }
    }
}
</script>
<style scoped>
#profile-image{
    position: absolute;
    display: flex;
    justify-content: center;
    left: 0;
    right: 0;
    display:none;
    width: 87px;
    height: 87px;
    margin: auto;
    background: rgb(114 119 122 / 52%);
    border-radius: 50%;
}
</style>
