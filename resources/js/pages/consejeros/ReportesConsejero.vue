<template>
    <div class="container">
        <div class="text-center my-6">
            <h2>Reporte de Gráficas</h2>
        </div>

        <div class="my-6 px-4 py-4">
            <v-form class="col-12" ref="formGraficas">
                <div class="row justify-content-between">
                    <div class="col-md-4 col-12">
                        <v-text-field
                            v-model="reporte.fecha_inicio"
                            variant="solo"
                            type="date"
                            label="Fecha Inicio"
                            :rules="fechaInicioRules"
                        ></v-text-field>
                    </div>
                    <div class="col-md-4 col-12">
                        <v-text-field
                            v-model="reporte.fecha_final"
                            variant="solo"
                            type="date"
                            label="Fecha Fin"
                            :rules="fechaFinRules"
                        ></v-text-field>
                    </div>
                    <div class="col-md-4 col-12">
                        <v-select
                            v-model="reporte.estatus"
                            :items="estatus"
                            item-title="nombre"
                            item-value="id"
                            label="Seleccione un estatus"
                            variant="solo"
                            :rules="estatusRules"
                        ></v-select>
                    </div>
                </div>

                <div class="row justify-content-between mt-6">
                    <div class="text-center col-12">
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
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </div>
                </div>
            </v-form>

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
                                    <th class="titulo-columna">Nombre</th>
                                    <!-- <th class="titulo-columna">Expediente</th> -->
                                    <th class="titulo-columna">Fecha</th>
                                    <th class="titulo-columna">Horario</th>
                                    <th class="titulo-columna borde-derecho">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="loading">
                                    <th colspan="6">
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
                                        {{cita.nombre}}
                                    </td>
                                    <!-- <td class="texto-campo-table text-center">
                                        {{cita.expediente}}
                                    </td> -->
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
                <div class="text-center">
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        class="boton-nuevo"
                        @click="exportarReporte()"
                    >
                        Exportar a Excel
                    </v-btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../../helpers/sweetAlertGlobals"

    export default defineComponent({
        name:'reportes-consejero',
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
                    estatus: 4,
                },
                fechaInicioRules: [
                    v => !!v || 'El campo fecha inicio es requerido'
                ],
                fechaFinRules: [
                    v => !!v || 'El campo fecha fin es requerido'
                ],
                estatusRules: [
                    v => !!v || 'El campo estatus es requerido'
                ],
                estatus:[
                    {
                        id: 4,
                        nombre:'TODOS'
                    },
                    {
                        id: 1,
                        nombre:'Reservadas'
                    },
                    {
                        id: 2,
                        nombre:'Confirmadas'
                    },
                    {
                        id: 3,
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
            async generarReporte() {
                const { valid } = await this.$refs.formGraficas.validate()
                if (valid) {
                    try {
                        let response = await axios.post('/api/reportes/generar-reporte-consejero', this.reporte)
                        if (response.status === 200) {
                            if (response.data.status === "ok") {
                                this.citas = response.data.reporte
                                this.export.citas = response.data.reporte
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
                }
            },
            async exportarReporte()
            {

                let response = await axios.post('/api/reportes/exportar-reporte-citas-consejero',this.export,{
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

<style>
.select{
    font-size: 1.6rem;
    font-size: 80%;
}
</style>