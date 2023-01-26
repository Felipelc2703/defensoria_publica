<template>
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-9 col-12 border-one">
                <div class="text-center border-dos py-2">
                    <img class="scale-logo-defensoria logo-defensoria" height="75" src="../../../public/images/logo_defensoria_publica.svg" alt="">
                </div>
                <div v-if="showFirstOptions">
                    <div class="row justify-content-around mt-10">
                        <div class="col-sm-10 col-md-6 text-center">
                            <div class="defensoria-button mt-4 ml-8 mr-4 text-center " @click="mostrarTipoCitas(1)">
                                <img class="p-3" src="./../../../public/images/boton_1.png" alt="">
                            </div>
                        </div>
                        <div class="col-sm-10 col-md-6 text-center">
                            <div class="defensoria-button mt-4 ml-8 mr-4" @click="mostrarTipoCitas(3)">
                                <img class="p-3" src="./../../../public/images/boton_2.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-around mb-12">
                        <div class="col-sm-10 col-md-6 text-center">
                            <div class="defensoria-button mt-4 ml-8 mr-4" @click="mostrarTipoCitas(2)">
                                <img class="p-3" src="./../../../public/images/boton_3.png" alt="">
                            </div>
                        </div>
                        <div class="col-sm-10 col-md-6 text-center">
                            <div class="defensoria-button mt-4 ml-8 mr-4" @click="mostrarTipoCitas(4)">
                                <img class="p-3" src="./../../../public/images/boton_4.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4 mb-4 ml-10 mr-10" v-if="showSecondOptions">
                    <div class="container">
                        <div class="row justify-content-around">
                            <div class="col-6 text-left">
                                <p class="titulo_tipo_tramite">{{tipo_asunto}}</p>
                            </div>
                            <div class="col-6 text-right">
                                <v-btn class="boton-regresar" variant="text" prepend-icon="mdi-arrow-left" @click="volverFirstOptions">Regresar</v-btn>
                            </div>
                        </div>
                        <div class="mt-4">
                            <v-expansion-panels>
                                <template v-for="(tipo_cita, index) in tipos_citas" :key="index">
                                    <v-expansion-panel>
                                        <v-expansion-panel-title color="#8c92bc">
                                            <v-row no-gutters>
                                                <h6 class="font-weight-bold text-uppercase text-left">
                                                    <span class="procedure-text-title">{{tipo_cita.nombre}}</span>
                                                </h6>
                                            </v-row>
                                        </v-expansion-panel-title>
                                        <v-expansion-panel-text>
                                            <v-row no-gutters class="text-left">
                                                <span class="texto-cita">
                                                    {{tipo_cita.descripcion}}
                                                </span>
                                            </v-row>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <button class="boton-agendar" @click="agendar(tipo_cita)">Agendar</button>
                                                <!-- <v-btn
                                                    rounded
                                                    variant="flat"
                                                    color="#a4bc4b"
                                                    class=""
                                                    @click="agendar(tipo_cita)"
                                                >
                                                    Agendar
                                                </v-btn> -->
                                            </v-card-actions>
                                        </v-expansion-panel-text>
                                    </v-expansion-panel>
                                </template>
                            </v-expansion-panels>
                        </div>
                    </div>
                </div>
                <a v-if="whatsapp.id != null" :href="`https://api.whatsapp.com/send?phone=52${whatsapp.telefono}`" class="whatsapp" target="_blank"> <i class="fa fa-whatsapp whatsapp-icon"></i></a>
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
                whatsapp: {
                    id: null,
                    telefono: '',
                    hora_inicio: '',
                    hora_fin: '',
                    dia1: false,
                    dia2: false,
                    dia3: false,
                    dia4: false,
                    dia5: false,
                    dia6: false,
                    dia7: false,
                },
            }
        },
        created() {
            if (this.asunto_store) {
                this.mostrarTipoCitas(this.asunto_store)
            }
            this.getWhatsApp()
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
            async getWhatsApp() {
                try {
                    let response = await axios.get('/api/whatsapp/get-numero')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.whatsapp.id = response.data.registro.id
                            this.whatsapp.telefono = response.data.registro.telefono
                            this.whatsapp.hora_inicio = response.data.registro.hora_inicio
                            this.whatsapp.hora_fin = response.data.registro.hora_fin
                            this.whatsapp.dia1 = response.data.registro.dia1
                            this.whatsapp.dia2 = response.data.registro.dia2
                            this.whatsapp.dia3 = response.data.registro.dia3
                            this.whatsapp.dia4 = response.data.registro.dia4
                            this.whatsapp.dia5 = response.data.registro.dia5
                            this.whatsapp.dia6 = response.data.registro.dia6
                            this.whatsapp.dia7 = response.data.registro.dia7
                        } else if (response.data.status === "no-data") {
                            
                        } else {
                            // errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        // errorSweetAlert('Ocurrió un error al obtener el catalogo de tramites para agendar citas.')
                    }
                } catch (error) {
                    // errorSweetAlert('Ocurrió un error al obtener el catalogo de tramites para agendar citas.')
                }
            },
            mostrarTipoCitas(asunto) {
                switch (asunto) {
                    case 1:
                        this.tipo_asunto = 'Asuntos Civiles y Familiares'
                        this.tipos_citas = this.tramites_tipo_1
                        this.$store.commit('setAsuntoStore', 1)
                        break
                    case 2:
                        this.tipo_asunto = 'Asuntos Administrativos'
                        this.tipos_citas = this.tramites_tipo_2
                        this.$store.commit('setAsuntoStore', 2)
                        break
                    case 3:
                        this.tipo_asunto = 'Asuntos Laborales'
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
                
                // TODO: Pendiente cambiar color de icono
                // let icon_panels = document.getElementsByClassName('v-expansion-panel-title__icon').length
                // console.log("icon: ", icon_panels)
                // console.log("lengt: ", icon_panels.length)
                // for (let index = 0; index < icon_panels.length; index++) {
                //     console.log("cambiando estilo")
                //     icon_panels[index].style.color = 'white'
                // }
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