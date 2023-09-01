<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Reporte de Gráficas</h2>
        </div>

        <div class="my-6 px-4 py-4">
            <v-form class="col-12" ref="formGraficas">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-12">
                        <div class="row justify-content-between">
                            <div class="col-md-6 col-12">
                                <v-text-field
                                    v-model="data.fecha_inicio"
                                    variant="solo"
                                    type="date"
                                    label="Fecha Inicio"
                                    :rules="fechaInicioRules"
                                ></v-text-field>
                            </div>
                            <div class="col-md-6 col-12">
                                <v-text-field
                                    v-model="data.fecha_fin"
                                    variant="solo"
                                    type="date"
                                    label="Fecha Fin"
                                    :rules="fechaFinRules"
                                ></v-text-field>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <v-select
                            v-model="data.centro_atencion_id"
                            :items="centrosAtencion"
                            item-title="nombre"
                            item-value="id"
                            label="Seleccione el centro de atención"
                            variant="solo"
                            :rules="centroAtencionRules"
                            >
                        </v-select>
                    </div>
                </div>
                <div class="row justify-content-between mt-2">
                    <div class="col-md-6 col-12">
                        <v-select
                            v-model="data.tramite_id"
                            :items="tramites"
                            item-title="nombre"
                            item-value="id"
                            label="Trámite"
                            variant="solo"
                            >
                        </v-select>
                    </div>
                    <div class="text-center mt-4 col-md-6 col-12">
                        <v-btn
                            variant="flat"
                            color="#6a73a0"
                            class="boton-nuevo"
                            @click="generarGrafica()"
                            >
                            Generar Gráfica
                        </v-btn>
                    </div>

                </div>
            </v-form>

            <div class="row justify-content-between mt-6" v-if="showGraph">
                <div class="col-md-6 col-12" style="height: 300px; width: 300px;">
                    <Pie :data="chartData" :options="chartOptions" style="margin-left: auto; margin-right: auto;"/>
                </div>
                <div class="col-md-6 col-12">
                    <div>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <p class="cuadro-texto cuadro-reservadas">Reservadas</p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p>{{reservadas}}</p>
                            </div>
                        </div>
                        <v-divider></v-divider>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <p class="cuadro-texto cuadro-atendidas">Atendidas</p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p>{{atendidas}}</p>
                            </div>
                        </div>
                        <v-divider></v-divider>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <p class="cuadro-texto cuadro-canceladas">Canceladas</p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p>{{canceladas}}</p>
                            </div>
                        </div>
                        <v-divider></v-divider>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <p class="cuadro-texto cuadro-total">Total</p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p>{{total}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
    import { Pie } from 'vue-chartjs'
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"

    ChartJS.register(ArcElement, Tooltip, Legend)

    export default defineComponent({
        name: 'reporte-graf',
        data() {
            return {
                centros: [],
                tramites: [],
                data: {
                    fecha_inicio: '',
                    fecha_fin: '',
                    centro_atencion_id: '',
                    tramite_id: '',
                },
                fechaInicioRules: [
                    v => !!v || 'El campo fecha inicio es requerido'
                ],
                fechaFinRules: [
                    v => !!v || 'El campo fecha fin es requerido'
                ],
                centroAtencionRules: [
                    v => !!v || 'El campo de centro de atención es requerido'
                ],
                porcent_1: 10,
                porcent_2: 40,
                porcent_3: 60,
                reservadas: 0,
                atendidas: 0,
                canceladas: 0,
                total: 0,
                chartOptions: {
                    responsive: true
                },
                showGraph: false,
                centro_default: {
                    id: 9999,
                    nombre: 'TODOS',
                    direccion: '',
                    telefono: '',
                    numero_cajas: ''
                },
                tramite_default: {
                    id: 9999,
                    nombre: 'TODOS',
                },
            }
        },
        components: {
            Pie
        },
        created() {
            this.getCentrosAtencion()
            this.getCatalogoTramites()
        },
        computed: {
            centrosAtencion() {
                return this.$store.getters.getCatalogoCentrosAtencion
            },
            tramites(){
                return this.$store.getters.getCatalogoTramites
            },
            chartData() {
                return {
                    datasets: [
                        {
                            backgroundColor: ['#6a73a0', '#A3BC39', '#E78900'],
                            data: [this.porcent_1, this.porcent_2, this.porcent_3]
                        }
                    ]
                }
            }
        },
        methods: {
            async getCentrosAtencion() {
                this.loading = true
                try {
                    let response = await axios.get('/api/catalogos/centros-de-atencion')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.centros = response.data.centros_atencion
                            this.centros.unshift(this.centro_default)
                            this.$store.commit('setCatalogoCentrosAtencion', this.centros)
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catalogo de centros de atención')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catalogo de centros de atención')
                }
                this.loading = false
            },
            async getCatalogoTramites() {
                console.log("jhduidbhdiubduidbdu")
                this.loading = true
                try {
                    let response = await axios.get('/api/catalogos/tramites')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.tramites = response.data.tramites
                            this.tramites.unshift(this.tramite_default)
                            this.$store.commit('setCatalogoTramites', this.tramites)
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catálogo de trámites')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catálogo de trámites')
                }
                this.loading = false
            },
            async generarGrafica() {
                const { valid } = await this.$refs.formGraficas.validate()
                if (valid) {
                    try {
                        let response = await axios.post('/api/reporte/grafica', this.data)
                        if (response.status === 200) {
                            if (response.data.status === "ok") {
                                this.reservadas = response.data.reporte.reservadas
                                this.atendidas = response.data.reporte.atendidas
                                this.canceladas = response.data.reporte.canceladas
                                this.total = response.data.reporte.total
                                this.porcent_1 = response.data.reporte.porcent_1
                                this.porcent_2 = response.data.reporte.porcent_2
                                this.porcent_3 = response.data.reporte.porcent_3
                                this.showGraph = true
                            } else {
                                errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al obtener las estadísticas')
                        }
                    } catch (error) {
                        errorSweetAlert('Ocurrió un error al obtener las estadísticas')
                    }
                }
            }
        }
    })
</script>

<style scoped>
    .cuadro-texto {
        color: white;
        text-align: center;
        border: 1px solid #828282;
    }

    .cuadro-reservadas {
        background-color: #6a73a0
    }

    .cuadro-atendidas {
        background-color: #A3BC39
    }

    .cuadro-canceladas {
        background-color: #E78900
    }

    .cuadro-total {
        background-color: #828282;
    }
</style>