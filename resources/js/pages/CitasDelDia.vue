<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Citas del Día</h2>
        </div>
        
        <div class="row justify-content-between m-auto">
            <div class="col-md-4 col-12">
                <v-form ref="formBuscarDia" class="row justify-content-between">
                    <div class="col-12">
                        <v-text-field
                            v-model="ver.dia"
                            variant="solo" 
                            type="date"
                            label="Seleccione la fecha"
                            :rules="fechaB"
                        ></v-text-field>   
                    </div>
                    <div class="col-12 text-center">
                        <v-btn
                            variant="flat"
                            color="#6a73a0"
                            class="boton-nuevo"
                            @click="verCitas()"
                            >
                            Ver citas
                        </v-btn>
                    </div>
                </v-form>           
            </div>
            <div class="col-md-8 col-12 mt-10 text-right">
                <div class="buscador-data-table mt-8">
                    <input type="search" v-model="buscar" placeholder="Buscar..." autocomplete="off">
                </div>
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
                            <th class="titulo-columna">Estatus</th>
                            <th class="titulo-columna">Editar</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loading">
                            <th colspan="9">
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
                            <td class="texto-campo-table">
                                {{citas.statusnom}}
                            </td>
                            <td>
                                <div>
                                    <v-icon
                                        @click="editar(citas)"
                                        >
                                        mdi-text-box-edit-outline
                                    </v-icon>

                                    <v-tooltip
                                        activator="parent"
                                        location="bottom"
                                        >
                                        <span style="font-size: 15px;">Editar</span>
                                    </v-tooltip>
                                </div>
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
    </div>

    <v-dialog
        v-model="dialogEditar"
        max-width="800px"
        persistent
        >
        <v-card>
            <v-card-title>
                <h3 class="mt-2">Estatus de la Cita</h3>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-form class="col-12" ref="formCambioEstatus" >
                            
                            <div class="col-md-6 col-12">
                                    <label class="label">Estatus</label>
                                    <v-radio-group inline v-model="cita.status">
                                        <v-radio value='1'>
                                            <template v-slot:label>
                                                <div><strong class="texto-custom-radio">No atendida</strong></div>
                                            </template>
                                        </v-radio>
                                        <v-radio value='2'>
                                            <template v-slot:label>
                                                <div><strong class="texto-custom-radio">Atendida</strong></div>
                                            </template>
                                        </v-radio>
                                        <v-radio  value='3'>
                                            <template v-slot:label>
                                                <div><strong class="texto-custom-radio">Cancelada</strong></div>
                                            </template>
                                        </v-radio>
                                    </v-radio-group>
                                
                            </div>
                        <div class="col-md-6 col-12" v-if="cita.status == '3'">
                            <label class="black-label">¿Por que cancelas la cita?</label>
                            <v-text-field
                                v-model="cita.motivo"
                                
                            >
                        </v-text-field>
                        </div>
                                
                        </v-form>
                    </v-row>
                </v-container>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="cancelarCambio()"
                    >
                        <span style="color: #eaeaed;">Cancelar</span>
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        @click="guardarCambios()"
                    >
                        <span style="color: #eaeaed;">Guardar Cambios</span>
                    </v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
    import { defineComponent } from "vue"
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"
    
    export default defineComponent({
        data() {
            return {
                loading: false,
                dialogAgregarCentro: false,
                dialogEditar: false,
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
                cita: {
                    id: null,
                    status: '',
                    motivo: '',
                },
                ver: {
                    dia: new Date().toISOString().slice(0, 10),
                },
                fechaB: [
                    v => !!v || 'El campo fecha es requerido'
                ],
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
                        || item.folio.toLowerCase().includes(this.buscar.toLowerCase())
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
            editar(citas){   
                this.cita.id = citas.id
                this.cita.status = citas.status
                this.cita.motivo = citas.motivo
                this.dialogEditar = true
            },
            cancelarCambio() {
                this.cita.status = ''
                this.cita.motivo = ''
                this.cita.id = null
                this.dialogEditar = false
            },
            async guardarCambios()
            {
                let date = new Date().toISOString().slice(0, 10);
                console.log(date)
                const { valid } = await this.$refs.formCambioEstatus.validate()
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
                                let response = await axios.post('/api/citas/guardar-cambios-cita', this.cita)
                                
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar estatus.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    if(this.ver.dia === date){
                                        this.$store.commit('setCatalogoCitasDelDia', result.value.data.citas)
                                        this.getDataPagina(1)
                                    }else{
                                        this.verCitas()
                                    }
                                    this.cancelarCambio()
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al editar estatus.')
                            }
                        }
                    })
                }
            },
            async verCitas() {
                const { valid } = await this.$refs.formBuscarDia.validate()
                if (valid) {
                    try {
                        let response = await axios.post('/api/citas/citas-del-dia-buscada', this.ver)
                        if(response.status === 200) {
                            if(response.data.status === "ok") {
                                this.$store.commit('setCatalogoCitasDelDia', response.data.citas)
                                this.mostrar = true
                                this.getDataPagina(1)
                            } else {
                                errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al cargar días')
                        }
                    }catch (error) {
                        errorSweetAlert('Ocurrió un error al cargar días')
                    }
                }
            },
        },
    })
</script>