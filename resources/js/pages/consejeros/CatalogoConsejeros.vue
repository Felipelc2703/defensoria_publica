<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Consejeros</h2>
            <div>
                <v-btn
                    color="#6a73a0"
                    class="mt-4 mb-2 boton-nuevo"
                    large
                    title="Nuevo Consejero"
                    @click="AgregarConsejero"
                    append-icon="mdi-plus"
                    >
                    Nuevo Consejero
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
                            <th class="titulo-columna">Nombre</th>
                            <!-- <th class="titulo-columna">Juzgado</th> -->
                            <!-- <th class="titulo-columna">Juzgado</th> -->
                            <th class="titulo-columna borde-derecho">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loading">
                            <th colspan="5">
                                <p class="text-center texto-cargando-datos">Cargando datos...</p>
                                <div class="linear-activity">
                                    <div class="indeterminate"></div>
                                </div>
                            </th>
                        </tr>
                        <tr v-else v-for="consejero in datosPaginados" :key="consejero.id">
                            <td class="texto-campo-table">
                                {{consejero.num_registro}}
                            </td>
                            <td class="texto-campo-table">
                                {{consejero.nombrecompleto}}
                            </td>
                            <!-- <td class="texto-campo-table">
                                {{juez.juez}}
                            </td> -->
                            <!-- <td class="texto-campo-table">
                                {{juez.juzgado}}
                            </td> -->
                            <td>
                                <div class="text-center row justify-content-center">
                                    <div>
                                        <v-icon 
                                        title="Editar Consejero"
                                        @click="EditarConsejero(consejero)"
                                        class="mr-1"
                                        >
                                            mdi-text-box-edit-outline
                                        </v-icon>

                                        <v-tooltip
                                            activator="parent"
                                            location="bottom"
                                            >
                                            <span style="font-size: 15px;">Editar Consejero</span>
                                        </v-tooltip>
                                    </div>
                                    
                                    <div>
                                        <v-icon 
                                            title="Eliminar Consejero"
                                            @click="eliminarConsejero(consejero)"
                                            class="ml-1"
                                        >
                                            mdi-trash-can
                                        </v-icon>
                                        <v-tooltip
                                            activator="parent"
                                            location="bottom"
                                            >
                                            <span style="font-size: 15px;">Eliminar Consejero</span>
                                        </v-tooltip>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <template v-if="consejeros.length > 0">
                <div class="row justify-content-between container">
                    <div>
                        <p class="text-resultados mt-2">
                            Mostrando
                            <span>{{from}}</span>
                            -
                            <span>{{to}}</span>
                            de
                            <span>{{consejeros.length}}</span>
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

        <!-- modal para agregar consejero -->
        <v-dialog
            v-model="dialogAgregarConsejero"
            max-width="700px"
            persistent
            >
            <v-card>
                <v-card-title>
                    <h3>Agregar Consejero</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formAgregarConsejero">
                                
                                    <v-text-field
                                        variant="solo"
                                        v-model="consejero.nombre"
                                        label="Nombre"
                                        :rules="nombreRules"
                                    ></v-text-field>
                                    <v-text-field
                                        variant="solo"
                                        v-model="consejero.apellido_paterno"
                                        label="Apellido Paterno"
                                        :rules="apellidoRules"
                                    ></v-text-field>
                                    <v-text-field
                                        variant="solo"
                                        v-model="consejero.apellido_materno"
                                        label="Apellido Materno"
                                        
                                    ></v-text-field>
                                   
                                    <!-- <v-select
                                    v-model="juez.juzgado_id"
                                            label="Juzgados"
                                            :items="juzgados"
                                            item-title="nombre"
                                            item-value="id"
                                            key="juzgados"
                                            persistent-hint
                                            variant="solo"
                                            :rules="juzgadoRules"
                                    ></v-select> -->
                                   
                                    <v-divider></v-divider>
                            </v-form>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="cancelarAgregarNuevoConsejero()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        @click="guardarNuevoConsejero()"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        
        <v-dialog
            v-model="dialogEditarConsejero"
            max-width="800px"
            persistent
        >
            <v-card>
                <v-card-title>
                    <h3>Editar Consejero</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formEditarConsejero">
                                <v-text-field
                                variant="solo"
                                    v-model="consejero.nombre"
                                    label="Nombre"
                                    :rules="nombreRules"
                                    
                                ></v-text-field>
                                <v-text-field
                                variant="solo"
                                    v-model="consejero.apellido_paterno"
                                    label="Apellido Paterno"
                                    :rules="apellidoRules"
                                ></v-text-field>
                                <v-text-field
                                        variant="solo"
                                        v-model="consejero.apellido_materno"
                                        label="Apellido Materno"
                                       
                                    ></v-text-field>
                                                             
                                <!-- <v-select
                                    v-model="juez.juzgado_id"
                                            label="Juzgado"
                                            :items="juzgados"
                                            item-title="nombre"
                                            item-value="id"
                                            key="juzgados"
                                            persistent-hint
                                            variant="solo"
                                            :rules="juzgadoRules"
                                ></v-select> -->

                            </v-form>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="CancelarEditarConsejero()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        @click="guardarCambiosEditarConsejero()"
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
    import { errorSweetAlert, successSweetAlert } from "../../helpers/sweetAlertGlobals"
    
    export default defineComponent({
        data() {
            return {
                dialogAgregarConsejero: false,
                dialogEditarConsejero: false,
                consejero: {
                    id: null,
                    nombre: '',
                    apellido_paterno: '',
                    apellido_materno: '',
                    // juzgado_id: null,
                   
                },
                loading: false,
                // dialogAgregarCentro: false,
                // rules:{
                //     email: value => {
                //     const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                //     return pattern.test(value) || 'El campo no contiene un correo electrónico valido'
                //     },
                // },
                juzgadoRules: [
                    v => !!v || 'El juzgado es requerido',
                ],
                nombreRules: [
                    v => !!v || 'El nombre es requerido',
                ],
                apellidoRules: [
                    v => !!v || 'La apellido es requerido',
                ],
                // materiaRules: [
                //     v => !!v || 'La materia es requerida',
                // ],
                show1: false,
                // password: 'Password',
                elementosPorPagina: 10,
                paginaActual: 1,
                datosPaginados: [],
                mostrar: false,
                from: '',
                to: '',
                numShown: 5,
                current: 1,
                buscar: '',
                // jueces: [],
            }
        },
        created(){
            this.getConsejeros()
            // this.getJueces()
        },
        computed:{
            consejeros() {
                return this.$store.getters.getConsejeros
            },
            // juzgados(){
            //     return this.$store.getters.getCatalogoJuzgados
            // },
            // jueces(){
            //     return this.$store.getters.getJueces
            // },
           
            pages() {
                const numShown = Math.min(this.numShown, this.totalPaginas())
                let first = this.current - Math.floor(numShown / 2)
                first = Math.max(first, 1)
                first = Math.min(first, this.totalPaginas() - numShown + 1)
                return [...Array(numShown)].map((k, i) => i + first)
            },
         
        },
        watch: {
         
            buscar: function () {
                if (!this.buscar.length == 0) {
                    this.datosPaginados = this.consejeros.filter(item => {
                        return item.nombrecompleto.toLowerCase().includes(this.buscar.toLowerCase())
                        // || item.centro_atencion.toLowerCase().includes(this.buscar.toLowerCase())
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
            async getConsejeros() {
                this.loading = true
                try {
                    let response = await axios.get('/api/consejeros')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setConsejeros', response.data.consejeros)
                            this.mostrar = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catálogo de consejeros.')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catálogo de consejeros.')
                }
                this.loading = false
            },
            // async getJueces() {
            //     this.loading = true
            //     try {
                    
            //         let response = await axios.get('/api/juzgados-jueces')
            //         if (response.status === 200) {
            //             if (response.data.status === "ok") {
            //                 this.$store.commit('setJueces', response.data.jueces)
            //                 this.mostrar = true
            //             } else {
            //                 errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
            //             }
            //         } else {
            //             errorSweetAlert('Ocurrió un error al obtener los jueces.')
            //         }
            //     } catch (error) {
            //         errorSweetAlert('Ocurrió un error al obtener los jueces.')
            //     }
            //     this.loading = false
            // },
            // Abrir modal nuevo consejero
            AgregarConsejero() {
                this.dialogAgregarConsejero = true
            },
            //Cerrar modal nuevo consejero
            cancelarAgregarNuevoConsejero() {
                this.dialogAgregarConsejero = false
                this.consejero.nombre = ''
                this.consejero.apellido_paterno = ''
                this.consejero.apellido_materno = ''
                // this.juez.juzgado_id = null

            },
            // Guardar nuevo consejero 
            async guardarNuevoConsejero() {
                const { valid } = await this.$refs.formAgregarConsejero.validate()
                if (valid) {
                    Swal.fire({
                        title: '¿Guardar nuevo Consejero?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {
                                // this.loading = true
                                let response = await axios.post('/api/guardar-consejero', this.consejero)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar al nuevo consejero.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setConsejeros', result.value.data.consejeros)
                                    this.cancelarAgregarNuevoConsejero()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar al nuevo consejero.')
                            }
                        }
                    })
                }
            },
            // Abrir modal de editar consejero ya con los datos cargados
            EditarConsejero(consejero) {
                this.dialogEditarConsejero = true
                this.consejero.id = consejero.id
                this.consejero.nombre = consejero.nombre
                this.consejero.apellido_paterno = consejero.apellidop
                this.consejero.apellido_materno = consejero.apellidom
                // this.consejero.juzgado_id = consejero.juzgado
            },
            // boton para cerrar el modal
            CancelarEditarConsejero() {
                this.dialogEditarConsejero = false
                this.consejero.id = null,
                this.consejero.nombre = ''
                this.consejero.apellido_paterno = ''
                this.consejero.apellido_materno = ''
                // this.consejero.juzgado_id = null
            },
            // Guardar Cambios de consejero 
            async guardarCambiosEditarConsejero() {
                const { valid } = await this.$refs.formEditarConsejero.validate()
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
                                let response = await axios.post('/api/actualizar-consejero', this.consejero)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del consejero.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setConsejeros', result.value.data.consejeros)
                                    this.CancelarEditarConsejero()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del consejero.')
                            }
                        }
                    })
                }
            },
            // "elimina" cambia estatus del consejero 
            eliminarConsejero(consejero) {
                Swal.fire({
                  title: '¿Eliminar Consejero?',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085D6',
                  cancelButtonColor: '#D33',
                  confirmButtonText: 'Si, eliminar',
                  cancelButtonText: 'Cancelar',
                  showLoaderOnConfirm: true,
                  preConfirm: async () => {
                      try {
                          let response = await axios.post('/api/eliminar-consejero', consejero)
                          return response
                      } catch (error) {
                          errorSweetAlert('Ocurrió un error al eliminar este consejero.')
                      }
                  },
                  allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                  if (result.isConfirmed) {
                      if (result.value.status === 200) {
                          if (result.value.data.status === "ok") {
                              successSweetAlert(result.value.data.message)
                              this.$store.commit('setConsejeros', result.value.data.consejeros)
                              this.CancelarEditarConsejero()
                              this.getDataPagina(1)
                          } else {
                              errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                          }
                      } else {
                          errorSweetAlert('Ocurrió un error al eliminar este consejero.')
                      }
                  }
              })

            },
         
            totalPaginas() {
                return Math.ceil(this.consejeros.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.consejeros[index]) {
                        this.datosPaginados.push(this.consejeros[index])
                    }
                }

                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.consejeros.length
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