<template>
    <!-- <div> -->
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <router-link class="navbar-brand" :to="{name: 'Home'}">Home </router-link>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link class="text-white ml-2" :to="{name: 'Dashboard'}" v-if="$store.getters.getToken != 0">Dashboard</router-link>
                </li>
            </ul>
            <v-spacer></v-spacer>
            <v-btn variant="text" color="white" @click="irLogin()" v-if="$store.getters.getToken == 0">
                Usuarios
            </v-btn>
        </nav>

        <router-view></router-view>

        <footer>
            <div class="navbar navbar-expand-sm bg-dark navbar-dark">

            </div>
        </footer>
    <!-- </div> -->
</template>

<script>
    import { defineComponent } from "vue"

    export default defineComponent({
        name: 'app',
        data() {
            return {

            }
        },
        methods: {
            irLogin() {
                this.$router.push('/login')
            }
        }
    })
</script>