<template>
    <div>
        <div class="row justify-content-between">
            <div class="col-sm-9 col-12 border-uno">
                <div class="text-center border-dos py-2">
                    <img class="scale-logo-defensoria" width="200" height="75" src="../../../public/images/logo_defensoria_publica.svg" alt="">
                </div>
                <div v-if="showFirstOptions">
                    <div class="row justify-content-around mt-12">
                        <div class="col-sm-12 col-md-6 text-center">
                            <div class="transition-button mt-4 ml-8 mr-4 text-center" @click="mostrarTipoCitas(1)">
                                <img src="./../../../public/images/boton_1.png" alt="">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 text-center">
                            <div class="transition-button mt-4 ml-8 mr-4" @click="mostrarTipoCitas(2)">
                                <img src="./../../../public/images/boton_2.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-around mb-12">
                        <div class="col-sm-12 col-md-6 text-center">
                            <div class="transition-button mt-4 ml-8 mr-4" @click="mostrarTipoCitas(3)">
                                <img src="./../../../public/images/boton_3.png" alt="">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 text-center">
                            <div class="transition-button mt-4 ml-8 mr-4" @click="mostrarTipoCitas(4)">
                                <img src="./../../../public/images/boton_4.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4 mb-4 ml-10 mr-10" v-if="showSecondOptions">
                    <div class="container">
                        <div class="row justify-content-around">
                            <div class="col-sm-12 col-md-6 text-left">
                                <p class="titulo_tipo_tramite">{{tipo_asunto}}</p>
                            </div>
                            <div class="col-sm-12 col-md-6 text-right">
                                <v-btn variant="text" prepend-icon="mdi-arrow-left" @click="volverFirstOptions">Regresar</v-btn>
                            </div>
                        </div>
                        <div class="mt-4">
                            <v-expansion-panels>
                                <template v-for="(tipo_cita, index) in tipos_citas" :key="index">
                                    <v-expansion-panel>
                                        <v-expansion-panel-title>
                                            <v-row no-gutters>
                                                <h6 class="font-weight-bold text-uppercase">
                                                    <span class="text-red-custom">{{tipo_cita.nombre}}</span>
                                                </h6>
                                            </v-row>
                                        </v-expansion-panel-title>
                                        <v-expansion-panel-text>
                                            <v-row no-gutters class="text-left">
                                                {{tipo_cita.descripcion}}
                                            </v-row>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    variant="flat"
                                                    color="error"
                                                    @click="agendar(tipo_cita)"
                                                >
                                                    Agendar
                                                </v-btn>
                                            </v-card-actions>
                                        </v-expansion-panel-text>
                                    </v-expansion-panel>
                                </template>
                            </v-expansion-panels>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from "vue"

    export default defineComponent({
        name: 'home',
        data() {
            return {
                showFirstOptions: true,
                showSecondOptions: false,
                datos: {
                    clave: ''
                },
                tipos_citas: [],
                tipo_asunto: '',
            }
        },
        created() {
            if (this.asunto_store) {
                this.mostrarTipoCitas(this.asunto_store)
            }
        },
        computed: {
            tramites_tipo_1() {
                return this.$store.getters.getCatalogoTramitesTipo1
            },
            tramites_tipo_2() {
                return this.$store.getters.getCatalogoTramitesTipo2
            },
            tramites_tipo_3() {
                return this.$store.getters.getCatalogoTramitesTipo3
            },
            tramites_tipo_4() {
                return this.$store.getters.getCatalogoTramitesTipo4
            },
            asunto_store() {
                return this.$store.getters.getAsuntoStore
            }
        },
        methods: {
            mostrarTipoCitas(asunto) {
                switch (asunto) {
                    case 1:
                        this.tipo_asunto = 'Asuntos Civiles y Familiares'
                        this.tipos_citas = this.tramites_tipo_1
                        this.$store.commit('setAsuntoStore', 1)
                        break
                    case 2:
                        this.tipo_asunto = 'Asuntos Laborales'
                        this.tipos_citas = this.tramites_tipo_2
                        this.$store.commit('setAsuntoStore', 2)
                        break
                    case 3:
                        this.tipo_asunto = 'Asuntos Administrativos'
                        this.tipos_citas = this.tramites_tipo_3
                        this.$store.commit('setAsuntoStore', 3)
                        break
                    case 4:
                        this.tipo_asunto = 'Ejecución de Sentencias'
                        this.tipos_citas = this.tramites_tipo_4
                        this.$store.commit('setAsuntoStore', 4)
                        break
                }
                this.showFirstOptions = false
                this.showSecondOptions = true
            },
            volverFirstOptions() {
                this.showSecondOptions = false
                this.showFirstOptions = true
            },
            agendar(tipo_cita) {
                this.$store.commit('setTramiteSeleccionado', tipo_cita)
                this.$router.push('/crear-cita')
            },
        }
    })
</script>

<style scoped>
    .text-red-custom {
        color: #691C32;
    }

    .border-uno {
        border-style: none solid none none;
        border-color: #adadad;
        border-width: 2px;
        padding: 0!important;
    }

    .border-dos {
        border-style: none none solid none;
        border-color: #adadad;
        border-width: 2px;
    }

    .scale-logo-defensoria {
        transform: scale(1.8);
    }

    .transition-button {
        background-color: #e7e7e7;
        border-radius: 35px;
        cursor: pointer;
        transition: all 0.5s ease-out;
    }
    
    .transition-button:hover, .transition-button:focus {
        background-color: #adadad;
        color: #fff;
    }

    .boton_sicopep {
        transition: all .2s ease-in-out;
    }

    .boton_sicopep:hover {
        transform: scale(1.1);
    }

    .titulo_tipo_tramite {
        font-size: 20px;
        font-weight: bold;
        font-family: 'Lato', sans-serif;
    }
</style>