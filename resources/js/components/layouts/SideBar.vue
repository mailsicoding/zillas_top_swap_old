<template>

    <nav class="sb-sidenav accordion sidebar--gradient" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="text-center mr-top-2">
                    <img class="dashboard-icon-border" :src="'assets/images/dashboard-profile.png'" alt="" />
                    <p class="heading-wrapper--one">Scarlett Johansson</p>
                    <p class="label__wrapper--one">Steven tailr</p>
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

                <router-link v-if="can('Funds') == true" class="nav-link" to="/add-funds">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-tachometer-alt" aria-hidden="true"></i>
                    </div>
                    Add Funds
                </router-link>

                <router-link class="nav-link" to="/contacts">
                    <div class="sb-nav-link-icon ">
                        <i class="fa fa-tachometer-alt" aria-hidden="true"></i>
                    </div>
                    Contact Us
                </router-link>


            </div>
        </div>
    </nav>

</template>
<script>
import { onMounted, ref } from 'vue'
export default {
    name: 'SideBar',
    setup() {
        const result = ref(false)
        const permissions = ref([])

        onMounted(() => {
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
            axios.get('user/permissions')
                .then((response) => {
                    permissions.value = response.data.permissions;
                })
        }

        return {
            can,
        }
    }
}
</script>
