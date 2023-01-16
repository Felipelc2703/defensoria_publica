<template>
    <div class="container my-6">
        <div class="text-center my-6">
            <h2>Tramites</h2>
            <div>
                <v-btn
                    color="#6a73a0"
                    class="mt-4 mb-2 boton-nuevo"
                    large
                    title="Nuevo Tramite"
                    @click="agregarTramite"
                    append-icon="mdi-plus"
                    >
                    Nuevo Tramite
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
                            <th class="titulo-columna">Descripción Corta</th>
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
                        <tr v-else v-for="tramite in datosPaginados" :key="tramite.id">
                            <td class="texto-campo-table">
                                {{tramite.numero_registro}}
                            </td>
                            <td class="texto-campo-table">
                                {{tramite.nombre}}
                            </td>
                            <td class="texto-campo-table">
                                {{tramite.descripcion}}
                            </td>
                            <td>
                                <div class="text-center row justify-content-center">
                                    <div>
                                        <v-icon 
                                            title="Editar Tramite"
                                            @click="editarTramite(tramite)"
                                            class="mr-1"
                                            >
                                            mdi-text-box-edit-outline
                                        </v-icon>

                                        <v-tooltip
                                            activator="parent"
                                            location="bottom"
                                            >
                                            <span style="font-size: 15px;">Editar dsdsdsdsd</span>
                                        </v-tooltip>
                                    </div>
                                    
                                    <div>
                                        <v-icon 
                                            title="Eliminar Tramite"
                                            @click="eliminarTramite(tramite)"
                                            class="ml-1"
                                        >
                                            mdi-trash-can
                                        </v-icon>
                                        <v-tooltip
                                            activator="parent"
                                            location="bottom"
                                            >
                                            <span style="font-size: 15px;">Eliminar Tramite</span>
                                        </v-tooltip>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <template v-if="tramites.length > 0">
                <div class="row justify-content-between container">
                    <div>
                        <p class="text-resultados mt-2">
                            Mostrando
                            <span>{{from}}</span>
                            -
                            <span>{{to}}</span>
                            de
                            <span>{{tramites.length}}</span>
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
            v-model="dialogAgregarTramite"
            max-width="1200px"
            persistent
            >

            <v-card>
                <v-card-title>
                  <h3>Agregar Tramite</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formAgregarTramite">
                            
                                <v-text-field
                                    variant="solo"
                                    v-model="tramite.nombre"
                                    type="text" 
                                    label="Nombre Tramite*"
                                ></v-text-field>

                                <v-textarea 
                                    v-model="tramite.descripcion"
                                    label="Descripcion Corta*" 
                                    variant="solo">
                                </v-textarea>

                                <v-text-fild
                                    variant="solo"
                                    v-model="tramite.url"
                                    type="text"
                                    label="Url donde se encuntra la informacion dle tramite (iniciando con http://)*">
                                </v-text-fild>

                                <v-select
                                    v-model="tramite.tipo_tramite_id"
                                    label="Tipo de tramite*"
                                    :items="tiposTramite"
                                    item-title="nombre"
                                    item-value="id"
                                    key="tiposTramite"
                                    persistent-hint
                                    variant="solo"
                                ></v-select>

                                <table>
                                    <tr>
                                        <th>Requisito</th>
                                        <th>Obligatorio *</th>
                                    </tr>
                                    <tr v-for="(requisito, index) in requisitosTipoTramite" :key="index">
                                        <td><input type="checkbox" :value="requisito.id" v-model="tramite.requisitos" :id="`check_${index}`">  <label :for="`check_${index}`">{{requisito.nombre}}</label></td>
                                        <td><input type="checkbox" :value="requisito.id" v-model="tramite.obligatorios" :id="`check_${index}`"></td>
                                    </tr>
                                </table>
                            </v-form>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="warning"
                        @click="cancelarAgregarTramite()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="guardarNuevoTramite()"
                    >
                        Guardar
                    </v-btn>
              </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog
            v-model="dialogEditarTramite"
            max-width="800px"
            persistent
            >

            <v-card>
                <v-card-title>
                  <h3>Editar Tramite</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formEditarTramite">
                            
                                <v-text-field
                                    variant="solo"
                                    v-model="modelEditarTramite.nombre"
                                    type="text" 
                                    label="Nombre Tramite*"
                                ></v-text-field>

                                <v-textarea 
                                    v-model="modelEditarTramite.descripcion"
                                    label="Descripcion Corta*" 
                                    variant="solo">
                                </v-textarea>

                                <v-text-fild
                                    variant="solo"
                                    v-model="modelEditarTramite.url"
                                    type="text"
                                    label="Url donde se encuntra la informacion dle tramite (iniciando con http://)*">
                                </v-text-fild>

                                <v-select
                                    v-model="modelEditarTramite.tipo_tramite_id"
                                    label="Tipo de tramite*"
                                    :items="tiposTramite"
                                    item-title="nombre"
                                    item-value="id"
                                    key="tiposTramite"
                                    persistent-hint
                                    variant="solo"
                                ></v-select>

                                <table>
                                    <tr>
                                        <th>Requisito</th>
                                        <th>Obligatorio *</th>
                                    </tr>
                                    <tr v-for="(requisito, index) in requisitosTipoTramite" :key="index">
                                        <td><input type="checkbox" :value="requisito.id" v-model="modelEditarTramite.requisitos" :id="`check_${index}`">  <label :for="`check_${index}`">{{requisito.nombre}}</label></td>
                                        <td><input type="checkbox" :value="requisito.id" v-model="modelEditarTramite.obligatorios" :id="`check_${index}`"></td>
                                    </tr>
                                </table>

                            </v-form>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="warning"
                        @click="cancelarEditartramite()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="guardarCambiosTramite()"
                    >
                        Guardar
                    </v-btn>
              </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"

    export default defineComponent({
        name:'catalogo-tramites',
        data() {
            return {
                dialogAgregarTramite: false,
                dialogEditarTramite: false,
                loading: false,
                tramite: {
                    id: null,
                    nombre: '',
                    descripcion: '',
                    url: '',
                    tipo_tramite_id: '',
                    requisitos: [],
                    obligatorios: [],
                },
                modelEditarTramite: {
                    id: null,
                    nombre: '',
                    descripcion: '',
                    url: '',
                    tipo_tramite_id: '',
                    requisitos: [],
                    obligatorios: [],
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
                requisitosEditar: [],
            }
        },
        created() {
            this.getCatalogoTramites()
            this.getTiposTramite();
        },
        computed: {
            tramites() {
                return this.$store.getters.getCatalogoTramites
            },
            tiposTramite() {
                return this.$store.getters.getCatalogoTiposTramites
            },
            requisitosTipoTramite() {
                return this.$store.getters.getRequisitosTipoTramite
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
            'tramite.tipo_tramite_id': function () {
                this.getRequisitos(this.tramite)
            },

            'modelEditarTramite.tipo_tramite_id': function () {
                this.getRequisitos(this.modelEditarTramite)
            },
            buscar: function () {
                if (!this.buscar.length == 0) {
                    this.datosPaginados = this.tramites.filter(item => {
                        return item.nombre.toLowerCase().includes(this.buscar.toLowerCase())
                        || item.descripcion.toLowerCase().includes(this.buscar.toLowerCase())
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
            agregarTramite() {
              this.dialogAgregarTramite = true
            },
            cancelarAgregarTramite() {
                this.dialogAgregarTramite = false
                this.tramite.nombre = '',
                this.tramite.descripcion = '',
                this.tramite.url = '',
                this.tramite.tipo_tramite_id
            },
            async getCatalogoTramites() {
                this.loading = true
                try {
                    let response = await axios.get('/api/catalogos/tramites')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCatalogoTramites', response.data.tramites)
                            this.mostrar = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catalogo de tramites')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catalogo de tramites')
                }
                this.loading = false
            },
            async getTiposTramite() {
              try {
                  let response = await axios.get('/api/catalogos/tipos-de-tramite')
                  if (response.status === 200) {
                      if (response.data.status === "ok") {
                          this.$store.commit('setCatalogoTiposTramites', response.data.tiposTramites)
                      } else {
                          errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                      }
                  } else {
                      errorSweetAlert('Ocurrió un error al obtener el catalogo de tipos de tramites')
                  }
              } catch (error) {
                  errorSweetAlert('Ocurrió un error al obtener el catalogo de tipos de tramites')
              }
            },
            
            async guardarNuevoTramite() {
                console.log(this.tramite)
                const { valid } = await this.$refs.formAgregarTramite.validate()
                if (valid) {
                    Swal.fire({
                        title: '¿Guardar nuevo tramite?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {
                                let response = await axios.post('/api/tramite/guardar-nuevo', this.tramite)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar nuevo tramite.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoTramites', result.value.data.tramites)
                                    this.cancelarAgregarTramite()
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar nuevo tramite.')
                            }
                        }
                    })
                }
            },
            editarTramite(tramite)
            {
                this.modelEditarTramite.id = tramite.id
                this.modelEditarTramite.nombre = tramite.nombre
                this.modelEditarTramite.descripcion = tramite.descripcion
                this.modelEditarTramite.url = tramite.url_informacion
                this.modelEditarTramite.tipo_tramite_id = tramite.tipo_tramite_id
                this.dialogEditarTramite = true
            },
            cancelarEditartramite() {
                this.modelEditarTramite.id = null
                this.modelEditarTramite.nombre = ''
                this.modelEditarTramite.descripcion = ''
                this.modelEditarTramite.url = ''
                this.modelEditarTramite.tipo_tramite_id = ''
                this.modelEditarTramite.requisitos = []
                this.modelEditarTramite.obligatorios = []
                this.dialogEditarTramite = false
            },
            async guardarCambiosTramite()
            {
                console.log(this.modelEditarTramite)
                const { valid } = await this.$refs.formEditarTramite.validate()
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
                                let response = await axios.post('/api/tramite/actualizar-tramite', this.modelEditarTramite)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar tramite.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoTramites', result.value.data.tramites)
                                    this.cancelarEditartramite()
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar tramite.')
                            }
                        }
                    })
                }
            },
            async getRequisitos(tram)
            {
                console.log("iohdsiusdhbdsiuodsio")
                try {
                  let response = await axios.post('/api/tramite/requisitos-tipo-tramite', tram)
                  if (response.status === 200) {
                      if (response.data.status === "ok") {
                          this.$store.commit('setRequisitosTipoTramite', response.data.requisitos)
                          this.modelEditarTramite.requisitos = response.data.seleccionados
                          this.modelEditarTramite.obligatorios = response.data.obligatorios

                      } else {
                          errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                      }
                  } else {
                      errorSweetAlert('Ocurrió un error al obtener los tramiotes asociados')
                  }
              } catch (error) {
                errorSweetAlert('Ocurrió un error al obtener los tramiotes asociados')
              }
            },


            async getRequisitosEditar() {
                try {
                  let response = await axios.post('/api/tramite/requisitos-tipo-tramite-editar', this.modelEditarTramite)
                  if (response.status === 200) {
                      if (response.data.status === "ok") {
                        //   this.$store.commit('setRequisitosTipoTramite', response.data.requisitos)
                        this.requisitosEditar = response.data.requisitos
                        this.modelEditarTramite.requisitos = response.data.req_seleccionados
                        this.modelEditarTramite.obligatorios = response.data.obligatorios

                        console.log(this.requisitosEditar)
                      } else {
                          errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                      }
                  } else {
                      errorSweetAlert('Ocurrió un error al obtener los tramiotes asociados')
                  }
              } catch (error) {
                errorSweetAlert('Ocurrió un error al obtener los tramiotes asociados')
              }
            },



            totalPaginas() {
                return Math.ceil(this.tramites.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.tramites[index]) {
                        this.datosPaginados.push(this.tramites[index])
                    }
                }

                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.tramites.length
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
            eliminarTramite(tramite) {
                Swal.fire({
                  title: '¿Eliminar Tramite?',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085D6',
                  cancelButtonColor: '#D33',
                  confirmButtonText: 'Si, eliminar',
                  cancelButtonText: 'Cancelar',
                  showLoaderOnConfirm: true,
                  preConfirm: async () => {
                      try {
                          let response = await axios.post('/api/tramite/eliminar-tramite', tramite)
                          return response
                      } catch (error) {
                          errorSweetAlert('Ocurrió un error al eliminar este tramite.')
                      }
                  },
                  allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                  if (result.isConfirmed) {
                      if (result.value.status === 200) {
                          if (result.value.data.status === "ok") {
                              successSweetAlert(result.value.data.message)
                              this.$store.commit('setCatalogoUsuarios', result.value.data.tramites)
                              this.cancelarEditartramite()
                          } else {
                              errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                          }
                      } else {
                          errorSweetAlert('Ocurrió un error al eliminar este tramite.')
                      }
                  }
              })
            }
        }
    })
</script>