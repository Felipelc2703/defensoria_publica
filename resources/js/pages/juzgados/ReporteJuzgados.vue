<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Reporte de Juzgados</h2>
        </div>

        <div class="my-6 px-4 py-4">
            <v-form class="col-12" ref="formGraficas">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-12" >
                        <v-select
                            v-model="data.mes"
                            :items="meses"
                            item-title="nombre"
                            item-value="id"
                            label="Seleccione el mes"
                            variant="solo"
                       
                            >
                        </v-select>
                    </div>
                
                    <div class="col-md-6 col-12">
                        <v-select
                            v-model="data.juzgado_id"
                            :items="juzgados"
                            item-title="nombre"
                            item-value="id"
                            label="Seleccione el juzgado"
                            variant="solo"
                            :rules="centroAtencionRules"
                            >
                        </v-select>
                    </div>
                </div>
                <div class="row justify-content-between mt-2">
                 
                    <div class="text-center mt-4 col-md-12 col-12">
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

            <div class="row justify-content-between mt-6 py-10" v-if="showGraph">
                <div class="col-md-6 col-12" style="height: 300px; width: 300px;">
                    <Pie :data="chartData" :options="chartOptions" style="margin-left: auto; margin-right: auto;"/>
                </div>
                <div class="col-md-6 col-12 ">
                    <div>
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <p class="cuadro-texto cuadro-reservadas">Pendientes</p>
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
                <div class="text-right mt-8 py-8">
                        <div class="buscador-data-table">
                            <input type="search" v-model="buscar" placeholder="Buscar..." autocomplete="off">
                        </div>
                </div>
                <div class="my-2 mb-12 col-md-12">
                        <div class="container-fluid">
                            <table class="table">
                                <thead class="headers-table">
                                    <tr>
                                        <th class="titulo-columna borde-izquierdo">#</th>
                                        <th class="titulo-columna">Juez</th>
                                        <th class="titulo-columna">Pendientes</th>
                                        <th class="titulo-columna">Atendidos</th>
                                        <th class="titulo-columna">Cancelados</th>
                                        <th class="titulo-columna">Total</th>
                                        <!-- <th class="titulo-columna borde-derecho">Estatus</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="loading">
                                        <th colspan="8">
                                            <p class="text-center texto-cargando-datos">Cargando datos...</p>
                                            <div class="linear-activity">
                                                <div class="indeterminate"></div>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr v-else v-for="cita in datosPaginados" :key="cita.id">
                                        <td class="texto-campo-table">
                                            {{cita.id}}
                                        </td>
                                        <td class="texto-campo-table text-center">
                                            {{cita.nombre}}
                                        </td>
                                        <td class="texto-campo-table text-center">
                                            {{cita.pen}}
                                        </td>
                                        <td class="texto-campo-table text-center">
                                            {{cita.aten}}
                                        </td>
                                        <td class="texto-campo-table text-center">
                                            {{cita.cance}}
                                        </td>
                                        <td class="texto-campo-table text-center">
                                            {{cita.tot}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <template v-if="this.tabla && this.tabla.length > 0">
                            <div class="row justify-content-between container">
                                <div>
                                    <p class="text-resultados mt-2">
                                        Mostrando
                                        <span>{{from}}</span>
                                        -
                                        <span>{{to}}</span>
                                        de
                                        <span>{{this.tabla.length}}</span>
                                        resultados
                                    </p>
                                </div>
                                <div>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item cursor-paginator" @click="getFirstPage()">
                                                <a class="page-link" aria-label="Previous">
                                                    <span aria-hidden="true">&lt;&lt;</span>
                                                    <span class="sr-only">First</span>
                                                </a>
                                            </li>
                                            <li class="page-item cursor-paginator" @click="getPreviousPage()">
                                                <a class="page-link" aria-label="Previous">
                                                    <span aria-hidden="true">&lt;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li v-for="pagina in pages" @click="getDataPagina(pagina), setCurrentPage(pagina)" :key="pagina" class="page-item cursor-paginator" :class="isActive(pagina)">
                                                <a class="page-link">
                                                    {{pagina}}
                                                </a>
                                            </li>
                                            <li class="page-item cursor-paginator" @click="getNextPage()">
                                                <a class="page-link" aria-label="Next">
                                                    <span aria-hidden="true">&gt;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                            <li class="page-item cursor-paginator" @click="getLastPage()">
                                                <a class="page-link" aria-label="Next">
                                                    <span aria-hidden="true">&gt;&gt;</span>
                                                    <span class="sr-only">Last</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </template>
                        <template v-else-if="!loading">
                            <div class="text-center">
                                <p class="texto-no-data">Aún no hay datos disponibles</p>
                            </div>
                        </template>
                 </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
    import { Pie } from 'vue-chartjs'
    import { errorSweetAlert, successSweetAlert } from "../../helpers/sweetAlertGlobals"

    ChartJS.register(ArcElement, Tooltip, Legend)

    export default defineComponent({
        name: 'reporte-juzgado',
        data() {
            return {
                // centros: [],
                // tramites: [],
                data: {
                    mes: '',
                    juzgado_id: '',
                   
                    // centro_atencion_id: '',
                    // tramite_id: '',
                },
                // tabla:{
                //         id: '',
                //         nombre: '',
                //         pen: '',
                //         aten: '',
                //         can: '',
                //         tot: ''
                //     },
                meses: [
                    {
                        id: '1',
                        nombre: 'Enero'
                    },
                    {
                        id: '2',
                        nombre: 'Febrero'
                    },
                    {
                        id: '3',
                        nombre: 'Marzo'
                    },
                    {
                        id: '4',
                        nombre: 'Abril'
                    },
                    {
                        id: '5',
                        nombre: 'Mayo'
                    },
                    {
                        id: '6',
                        nombre: 'Junio'
                    },
                    {
                        id: '7',
                        nombre: 'Julio'
                    },
                    {
                        id: '8',
                        nombre: 'Agosto'
                    },
                    {
                        id: '9',
                        nombre: 'Septiembre'
                    },
                    {
                        id: '10',
                        nombre: 'Octubre'
                    },
                    {
                        id: '11',
                        nombre: 'Noviembre'
                    },
                    {
                        id: '12',
                        nombre: 'Diciembre'
                    },
                ],
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
                juzgados:[],
                showGraph: false,
                juzgado_default: {
                    id: 9999,
                    nombre: 'TODOS',
                },
                elementosPorPagina: 10,
                paginaActual: 1,
                datosPaginados: [],
                mostrar: false,
                from: '',
                to: '',
                numShown: 5,
                current: 1,
                buscar: '',
                loading:  false
               
            }
        },
        components: {
            Pie
        },
        created() {
            this.getJuzgados()
        },
        computed: {
            juzgados() {
                return this.$store.getters.getCatalogoJuzgados
            },
            // citas() {
            //     return this.$store.getters.getCatalogoCitasDelDia
            // },
            chartData() {
                return {
                    datasets: [
                        {
                            backgroundColor: ['#6a73a0', '#A3BC39', '#E78900'],
                            data: [this.porcent_1, this.porcent_2, this.porcent_3]
                        }
                    ]
                }
            },
            pages() {
                const numShown = Math.min(this.numShown, this.totalPaginas())
                let first = this.current - Math.floor(numShown / 2)
                first = Math.max(first, 1)
                first = Math.min(first, this.totalPaginas() - numShown + 1)
                return [...Array(numShown)].map((k, i) => i + first)
            },
        },
        
        watch:{
            buscar: function () {
                if (!this.buscar.length == 0) {
                    this.datosPaginados = this.tabla.filter(item => {
                        return item.nombre.toLowerCase().includes(this.buscar)
                        // ||item.pen.toLowerCase().includes(this.buscar.toLowerCase())
                        // || item.aten.toLowerCase().includes(this.buscar.toLowerCase())
                        // || item.cance.toLowerCase().includes(this.buscar.toLowerCase())
                        // || item.tot.toLowerCase().includes(this.buscar.toLowerCase())
                       
                        // || item.fecha_recepcion.includes(this.buscar)
                    })
                } else {
                    this.getDataPagina(1)
                }
            },
            mostrar: function () {
                if (this.mostrar) {
                    this.getDataPagina(1)
                }
            }
        },
        methods: {
         
            async getJuzgados() {
                try {
                    let response = await axios.get('/api/juzgados-citas')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.juzgados = response.data.juzgados
                            this.juzgados.unshift(this.juzgado_default)
                            this.$store.commit('setCatalogoJuzgados', this.juzgados)
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catálogo de juzgados para agendar citas.')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catálogo de juzgados para agendar citas.')
                }
            },
            async generarGrafica() {
                // const { valid } = await this.$refs.formGraficas.validate()
                // if (valid) {
                    try {
                        this.loading = true
                        // console.log(this.data)
                        let response = await axios.post('/api/reporte/grafica-juzgado', this.data)
                        if (response.status === 200) {
                            if (response.data.status === "ok") {
                                // 
                                this.tabla = response.data.reporte.tabla
                            //    console.log(this.tabla)
                                // this.$store.commit('setCatalogoCitasDelDia', this.reporte)
                                this.reservadas = response.data.reporte.reservadas
                                this.atendidas = response.data.reporte.atendidas
                                this.canceladas = response.data.reporte.canceladas
                                this.total = response.data.reporte.total
                                this.porcent_1 = response.data.reporte.porcent_1
                                this.porcent_2 = response.data.reporte.porcent_2
                                this.porcent_3 = response.data.reporte.porcent_3
                                this.getDataPagina(1)
                                this.showGraph = true
                                this.mostrar = true
                            } else {
                                errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al obtener las estadísticas')
                        }
                    } catch (error) {
                        errorSweetAlert('Ocurrió un error al obtener las estadísticas')
                    }
                    this.loading = false
            },
            totalPaginas() {
                return Math.ceil(this.tabla.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.tabla[index]) {
                        this.datosPaginados.push(this.tabla[index])
                    }
                }

                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.tabla.length
                }
            },
            getFirstPage() {
                this.paginaActual = 1
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            getPreviousPage() {
                if (this.paginaActual > 1) {
                    this.paginaActual--
                }
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            getNextPage() {
                if (this.paginaActual < this.totalPaginas()) {
                    this.paginaActual++
                }
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            getLastPage() {
                this.paginaActual = this.totalPaginas()
                this.setCurrentPage(this.paginaActual)
                this.getDataPagina(this.paginaActual)
            },
            isActive (noPagina) {
                return noPagina == this.paginaActual ? 'active' : ''
            },
            setCurrentPage(pagina) {
                this.current = pagina
            },
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