<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Citas del Dia</h2>
        </div>

        <div class="text-right">
            <div class="buscador-data-table">
                <input type="search" v-model="buscar" placeholder="Buscar..." autocomplete="off">
            </div>
        </div>

        <div class="my-2 mb-12 py-6">
            <div class="container-fluid">
                <table class="table">
                    <thead class="headers-table">
                        <tr>
                            <th class="titulo-columna borde-izquierdo">#</th>
                            <th class="titulo-columna">Folio</th>
                            <th class="titulo-columna">Nombre</th>
                            <th class="titulo-columna">Fecha</th>
                            <th class="titulo-columna">Hora</th>
                            <th class="titulo-columna">Curp</th>
                            <th class="titulo-columna">Discapacidad</th>
                            <!-- <th class="titulo-columna borde-derecho">Acciones</th> -->
                            
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
                        <tr v-else v-for="citas in datosPaginados" :key="citas.id">
                            <td class="texto-campo-table">
                                {{citas.id}}
                            </td>
                            <td class="texto-campo-table">
                                {{citas.folio}}
                            </td>
                            <td class="texto-campo-table">
                                {{citas.nombre}}
                            </td>
                            <td class="texto-campo-table">
                                {{citas.fecha_formateada}}
                            </td>
                            <td class="texto-campo-table">
                                {{citas.hora_cita}}
                            </td>
                            <td class="texto-campo-table">
                                {{citas.curp}}
                            </td>
                            <td class="texto-campo-table">
                                {{citas.discapacidad}}
                            </td>
                            <td>
                                <!-- <div class="text-center row justify-content-center">
                                    <div>
                                        <v-icon 
                                        title="Editar Usuario"
                                        @click="EditarUsuario(usuario)"
                                        class="mr-1"
                                        >
                                            mdi-text-box-edit-outline
                                        </v-icon>

                                        <v-tooltip
                                            activator="parent"
                                            location="bottom"
                                            >
                                            <span style="font-size: 15px;">Editar Usuario</span>
                                        </v-tooltip>
                                    </div>
                                    
                                    <div>
                                        <v-icon 
                                            title="Eliminar Usuario"
                                            @click="eliminarUsuario(usuario)"
                                            class="ml-1"
                                        >
                                            mdi-trash-can
                                        </v-icon>
                                        <v-tooltip
                                            activator="parent"
                                            location="bottom"
                                            >
                                            <span style="font-size: 15px;">Eliminar Usuario</span>
                                        </v-tooltip>
                                    </div>
                                </div> -->
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
    </div>
</template>

<script>
    import { defineComponent } from "vue"
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"
    
    export default defineComponent({
        data() {
            return {
                
                loading: false,
                dialogAgregarCentro: false,
                show1: false,
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
        created(){
            this.getCatalogoCitasDelDia()
        },
        computed:{
            citas(){
                return this.$store.getters.getCatalogoCitasDelDia
            },
            pages() {
                const numShown = Math.min(this.numShown, this.totalPaginas())
                let first = this.current - Math.floor(numShown / 2)
                first = Math.max(first, 1)
                first = Math.min(first, this.totalPaginas() - numShown + 1)
                return [...Array(numShown)].map((k, i) => i + first)
            }
        },
        watch: {
            buscar: function () {
                if (!this.buscar.length == 0) {
                    this.datosPaginados = this.citas.filter(item => {
                        return item.nombre.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.citas.toLowerCase().includes(this.buscar.toLowerCase())
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
       
            // para mostrar los datos en la tabla principal
            async getCatalogoCitasDelDia() {
                this.loading = true
                try {
                    let response = await axios.get('/api/catalogos/citas-del-dia')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCatalogoCitasDelDia', response.data.citas)
                            this.mostrar = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catalogo de citas del dia')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catalogo de citas del dia catch')
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
        },
    })
</script>