<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Juzgados</h2>
            <div>
                <v-btn
                    color="#6a73a0"
                    class="mt-4 mb-2 boton-nuevo"
                    large
                    title="Nuevo Juzgado"
                    @click="AgregarJuzgado"
                    append-icon="mdi-plus"
                    >
                    Nuevo Juzgado
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
                            <th class="titulo-columna">Materia</th>
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
                        <tr v-else v-for="juzgado in datosPaginados" :key="juzgado.id">
                            <td class="texto-campo-table">
                                {{juzgado.num_registro}}
                            </td>
                            <td class="texto-campo-table">
                                {{juzgado.nombre}}
                            </td>
                            <!-- <td class="texto-campo-table">
                                {{juzgado.juez}}
                            </td> -->
                            <td class="texto-campo-table">
                                {{juzgado.materia}}
                            </td>
                            <td>
                                <div class="text-center row justify-content-center">
                                    <div>
                                        <v-icon 
                                        title="Editar Juzgado"
                                        @click="EditarJuzgado(juzgado)"
                                        class="mr-1"
                                        >
                                            mdi-text-box-edit-outline
                                        </v-icon>

                                        <v-tooltip
                                            activator="parent"
                                            location="bottom"
                                            >
                                            <span style="font-size: 15px;">Editar Juzgado</span>
                                        </v-tooltip>
                                    </div>
                                    
                                    <div>
                                        <v-icon 
                                            title="Eliminar Juzgado"
                                            @click="eliminarJuzgado(juzgado)"
                                            class="ml-1"
                                        >
                                            mdi-trash-can
                                        </v-icon>
                                        <v-tooltip
                                            activator="parent"
                                            location="bottom"
                                            >
                                            <span style="font-size: 15px;">Eliminar Juzgado</span>
                                        </v-tooltip>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <template v-if="juzgados.length > 0">
                <div class="row justify-content-between container">
                    <div>
                        <p class="text-resultados mt-2">
                            Mostrando
                            <span>{{from}}</span>
                            -
                            <span>{{to}}</span>
                            de
                            <span>{{juzgados.length}}</span>
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

        <!-- modal para agregar juzgado -->
        <v-dialog
            v-model="dialogAgregarJuzgados"
            max-width="700px"
            persistent
            >
            <v-card>
                <v-card-title>
                    <h3>Agregar Juzgado</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formAgregarJuzgado">
                                
                                    <v-text-field
                                        variant="solo"
                                        v-model="juzgado.nombre"
                                        label="Nombre Juzgado"
                                        :rules="juzgadoRules"
                                    ></v-text-field>
                                    <v-text-field
                                        variant="solo"
                                        v-model="juzgado.prefijo"
                                        label="Prefijo"
                                        :rules="prefijoRules"
                                    ></v-text-field>
                                    <v-text-field
                                        variant="solo"
                                        v-model="juzgado.direccion"
                                        label="Dirección"
                                        :rules="direccionRules"
                                    ></v-text-field>
                                   
                                    <v-select
                                    v-model="juzgado.materia_id"
                                            label="Materia"
                                            :items="materias"
                                            item-title="nombre"
                                            item-value="id"
                                            key="materias"
                                            persistent-hint
                                            variant="solo"
                                            :rules="materiaRules"
                                    ></v-select>
                                   
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
                        @click="cancelarAgregarNuevoJuzgado()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        @click="guardarNuevoJuzgado()"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        
        <v-dialog
            v-model="dialogEditarJuzgado"
            max-width="800px"
            persistent
        >
            <v-card>
                <v-card-title>
                    <h3>Editar Juzgado</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formEditarJuzgado">
                                <v-text-field
                                variant="solo"
                                    v-model="juzgado.nombre"
                                    label="Nombre Juzgado"
                                    :rules="juzgadoRules"
                                    
                                ></v-text-field>
                                <v-text-field
                                variant="solo"
                                    v-model="juzgado.prefijo"
                                    label="Prefijo"
                                    :rules="prefijoRules"
                                ></v-text-field>
                                <v-text-field
                                        variant="solo"
                                        v-model="juzgado.direccion"
                                        label="Dirección"
                                        :rules="direccionRules"
                                    ></v-text-field>
                                                             
                                <v-select
                                    v-model="juzgado.materia_id"
                                            label="Materia"
                                            :items="materias"
                                            item-title="nombre"
                                            item-value="id"
                                            key="materias"
                                            persistent-hint
                                            variant="solo"
                                            :rules="materiaRules"
                                ></v-select>

                            </v-form>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="CancelarEditarJuzgado()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        @click="guardarCambiosEditarJuzgado()"
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
                dialogAgregarJuzgados: false,
                dialogEditarJuzgado: false,
                juzgado: {
                    id: null,
                    nombre: '',
                    prefijo: '',
                    direccion: '',
                    materia_id: null,
                   
                },
                loading: false,
                dialogAgregarCentro: false,
                rules:{
                    email: value => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    return pattern.test(value) || 'El campo no contiene un correo electrónico valido'
                    },
                },
                juzgadoRules: [
                    v => !!v || 'El juzgado es requerido',
                ],
                prefijoRules: [
                    v => !!v || 'El prefijo es requerido',
                ],
                direccionRules: [
                    v => !!v || 'La direccion es requerida',
                ],
                materiaRules: [
                    v => !!v || 'La materia es requerida',
                ],
                show1: false,
                password: 'Password',
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
            this.getJuzgados()
            this.getMaterias()
        },
        computed:{
            juzgados(){
                return this.$store.getters.getCatalogoJuzgados
            },
            materias(){
                return this.$store.getters.getMaterias
            },
           
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
                    this.datosPaginados = this.juzgados.filter(item => {
                        return item.nombre.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.centro_atencion.toLowerCase().includes(this.buscar.toLowerCase())
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
                            this.$store.commit('setCatalogoJuzgados', response.data.juzgados)
                            this.mostrar = true
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
            async getMaterias() {
                try {
                    let response = await axios.get('/api/juzgados-materias')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setMaterias', response.data.materias)
                            // this.mostrar = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener las materias.')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener las materias.')
                }
            },
            // Abrir modal nuevo juzgado
            AgregarJuzgado() {
                this.dialogAgregarJuzgados = true
            },
            //Cerrar modal nuevo juzgado
            cancelarAgregarNuevoJuzgado() {
                this.dialogAgregarJuzgados = false
                this.juzgado.nombre = ''
                this.juzgado.prefijo = ''
                this.juzgado.direccion = ''
                this.juzgado.materia_id = null

            },
            // Guardar nuevo juzgado 
            async guardarNuevoJuzgado() {
                const { valid } = await this.$refs.formAgregarJuzgado.validate()
                if (valid) {
                    Swal.fire({
                        title: '¿Guardar nuevo juzgado?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {
                                let response = await axios.post('/api/guardar-juzgado', this.juzgado)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar al nuevo juzgado.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoJuzgados', result.value.data.juzgados)
                                    this.cancelarAgregarNuevoJuzgado()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar al nuevo juzgado.')
                            }
                        }
                    })
                }
            },
            // Abrir modal de editar juzgado ya con los datos cargados
            EditarJuzgado(juzgado) {
                this.dialogEditarJuzgado = true
                this.juzgado.id = juzgado.id
                this.juzgado.nombre = juzgado.nombre
                this.juzgado.prefijo = juzgado.prefijo
                this.juzgado.direccion = juzgado.direccion
                this.juzgado.materia_id = juzgado.materia
            },
            // boton para cerrar el modal
            CancelarEditarJuzgado() {
                this.dialogEditarJuzgado = false
                this.juzgado.id = null,
                this.juzgado.nombre = ''
                this.juzgado.prefijo = ''
                this.juzgado.direccion = ''
                this.juzgado.materia_id = null
            },
            // Guardar Cambios de juzgado 
            async guardarCambiosEditarJuzgado() {
                const { valid } = await this.$refs.formEditarJuzgado.validate()
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
                                let response = await axios.post('/api/actualizar-juzgado', this.juzgado)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del juzgado.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoJuzgados', result.value.data.juzgados)
                                    this.CancelarEditarJuzgado()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del juzgado.')
                            }
                        }
                    })
                }
            },
            // "elimina" cambia estatus del juzgado 
            eliminarJuzgado(juzgado) {
                Swal.fire({
                  title: '¿Eliminar Juzgado?',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085D6',
                  cancelButtonColor: '#D33',
                  confirmButtonText: 'Si, eliminar',
                  cancelButtonText: 'Cancelar',
                  showLoaderOnConfirm: true,
                  preConfirm: async () => {
                      try {
                          let response = await axios.post('/api/eliminar-juzgado', juzgado)
                          return response
                      } catch (error) {
                          errorSweetAlert('Ocurrió un error al eliminar este juzgado.')
                      }
                  },
                  allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                  if (result.isConfirmed) {
                      if (result.value.status === 200) {
                          if (result.value.data.status === "ok") {
                              successSweetAlert(result.value.data.message)
                              this.$store.commit('setCatalogoJuzgados', result.value.data.juzgados)
                              this.CancelarEditarJuzgado()
                              this.getDataPagina(1)
                          } else {
                              errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                          }
                      } else {
                          errorSweetAlert('Ocurrió un error al eliminar este juzgado.')
                      }
                  }
              })

            },
         
            totalPaginas() {
                return Math.ceil(this.juzgados.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.juzgados[index]) {
                        this.datosPaginados.push(this.juzgados[index])
                    }
                }

                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.juzgados.length
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