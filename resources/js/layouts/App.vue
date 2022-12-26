<template>
    <v-app>
        <!-- <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
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
            <v-btn variant="text" color="white" @click="logout()" v-if="$store.getters.getToken != 0">
                Cerrar Sesión
            </v-btn>
        </nav> -->

        <header class="background-header">
            <v-toolbar class="my-2 mx-2" color="#6a73a0">
                <v-spacer></v-spacer>
                <v-tabs class="" fixed-tabs v-if="$store.getters.getToken != 0">
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="white"
                                variant="plain"
                                rounded="0"
                                class="align-self-center mr-4"
                                height="100%"
                                v-bind="props"
                            >
                                Horarios
                                <v-icon end>
                                    mdi-menu-down
                                </v-icon>
                            </v-btn>
                        </template>

                        <v-list class="bg-grey-lighten-3">
                            <v-list-item @click="this.$router.push('/home')">
                                Cargar Horario
                            </v-list-item>
                            <v-list-item @click="this.$router.push('/dashboard')">
                                Modificar Horario
                            </v-list-item>
                        </v-list>
                    </v-menu>

                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="white"
                                variant="plain"
                                rounded="0"
                                class="align-self-center mr-4"
                                height="100%"
                                v-bind="props"
                            >
                                Catalogos
                                <v-icon end>
                                    mdi-menu-down
                                </v-icon>
                            </v-btn>
                        </template>

                        <v-list class="bg-grey-lighten-3">
                            <v-list-item @click="this.$router.push('/centros-atencion')">
                                Centro de Atención
                            </v-list-item>
                            <v-list-item @click="this.$router.push('/catalogo-requisitos')">
                                Requisito
                            </v-list-item>
                            <v-list-item @click="this.$router.push('/catalogo-tramites')">
                                Tramite
                            </v-list-item>
                            <v-list-item @click="this.$router.push('/dashboard')">
                                Notas
                            </v-list-item>
                            <v-list-item @click="this.$router.push('/conf-whats')">
                                Configuración WhatsApp
                            </v-list-item>
                        </v-list>
                    </v-menu>

                    <v-tab color="white">
                        Usuario
                    </v-tab>

                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="white"
                                variant="plain"
                                rounded="0"
                                class="align-self-center mr-4"
                                height="100%"
                                v-bind="props"
                            >
                                Reportes
                                <v-icon end>
                                    mdi-menu-down
                                </v-icon>
                            </v-btn>
                        </template>

                        <v-list class="bg-grey-lighten-3">
                            <v-list-item @click="this.$router.push('/home')">
                                Gráficas
                            </v-list-item>
                            <v-list-item @click="this.$router.push('/dashboard')">
                                Reporte de Citas
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-tabs>
                <v-spacer></v-spacer>
                <v-btn variant="text" color="white" @click="this.$router.push('/catalogo-usuarios')">
                    Usuarios
                </v-btn>
                <v-btn variant="text" color="white" @click="logout()" v-if="$store.getters.getToken != 0">
                    Cerrar Sesión
                </v-btn>
            </v-toolbar>
        </header>

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
            },
            logout() {
                this.$store.dispatch('removeToken')
                this.$router.push({name: 'Home'})
            },
            algo() {

            },
            irCatalogoUSuarios() {
                this.$router.push('/catalogo-usuarios')
            }
        }
    })
</script>

<style scoped>
    .background-header {
        background-color: #6a73a0;
    }

    .background-footer {
        background-color: #353535;
        color: white;
    }
</style>