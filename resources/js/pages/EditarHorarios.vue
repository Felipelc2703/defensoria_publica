<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Editar Horarios</h2>
        </div>

        <div class="my-6 px-4 py-4">
            <v-form class="col-12" ref="formEditarHorario">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-12">
                        <v-select
                            v-model="horario.centro_atencion_id"
                            :items="centrosAtencion"
                            item-title="nombre"
                            item-value="id"
                            label="Seleccione el centro de atencion"
                            variant="solo"
                            :rules="centroAtencionRules"
                            >
                        </v-select>
                    </div>
                    <div class="col-md-6 col-12">
                        <v-select
                            v-model="horario.mes"
                            :items="meses"
                            item-title="nombre"
                            item-value="id"
                            label="Seleccione el mes"
                            variant="solo"
                            :rules="mesRules"
                            >
                        </v-select>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <v-btn
                        variant="flat"
                        color="#6a73a0"
                        class="boton-nuevo"
                        @click="cargarDias()"
                        >
                        Cargar Días
                    </v-btn>
                </div>
            </v-form>

            <div v-if="cargaDias">
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
                                    <th class="titulo-columna borde-izquierdo">Día</th>
                                    <th class="titulo-columna">Horario Inicial</th>
                                    <th class="titulo-columna">Horario Fin</th>
                                    <th class="titulo-columna">Inhabil</th>
                                    <th class="titulo-columna borde-derecho">Editar</th>
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
                                <tr v-else v-for="fecha in datosPaginados" :key="fecha.id">
                                    <td class="texto-campo-table">
                                        {{fecha.dia}}
                                    </td>
                                    <td class="texto-campo-table text-center">
                                        {{fecha.hora_inicio}}
                                    </td>
                                    <td class="texto-campo-table text-center">
                                        {{fecha.hora_fin}}
                                    </td>
                                    <td class="texto-campo-table text-center">
                                        <input disabled type="checkbox" v-model="fecha.inhabil" @click="checkinhabil(fecha)">
                                    </td>
                                    <td class="text-center">
                                        <div>
                                            <v-icon
                                                @click="editarHorario(fecha)"
                                                >
                                                mdi-text-box-edit-outline
                                            </v-icon>

                                            <v-tooltip
                                                activator="parent"
                                                location="bottom"
                                                >
                                                <span style="font-size: 15px;">Editar Fecha</span>
                                            </v-tooltip>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <template v-if="dias.length > 0">
                        <div class="row justify-content-between container">
                            <div>
                                <p class="text-resultados mt-2">
                                    Mostrando
                                    <span>{{from}}</span>
                                    -
                                    <span>{{to}}</span>
                                    de
                                    <span>{{dias.length}}</span>
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

            <v-dialog
                v-model="dialogEditarDia"
                max-width="800px"
                persistent
                >
                <v-card>
                    <v-card-title>
                        <h3 class="mt-2">Cambio de Horario</h3>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-form class="col-12" ref="formCambioHorario">
                                    <p><strong>Día: </strong>{{ editar.dia }}</p>

                                    <div class="row justify-content-between">
                                        <div class="col-md-6 col-12">
                                            <v-text-field
                                                v-model="editar.hora_inicio"
                                                variant="solo"
                                                type="time" 
                                                label="Hora inicio" 
                                                >
                                            </v-text-field>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <v-text-field
                                                v-model="editar.hora_fin"
                                                variant="solo"
                                                type="time" 
                                                label="Hora Fin" 
                                                >
                                            </v-text-field>
                                        </div>
                                    </div>

                                    <div class="row justify-content-between">
                                        <div class="col-md-6 col-12">
                                            <v-text-field
                                                v-model="editar.duracion"
                                                label="Duracion Cita"
                                                type="number"
                                                variant="solo"
                                                >
                                            </v-text-field>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <v-checkbox
                                                v-model="editar.inhabil"
                                                label="Inhabil"
                                                >
                                            </v-checkbox>
                                        </div>
                                    </div>
                                </v-form>
                            </v-row>
                        </v-container>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                variant="flat"
                                color="#881001"
                                @click="cancelarCambioHorario()"
                            >
                                <span style="color: #eaeaed;">Cancelar</span>
                            </v-btn>
                            <v-btn
                                variant="flat"
                                color="#6a73a0"
                                @click="guardarCambios(dia)"
                            >
                                <span style="color: #eaeaed;">Guardar Cambios</span>
                            </v-btn>
                        </v-card-actions>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"

    export default defineComponent({
        name:'editar-horario',
        data() {
            return {
                loading: false,
                cargaDias: false,
                dialogEditarDia: false,
                horario: {
                    centro_atencion_id: '',
                    mes: '',
                    pmes: true,
                },
                editar: {
                    id: null, 
                    accion: '',
                    dia: '',
                    hora_inicio: '',
                    hora_fin: '',
                    duracion: '',
                    inhabil: false,
                    mes: '',
                    centro_atencion_id: ''
                },
                acciones: [
                    'HABILITAR/DESHABILITRA DIA', 'AMPLIAR HORARIO','REDUCIR HORARIO', 'CAMBIAR DURACIÓN DE CITA'
                ],
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
                centroAtencionRules: [
                    v => !!v || 'El campo de centro de atención es requerido'
                ],
                mesRules: [
                    v => !!v || 'El campo mes es requerido'
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
        },
        computed: {
            dias() {
                return this.$store.getters.getDias
            },
            centrosAtencion() {
                return this.$store.getters.getCatalogoCentrosAtencion
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
                    this.datosPaginados = this.dias.filter(item => {
                        return item.dia.toLowerCase().includes(this.buscar.toLowerCase())
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
            async getCentrosAtencion() {
                this.loading = true
                try {
                    let response = await axios.get('/api/catalogos/centros-de-atencion')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCatalogoCentrosAtencion', response.data.centros_atencion)
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
            async cargarDias() {
                const { valid } = await this.$refs.formEditarHorario.validate()
                if (valid) {
                    try {
                        let response = await axios.post('/api/horarios/dias-editar', this.horario)
                        if(response.status === 200) {
                            if(response.data.status === "ok") {
                                this.$store.commit('setDias', response.data.dias)
                                this.cargaDias = true
                                this.mostrar = true
                                this.getDataPagina(1)
                            } else {
                                errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al cargar dias')
                        }
                    }catch (error) {
                        errorSweetAlert('Ocurrió un error al cargar dias')
                    }
                }
            },
            editarHorario(dia)
            {
                this.editar.id = dia.id
                this.editar.dia = dia.dia
                this.editar.hora_inicio = dia.hora_inicio
                this.editar.hora_fin = dia.hora_fin
                this.editar.duracion = dia.duracion
                this.editar.inhabil = dia.inhabil
                this.editar.mes = dia.mes
                this.editar.centro_atencion_id = dia.centro_atencion_id
                this.dialogEditarDia = true
            },

            async guardarCambios()
            {
                const { valid } = await this.$refs.formCambioHorario.validate()
                // this.horario.dias = this.dias
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
                                let response = await axios.post('/api/horarios/actualizar-horario', this.editar)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al editar el dias.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setDias', result.value.data.dias)
                                    this.cancelarCambioHorario()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al editar dias.')
                            }
                        }
                    })
                }
            },
            limpiarFormulario()
            {
                this.horario.centro_atencion_id =''
                this.horario.mes =  ''
                this.dialogEditarDia = false
            },
            cancelarCambioHorario() {
                this.editar.id = null
                this.editar.dia = ''
                this.editar.hora_inicio = ''
                this.editar.hora_fin = ''
                this.editar.duracion = ''
                this.dialogEditarDia = false
            },
            totalPaginas() {
                return Math.ceil(this.dias.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.dias[index]) {
                        this.datosPaginados.push(this.dias[index])
                    }
                }

                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.dias.length
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