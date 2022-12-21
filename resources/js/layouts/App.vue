<template>
    <v-app>
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

        <!-- <footer>
            <div class="navbar navbar-expand-sm bg-dark navbar-dark">

            </div>
        </footer> -->
        <v-footer
            class="background-footer text-center d-flex flex-column"
        >
            <div>
            <v-btn
                v-for="icon in icons"
                :key="icon"
                class="mx-4"
                :icon="icon"
                variant="text"
            ></v-btn>
            </div>

            <div class="pt-0">
            Phasellus feugiat arcu sapien, et iaculis ipsum elementum sit amet. Mauris cursus commodo interdum. Praesent ut risus eget metus luctus accumsan id ultrices nunc. Sed at orci sed massa consectetur dignissim a sit amet dui. Duis commodo vitae velit et faucibus. Morbi vehicula lacinia malesuada. Nulla placerat augue vel ipsum ultrices, cursus iaculis dui sollicitudin. Vestibulum eu ipsum vel diam elementum tempor vel ut orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </div>

            <v-divider></v-divider>

            <div>
            {{ new Date().getFullYear() }} — <strong>Defensoria Pública</strong>
            </div>
        </v-footer>
    </v-app>
</template>

<script>
    import { defineComponent } from "vue"

    export default defineComponent({
        name: 'app',
        data() {
            return {
                icons: [
                    'mdi-facebook',
                    'mdi-twitter',
                    'mdi-linkedin',
                    'mdi-instagram',
                ],
            }
        },
        methods: {
            irLogin() {
                this.$router.push('/login')
            }
        }
    })
</script>

<style scoped>
    .background-footer {
        background-color: #353535;
        color: white;
    }
</style>