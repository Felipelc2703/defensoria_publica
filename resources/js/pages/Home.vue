<template>
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-9 col-12 border-one">
                <!-- <div class="text-center border-dos py-2">
                    <img class="scale-logo-defensoria logo-defensoria" height="75" src="../../../public/images/Logo_Instituto_de_la_Defensoria.svg" alt="">
                </div> -->
                <template v-if="bandMenuInicial">
                    <div class="row justify-content-around mt-10 mb-10">
                        <div class="col-sm-10 col-md-6 text-center">
                            <div class="defensoria-button mt-4 ml-8 mr-4 text-center " @click="mostrarMenuDefensoria()">
                                <img class="p-3" src="./../../../public/images/defensoria-publica.png" alt="">
                            </div>
                        </div>
                        <div class="col-sm-10 col-md-6 text-center">
                            <div class="defensoria-button mt-4 ml-8 mr-4" @click="mostrarMenuJuzgados()">
                                <img class="p-3" src="./../../../public/images/jueces.png" alt="">
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="text-center mt-4 ml-10 mr-10">
                        <div class="container">
                            <div class="row justify-content-around">
                                <div class="col-6 text-left">
                                    <p class="titulo_tipo_tramite">{{menu_seleccionado}}</p>
                                </div>
                                <div class="col-6 text-right">
                                    <v-btn class="boton-regresar" variant="text" prepend-icon="mdi-arrow-left" @click="volver()">Regresar</v-btn>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template v-if="bandMenuDefensoria">
                        <div v-if="bandVerOpcionesDefensoria">
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
                        <div class="text-center mt-4 mb-4 ml-10 mr-10" v-if="bandVerAsuntos">
                            <div class="container">
                                <div class="row justify-content-around">
                                    <div class="col-6 text-left">
                                        <p class="titulo_tipo_tramite">{{tipo_asunto}}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <!-- <v-btn class="boton-regresar" variant="text" prepend-icon="mdi-arrow-left" @click="volverFirstOptions()">Regresar</v-btn> -->
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
                                                    </v-card-actions>
                                                </v-expansion-panel-text>
                                            </v-expansion-panel>
                                        </template>
                                    </v-expansion-panels>
                                </div>
                            </div>
                        </div>
                        <a v-if="whatsapp.id != null" :href="`https://api.whatsapp.com/send?phone=52${whatsapp.telefono}`" class="whatsapp" target="_blank"> <i class="fa fa-whatsapp whatsapp-icon"></i></a>
                    </template>
                    <template v-else-if="bandMenuJuzgados">
                        <div v-if="bandVerOpcionesJuzgados">
                            <div class="row justify-content-around mt-10">
                                <div class="col-sm-10 col-md-6 text-center">
                                    <div class="defensoria-button mt-4 ml-8 mr-4 text-center " @click="mostrarJuzgados(1)">
                                        <img class="p-3" src="./../../../public/images/materia-civil.png" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-10 col-md-6 text-center">
                                    <div class="defensoria-button mt-4 ml-8 mr-4" @click="mostrarJuzgados(2)">
                                        <img class="p-3" src="./../../../public/images/materia-familiar.png" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-around mb-12">
                                <div class="col-sm-10 col-md-6 text-center">
                                    <div class="defensoria-button mt-4 ml-8 mr-4" @click="mostrarJuzgados(3)">
                                        <img class="p-3" src="./../../../public/images/materia-mercantil.png" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-10 col-md-6 text-center">
                                    <div class="defensoria-button mt-4 ml-8 mr-4" @click="mostrarJuzgados(4)">
                                        <img class="p-3" src="./../../../public/images/materia-oralidad-familiar.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4 mb-4 ml-10 mr-10" v-if="bandVerJuzgados">
                            <div class="container">
                                <div class="row justify-content-around">
                                    <div class="col-6 text-left">
                                        <p class="titulo_tipo_tramite">{{materia}}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <!-- <v-btn class="boton-regresar" variant="text" prepend-icon="mdi-arrow-left" @click="volverFirstOptions()">Regresar</v-btn> -->
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <v-expansion-panels>
                                        <template v-for="(juzgado, index) in juzgados_citas" :key="index">
                                            <v-expansion-panel>
                                                <v-expansion-panel-title color="#8c92bc">
                                                    <v-row no-gutters>
                                                        <h6 class="font-weight-bold text-uppercase text-left">
                                                            <span class="procedure-text-title">{{juzgado.nombre}}</span>
                                                        </h6>
                                                    </v-row>
                                                </v-expansion-panel-title>
                                                <v-expansion-panel-text>
                                                    <v-row no-gutters class="text-left">
                                                        <template v-if="juzgado.jueces.length > 1">
                                                            <span class="texto-cita col-12">Jueces:</span>
                                                            <div class="col-1"></div>
                                                            <ul>
                                                                <li class="texto-cita" v-for="(item, index) in juzgado.jueces" :key="index">{{item.nombre_completo}}</li>
                                                            </ul>
                                                        </template>
                                                        <template v-else>
                                                            <span class="texto-cita">Juez: {{juzgado.jueces[0].nombre_completo}}</span>
                                                        </template>
                                                    </v-row>
                                                    <v-card-actions>
                                                        <v-spacer></v-spacer>
                                                        <button class="boton-agendar" @click="agendarJuzgado(juzgado)">Agendar</button>
                                                    </v-card-actions>
                                                </v-expansion-panel-text>
                                            </v-expansion-panel>
                                        </template>
                                    </v-expansion-panels>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
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
                bandMenuInicial: true,
                bandMenuDefensoria: false,
                bandMenuJuzgados: false,
                menu_seleccionado: '',

                bandVerOpcionesDefensoria: false,
                bandVerAsuntos: false,
                bandVerOpcionesJuzgados: false,
                bandVerJuzgados: false,

                tipos_citas: [],
                tipo_asunto: '',

                materia: '',
                juzgados_citas: [],

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
            },
            juzgados() {
                return this.$store.getters.getCatalogoJuzgados
            }
        },
        methods: {
            mostrarMenuDefensoria() {
                this.bandMenuDefensoria = true
                this.bandMenuInicial = false,
                this.bandMenuJuzgados = false
                this.menu_seleccionado = 'Defensoría Pública'
                this.bandVerOpcionesDefensoria = true
                this.bandVerOpcionesJuzgados = false
            },
            mostrarMenuJuzgados() {
                this.bandMenuJuzgados = true
                this.bandMenuInicial = false
                this.bandMenuDefensoria = false
                this.menu_seleccionado = 'Juzgados'
                this.bandVerOpcionesJuzgados = true
                this.bandVerOpcionesDefensoria = false
            },
            volver() {
                if (this.bandVerAsuntos) {
                    this.bandVerAsuntos = false
                    this.bandVerOpcionesDefensoria = true
                } else if (this.bandVerJuzgados) {
                    this.bandVerJuzgados = false
                    this.bandVerOpcionesJuzgados = true
                } else if (this.bandMenuDefensoria || this.bandMenuJuzgados) {
                    this.bandMenuDefensoria = false
                    this.bandMenuJuzgados = false
                    this.bandMenuInicial = true
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
                this.bandVerOpcionesDefensoria = false
                this.bandVerAsuntos = true
            },
            agendar(tipo_cita) {
                this.$store.commit('setTramiteSeleccionado', tipo_cita)
                this.$router.push('/crear-cita')
            },
            mostrarJuzgados(materia) {
                this.juzgados_citas = []
                switch (materia) {
                    case 1:
                        this.materia = 'Materia Civil'
                        this.juzgados.forEach(e => {
                            if (e.materia_id == 1) {
                                this.juzgados_citas.push(e)
                            }
                        })
                        break;
                    case 2:
                        this.materia = 'Materia Familiar'
                        this.juzgados.forEach(e => {
                            if (e.materia_id == 2) {
                                this.juzgados_citas.push(e)
                            }
                        })
                        break;
                    case 3:
                        this.materia = 'Materia Mercantil'
                        this.juzgados.forEach(e => {
                            if (e.materia_id == 3) {
                                this.juzgados_citas.push(e)
                            }
                        })
                        break;
                    case 4:
                        this.materia = 'Materia Oralidad Familiar'
                        this.juzgados.forEach(e => {
                            if (e.materia_id == 4) {
                                this.juzgados_citas.push(e)
                            }
                        })
                        break;
                }
                this.bandVerOpcionesJuzgados = false
                this.bandVerJuzgados = true
            },
            agendarJuzgado(juzgado) {
                this.$store.commit('setJuzgadoSeleccionado', juzgado)
                this.$router.push('/crear-cita-juzgado')
            },
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
        }
    })
</script>