<template>
    <v-container>
        <v-card-title>
            Reportes
        </v-card-title>
            <v-row>
                <v-col cols="3">
                    Fecha Inicio:
                    <v-text-field
                    v-model="reporte.fecha_inicio"
                    type="date"
                    variant="underlined"
                    ></v-text-field>
                </v-col>
                <v-col cols="3">
                    Fecha Fin:
                    <v-text-field
                    v-model="reporte.fecha_final"
                    type="date"
                    variant="underlined"
                    ></v-text-field>
                </v-col>
                <v-col>
                    Oficina:
                    <v-select
                        v-model="reporte.oficina_id"
                        :items="centrosAtencion"
                        item-title="nombre"
                        item-value="id"
                        label="Seleccione el centro de atención"
                        variant="underlined"
                    ></v-select>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    Trámite:
                    <v-select
                        v-model="reporte.tramite_id"
                        :items="tramites"
                        item-title="nombre"
                        item-value="id"
                        label="Seleccione el tramite"
                        variant="underlined"
                    ></v-select>
                </v-col>
                <v-col>
                    Estatus:
                    <v-select
                        v-model="reporte.estatus"
                        :items="estatus"
                        item-title="nombre"
                        item-value="id"
                        label="Seleccione un estatus"
                        variant="underlined"
                    ></v-select>
                </v-col>
            </v-row>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    variant="flat"
                    color="#6a73a0"
                    class="boton-nuevo"
                    @click="generarReporte()"
                >
                    Generar Reporte
                </v-btn>
            </v-card-actions>


            <!-- inicio tabla -->

            <div v-if="bandCitas">
                <div class="text-right mt-8">
                    <div class="buscador-data-table">
                        <input type="search" v-model="buscar" placeholder="Buscar..." autocomplete="off">
                    </div>
                </div>

                <div class="my-2 mb-12 py-6">
                    <div class="container-fluid">
                        <table class="table">
                            <thead class="headers-table">
                                <tr>
                                    <th class="titulo-columna borde-izquierdo">Folio</th>
                                    <th class="titulo-columna">Nombre Contribuyente</th>
                                    <th class="titulo-columna">Tramite</th>
                                    <th class="titulo-columna">Fecha</th>
                                    <th class="titulo-columna">Horario</th>
                                    <th class="titulo-columna borde-derecho">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="loading">
                                    <th colspan="4">
                                        <p class="text-center texto-cargando-datos">Cargando datos...</p>
                                        <div class="linear-activity">
                                            <div class="indeterminate"></div>
                                        </div>
                                    </th>
                                </tr>
                                <tr v-else v-for="cita in datosPaginados" :key="cita.id">
                                    <td class="texto-campo-table">
                                        {{cita.folio}}
                                    </td>
                                    <td class="texto-campo-table text-center">
                                        {{cita.nombre_contribuyente}}
                                    </td>
                                    <td class="texto-campo-table text-center">
                                        {{cita.tramite}}
                                    </td>
                                    <td class="texto-campo-table text-center">
                                        {{cita.fecha}}
                                    </td>
                                    <td class="texto-campo-table text-center">
                                        {{cita.horario}}
                                    </td>
                                    <td class="texto-campo-table text-center">
                                        {{cita.estatus}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <template v-if="citas.length > 0">
                        <div class="row justify-content-between container">
                            <div>
                                <p class="text-resultados mt-2">
                                    Mostrando
                                    <span>{{from}}</span>
                                    -
                                    <span>{{to}}</span>
                                    de
                                    <span>{{citas.length}}</span>
                                    resultados
                                </p>
                            </div>
                            <div>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination pagination-lg justify-content-center">
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
                <div class="text-center">
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        class="boton-nuevo"
                        @click="exportarReporte()"
                    >
                        Guardar Horarios
                    </v-btn>
                </div>
            </div>
            <!-- Fin tabla -->
    </v-container>
</template>
<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"
    export default defineComponent({
        name:'agregar-horario',
        data() {
            return {
                loading: false,
                bandCitas: false,
                citas: [],
                export: {
                    citas: [],
                },
                reporte: {
                    fecha_inicio: '',
                    fecha_final: '',
                    oficina_id: '',
                    tramite_id: '',
                    estatus: null,
                },
                centrosAtencion: [],
                tramites: [],
                centro_default: {
                    id: 0,
                    nombre: 'TODOS',
                    direccion: '',
                    telefono: '',
                    numero_cajas: ''
                },
                tramite_default: {
                    id: 0,
                    nombre: 'TODOS',
                },
                estatus:[
                    {
                        id: 4,
                        nombre:'TODOS'
                    },
                    {
                        id: 0,
                        nombre:'Reservadas'
                    },
                    {
                        id: 1,
                        nombre:'Confirmadas'
                    },
                    {
                        id: 2,
                        nombre:'Canceladas'
                    }
                ],
                elementosPorPagina: 10,
                paginaActual: 1,
                datosPaginados: [],
                mostrar: false,
                from: '',
                to: '',
                numShown: 5,
                current: 1,
                buscar: '',
            }
        },
        created () {
            this.getCentrosAtencion()
            this.getCatalogoTramites()
        },
        computed: {
            pages() {
                const numShown = Math.min(this.numShown, this.totalPaginas())
                let first = this.current - Math.floor(numShown / 2)
                first = Math.max(first, 1)
                first = Math.min(first, this.totalPaginas() - numShown + 1)
                return [...Array(numShown)].map((k, i) => i + first)
            }
        },
        methods: {
            async generarReporte()
            {
                console.log(this.reporte)
                this.loading = true
                try {
                    let response = await axios.post('/api/reportes/generar-reporte', this.reporte)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.citas = response.data.reporte
                            this.export.citas = response.data.reporte
                            console.log("citas",this.citas)
                            this.getDataPagina(1)
                            this.bandCitas = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el reporte1')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el reporte2')
                }
                this.loading = false


            },
            async exportarReporte()
            {

                console.log("fidndfiundfuid",this.citas)
                let response = await axios.post('/api/reportes/exportar-reporte-citas',this.export,{
                    responseType: "blob",
                }).then((response)=>{    
                    
                var blob = new Blob([response.data], {
                    type: response.headers["content-type"],
                });
                const link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = `reporte.xlsx`;
                link.click();
                })
            },
            async getCentrosAtencion()
            {
                this.loading = true
                try {
                    let response = await axios.get('/api/catalogos/centros-de-atencion')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.centrosAtencion = response.data.centros_atencion
                            this.centrosAtencion.unshift(this.centro_default)

                            // this.$store.commit('setCatalogoCentrosAtencion', response.data.centros_atencion)

                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catálogo de centros de atención')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catálogo de centros de atención')
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
                            // this.$store.commit('setCatalogoTramites', response.data.tramites)
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

            totalPaginas() {
                return Math.ceil(this.citas.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.citas[index]) {
                        this.datosPaginados.push(this.citas[index])
                    }
                }

                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.citas.length
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