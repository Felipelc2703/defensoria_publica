<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Centros de Atención</h2>
            <div>
                <v-btn
                    color="#6a73a0"
                    class="mt-4 mb-2 boton-nuevo"
                    large
                    title="Nuevo Centro de Atención"
                    @click="agregarCentro"
                    append-icon="mdi-plus"
                    >
                    Nuevo Centro
                </v-btn>
            </div>
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
                            <th class="titulo-columna">Nombre Centro de Atención</th>
                            <th class="titulo-columna">Dirección</th>
                            <th class="titulo-columna borde-derecho">Acciones</th>
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
                        <tr v-else v-for="centro in datosPaginados" :key="centro.id">
                            <td class="texto-campo-table">
                                {{centro.numero_registro}}
                            </td>
                            <td class="texto-campo-table">
                                {{centro.nombre}}
                            </td>
                            <td class="texto-campo-table">
                                {{centro.direccion}}
                            </td>
                            <td>
                                <div class="text-center row justify-content-center">
                                    <div>
                                        <v-icon 
                                            title="Editar Centro"
                                            @click="editarCentro(centro)"
                                            class="mr-1"
                                            >
                                            mdi-text-box-edit-outline
                                        </v-icon>

                                        <v-tooltip
                                            activator="parent"
                                            location="bottom"
                                            >
                                            <span style="font-size: 15px;">Editar Centro</span>
                                        </v-tooltip>
                                    </div>
                                    
                                    <div>
                                        <v-icon 
                                            title="Eliminar Centro"
                                            @click="eliminarCentro(centro)"
                                            class="ml-1"
                                        >
                                            mdi-trash-can
                                        </v-icon>
                                        <v-tooltip
                                            activator="parent"
                                            location="bottom"
                                            >
                                            <span style="font-size: 15px;">Eliminar Centro</span>
                                        </v-tooltip>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <template v-if="centrosAtencion.length > 0">
                <div class="row justify-content-between container">
                    <div>
                        <p class="text-resultados mt-2">
                            Mostrando
                            <span>{{from}}</span>
                            -
                            <span>{{to}}</span>
                            de
                            <span>{{centrosAtencion.length}}</span>
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

        <v-dialog
            v-model="dialogAgregarCentro"
            max-width="800px"
            persistent
        >
            <v-card>
                <v-card-title>
                    <h3>Agregar Oficina</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formAgregarOficina">
                                <v-text-field
                                    v-model="centro.nombre"
                                    label="Nombre"
                                    :rules="nombreRules"
                                ></v-text-field>
                                <v-text-field
                                    v-model="centro.direccion"
                                    label="Dirección"
                                    :rules="direccionRules"
                                ></v-text-field>
                                <div class="row justify-content-between">
                                    <div class="col-sm-6 col-12">
                                        <v-text-field
                                            v-model="centro.telefono"
                                            label="Teléfono"
                                        >
                                        </v-text-field>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <v-text-field
                                            v-model="centro.numero_cajas"
                                            label="Número de cajas"
                                            type="number"
                                            min="0"
                                        >
                                        </v-text-field>
                                    </div>
                                </div>
                                <div v-for="(tramite, index) in tramites" :key="index">
                                    <input type="checkbox" :value="tramite.id" v-model="centro.tramites" :id="`check_${index}`">  <label :for="`check_${index}`">{{tramite.nombre}}</label>
                                </div>
                            </v-form>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="cancelarAgregarCentroAtencion()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        @click="guardarNuevoCentroAtencion()"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog
            v-model="dialogEditarCentro"
            max-width="800px"
            persistent
        >
            <v-card>
                <v-card-title>
                    <h3>Editar Oficina</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formEditarOficina">
                                <v-text-field
                                    v-model="centro.nombre"
                                    label="Nombre"
                                    :rules="nombreRules"
                                ></v-text-field>
                                <v-text-field
                                    v-model="centro.direccion"
                                    label="Dirección"
                                    :rules="direccionRules"
                                ></v-text-field>
                                <div class="row justify-content-between">
                                    <div class="col-sm-6 col-12">
                                        <v-text-field
                                            v-model="centro.telefono"
                                            label="Teléfono"
                                            counter="10"
                                            maxlength="10"
                                        >
                                        </v-text-field>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <v-text-field
                                            v-model="centro.numero_cajas"
                                            label="Número de cajas"
                                            type="number"
                                        >
                                        </v-text-field>
                                    </div>
                                </div>
                                <div v-for="(tramite, index) in tramites" :key="index">
                                    <input type="checkbox" :value="tramite.id" v-model="centro.tramites" :id="`check_${index}`">  <label :for="`check_${index}`">{{tramite.nombre}}</label>
                                </div>
                            </v-form>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="cancelarEditarCentroAtencion()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        @click="guardarCambiosCentroAtencion()"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import { defineComponent } from "vue"
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"

    export default defineComponent({
        name: 'centros-atencion',
        data() {
            return {
                dialogAgregarCentro: false,
                dialogEditarCentro: false,
                loading: false,
                centro: {
                    id: null,
                    nombre: '',
                    direccion: '',
                    telefono: '',
                    numero_cajas: '',
                    tramites: [],
                },
                nombreRules: [
                    v => !!v || 'El nombre del centro de atención es requerido'
                ],
                direccionRules: [
                    v => !!v || 'La dirección del centro de atención es requerida'
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
        created() {
            this.getCentrosAtencion()
            this.getTramites()
        },
        computed: {
            centrosAtencion() {
                return this.$store.getters.getCatalogoCentrosAtencion
            },
            tramites() {
                return this.$store.getters.getCatalogoTramites
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
                    this.datosPaginados = this.centrosAtencion.filter(item => {
                        return item.nombre.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.direccion.toLowerCase().includes(this.buscar.toLowerCase())
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
            // Obtiene el catalogo de centros de atencion
            async getCentrosAtencion() {
                this.loading = true
                try {
                    let response = await axios.get('/api/catalogos/centros-de-atencion')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCatalogoCentrosAtencion', response.data.centros_atencion)
                            this.mostrar = true
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
            // Obtiene el catalogo de tramites
            async getTramites() {
                try {
                    let response = await axios.get('/api/catalogos/tramites')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCatalogoTramites', response.data.tramites)
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catálogo de trámites')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catálogo de trámites')
                }
            },
            // Abrir modal nuevo centro de atencion
            agregarCentro() {
                this.dialogAgregarCentro = true
            },
            // Cerrar modal nuevo centro de atencion
            cancelarAgregarCentroAtencion() {
                this.dialogAgregarCentro = false
                this.centro.nombre = ''
                this.centro.direccion = ''
                this.centro.telefono = ''
                this.centro.numero_cajas = ''
                this.centro.tramites = []
            },
            // Guarda un nuevo centro de atencion
            async guardarNuevoCentroAtencion() {
                const { valid } = await this.$refs.formAgregarOficina.validate()
                if (valid) {
                    Swal.fire({
                        title: '¿Guardar nuevo centro de atención?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {
                                let response = await axios.post('/api/centro-atencion/guardar-nuevo', this.centro)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar nuevo centro de atención.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoCentrosAtencion', result.value.data.centros_atencion)
                                    this.cancelarAgregarCentroAtencion()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar nuevo centro de atención.')
                            }
                        }
                    })
                }
            },
            // Abrir modal editar centro de atencion
            editarCentro(centro) {
                this.centro.id = centro.id
                this.centro.nombre = centro.nombre
                this.centro.direccion = centro.direccion
                this.centro.telefono = centro.telefono
                this.centro.numero_cajas = centro.numero_cajas
                this.centro.tramites = centro.tramites
                this.dialogEditarCentro = true
            },
            // Cerrar modal editar centro de atencion
            cancelarEditarCentroAtencion() {
                this.dialogEditarCentro = false
                this.centro.id = null;
                this.centro.nombre = ''
                this.centro.direccion = ''
                this.centro.telefono = ''
                this.centro.numero_cajas = ''
                this.centro.tramites = []
            },
            // Actualiza datos de centro de atencion
            async guardarCambiosCentroAtencion() {
                const { valid } = await this.$refs.formEditarOficina.validate()
                if (valid) {
                    Swal.fire({
                        title: '¿Guardar cambios?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {
                                let response = await axios.post('/api/centro-atencion/actualizar-centro', this.centro)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar centro de atención.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoCentrosAtencion', result.value.data.centros_atencion)
                                    this.cancelarEditarCentroAtencion()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar centro de atención.')
                            }
                        }
                    })
                }
            },
            // Elimina (cambia el status) de un centro de atencion
            eliminarCentro(centro) {
                Swal.fire({
                    title: '¿Eliminar Centro de Atención?',
                    icon: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#D33',
                    confirmButtonColor: '#3085D6',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, eliminar',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                            let response = await axios.post('/api/centro-atencion/eliminar-centro', centro)
                            return response
                        } catch (error) {
                            errorSweetAlert('Ocurrió un error al eliminar centro de atención.')
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.value.status === 200) {
                            if (result.value.data.status === "ok") {
                                successSweetAlert(result.value.data.message)
                                this.$store.commit('setCatalogoCentrosAtencion', result.value.data.centros_atencion)
                                this.cancelarAgregarCentroAtencion()
                                this.getDataPagina(1)
                            } else {
                                errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al eliminar centro de atención.')
                        }
                    }
                })
            },
            totalPaginas() {
                return Math.ceil(this.centrosAtencion.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.centrosAtencion[index]) {
                        this.datosPaginados.push(this.centrosAtencion[index])
                    }
                }

                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.centrosAtencion.length
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