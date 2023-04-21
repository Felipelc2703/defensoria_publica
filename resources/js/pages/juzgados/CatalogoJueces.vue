<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Jueces</h2>
            <div>
                <v-btn
                    color="#6a73a0"
                    class="mt-4 mb-2 boton-nuevo"
                    large
                    title="Nuevo Usuario"
                    @click="Agregarusuario"
                    append-icon="mdi-plus"
                    >
                    Nuevo Usuario
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
                            <th class="titulo-columna">Usuario</th>
                            <th class="titulo-columna">Juez</th>
                            <th class="titulo-columna">Juzgado</th>
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
                        <tr v-else v-for="usuario in datosPaginados" :key="usuario.id">
                            <td class="texto-campo-table">
                                {{usuario.numero_registro}}
                            </td>
                            <td class="texto-campo-table">
                                {{usuario.nombre}}
                            </td>
                            <td class="texto-campo-table">
                                {{usuario.juez}}
                            </td>
                            <td class="texto-campo-table">
                                {{usuario.juzgado}}
                            </td>
                            <td>
                                <div class="text-center row justify-content-center">
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
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <template v-if="usuarios.length > 0">
                <div class="row justify-content-between container">
                    <div>
                        <p class="text-resultados mt-2">
                            Mostrando
                            <span>{{from}}</span>
                            -
                            <span>{{to}}</span>
                            de
                            <span>{{usuarios.length}}</span>
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

        <!-- modal para agregar usuario -->
        <v-dialog
            v-model="dialogAgregarUsuarios"
            max-width="700px"
            persistent
            >
            <v-card>
                <v-card-title>
                    <h3>Agregar Usuario</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formAgregarUsuario">
                                
                                    <v-text-field
                                        variant="solo"
                                        v-model="usuario.nombre"
                                        label="Nombre Usuario"
                                    ></v-text-field>
                                    <v-text-field
                                        variant="solo"
                                        v-model="usuario.clave"
                                        label="Clave Usuario"
                                    ></v-text-field>
                                    <v-text-field
                                        variant="solo"
                                        v-model="usuario.email"
                                        :rules="[rules.email]"
                                        label="Correo Electrónico"
                                    ></v-text-field>
                                    <v-text-field
                                        variant="solo"
                                        v-model="usuario.contrasena"
                                        label="Contraseña"
                                    ></v-text-field>
                                    <v-text-field
                                        variant="solo"
                                        v-model="usuario.conf_contra"
                                        label="Confirmar Contraseña"
                                    ></v-text-field>
                                    <v-select
                                    v-model="usuario.rol_id"
                                            label="Roles*"
                                            :items="roles"
                                            item-title="nombre"
                                            item-value="rol_id"
                                            key="roles"
                                            persistent-hint
                                            variant="solo"
                                    ></v-select>
                                    <!-- <v-select
                                            v-model="usuario.centro_atencion"
                                            label="Centro de atención*"
                                            :items="centrosAtencion"
                                            item-title="nombre"
                                            item-value="id"
                                            key="centrosAtencion"
                                            persistent-hint
                                            variant="solo"
                                        ></v-select> -->
                                    <v-select
                                        v-model="usuario.juzgado_id"
                                        label="Juzgado*"
                                        :items="juzgados"
                                        item-title="nombre"
                                        item-value="id"
                                        key="juzgados"
                                        persistent-hint
                                        variant="solo"
                                        :rules="juzgadoRules"
                                    ></v-select>
                                    <v-select
                                        v-if="usuario.juzgado_id != null"
                                        v-model="usuario.juez_id"
                                        label="Juez*"
                                        :items="jueces"
                                        item-title="nombre_completo"
                                        item-value="id"
                                        key="jueces"
                                        persistent-hint
                                        variant="solo"
                                        :rules="juezRules"
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
                        @click="cancelarAgregarNuevoUsuario()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        @click="guardarNuevoUsuario()"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        
        <v-dialog
            v-model="dialogEditarUsuario"
            max-width="800px"
            persistent
        >
            <v-card>
                <v-card-title>
                    <h3>Editar Usuario</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formEditarUsuario">
                                <v-text-field
                                    v-model="usuario.nombre"
                                    label="Nombre Usuario"
                                ></v-text-field>
                                <v-text-field
                                    v-model="usuario.clave"
                                    label="Clave Usuario"
                                ></v-text-field>
                                <v-text-field
                                    v-model="usuario.email"
                                    label="Correo Electrónico"
                                ></v-text-field>
                                
                                <v-text-field
                                    variant="underlined"
                                    v-model="usuario.contrasena"
                                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="show1 ? 'text': 'Password'"
                                    name="input-10-1"
                                    label="Mostrar contraseña"
                                    @click:append="show1 = !show1"
                                ></v-text-field>

                                <v-select
                                    v-model="usuario.rol_id"
                                            label="Roles*"
                                            :items="roles"
                                            item-title="nombre"
                                            item-value="rol_id"
                                            key="roles"
                                            persistent-hint
                                            variant="solo"
                                ></v-select>

                                <!-- <v-select
                                    v-model="usuario.centro_atencion"
                                    label="Centro de atención*"
                                    :items="centrosAtencion"
                                    item-title="nombre"
                                    item-value="id"
                                    key="centrosAtencion"
                                    persistent-hint
                                    variant="solo"
                                ></v-select>  -->
                                
                                <v-select
                                    v-model="usuario.juzgado_id"
                                    label="Juzgado*"
                                    :items="juzgados"
                                    item-title="nombre"
                                    item-value="id"
                                    key="juzgados"
                                    persistent-hint
                                    variant="solo"
                                    :rules="juzgadoRules"
                                ></v-select>
                                <v-select
                                    v-if="usuario.juzgado_id != null"
                                    v-model="usuario.juez_id"
                                    label="Juez*"
                                    :items="jueces"
                                    item-title="nombre_completo"
                                    item-value="id"
                                    key="jueces"
                                    persistent-hint
                                    variant="solo"
                                    :rules="juezRules"
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
                        @click="CancelarEditarUsuario()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="#A3BC39"
                        @click="guardarCambiosEditarUsuario()"
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
                dialogAgregarUsuarios: false,
                dialogEditarUsuario: false,
                usuario: {
                    id: null,
                    nombre: '',
                    clave: '',
                    email: '',
                    contrasena: '',
                    conf_contra: '',
                    rol_id: '',
                    juzgado_id: null,
                    juez_id: null,
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
                juezRules: [
                    v => !!v || 'El juez es requerido',
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
                jueces: [],
            }
        },
        created(){
            this.getCatalogoUsuarios()
            this.getCentrosAtencion()
            this.getRoles()
        },
        computed:{
            usuarios(){
                return this.$store.getters.getCatalogoUsuarios
            },
            centrosAtencion() {
                if (this.loading) {
                    return []
                } else {
                    return this.$store.getters.getCatalogoCentrosAtencion
                }
            },
            roles() {
                if (this.loading) {
                    return []
                } else {
                    return this.$store.getters.getCatalogoRoles
                }
            },
            pages() {
                const numShown = Math.min(this.numShown, this.totalPaginas())
                let first = this.current - Math.floor(numShown / 2)
                first = Math.max(first, 1)
                first = Math.min(first, this.totalPaginas() - numShown + 1)
                return [...Array(numShown)].map((k, i) => i + first)
            },
            juzgados() {
                return this.$store.getters.getCatalogoJuzgados
            }
        },
        watch: {
            'usuario.juzgado_id': function () {
                this.jueces = []
                this.juzgados.forEach(e => {
                    if (this.usuario.juzgado_id == e.id) {
                        this.jueces = e.jueces
                    }
                })
            },
            buscar: function () {
                if (!this.buscar.length == 0) {
                    this.datosPaginados = this.usuarios.filter(item => {
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
            // Abrir modal nuevo usuario
            Agregarusuario() {
                this.dialogAgregarUsuarios = true
            },
            //Cerrar modal nuevo usuario
            cancelarAgregarNuevoUsuario() {
                this.dialogAgregarUsuarios = false
                this.usuario.nombre = ''
                this.usuario.clave = ''
                this.usuario.email = ''
                this.usuario.contrasena = ''
                this.usuario.conf_contra = ''
                this.usuario.rol = ''
                this.usuario.juzgado_id = null
                this.usuario.juez_id = null

            },
            // Guardar nuevo usuario 
            async guardarNuevoUsuario() {
                const { valid } = await this.$refs.formAgregarUsuario.validate()
                if (valid) {
                    Swal.fire({
                        title: '¿Guardar nuevo usuario?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {
                                let response = await axios.post('/api/usuarios/agregar-usuario', this.usuario)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar al nuevo usuario.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoUsuarios', result.value.data.usuarios)
                                    this.cancelarAgregarNuevoUsuario()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar al nuevo usuario.')
                            }
                        }
                    })
                }
            },
            // Abrir modal de editar usuario ya con los datos cargados
            EditarUsuario(usuario) {
                this.dialogEditarUsuario = true
                this.usuario.id = usuario.id
                this.usuario.nombre = usuario.nombre
                this.usuario.clave = usuario.clave
                this.usuario.email = usuario.email
                this.usuario.contrasena = usuario.contrasena
                this.usuario.rol_id = usuario.rol_id
                this.usuario.juzgado_id = usuario.juzgado_id
                this.usuario.juez_id = usuario.juez_id
            },
            // boton para cerrar el modal
            CancelarEditarUsuario() {
                this.dialogEditarUsuario = false
                this.usuario.id = null,
                this.usuario.nombre = ''
                this.usuario.clave = ''
                this.usuario.email = ''
                this.usuario.contrasena = ''
                this.usuario.rol_id = ''
                this.usuario.centro_atencion = ''
                this.usuario.juez_id = null
                this.usuario.juzgado_id = null
            },
            // Guardar Cambios de usuario 
            async guardarCambiosEditarUsuario() {
                const { valid } = await this.$refs.formEditarUsuario.validate()
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
                                let response = await axios.post('/api/usuarios/actualizar-usuario', this.usuario)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del usuario.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoUsuarios', result.value.data.usuarios)
                                    this.CancelarEditarUsuario()
                                    this.getDataPagina(1)
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar los datos del usuario.')
                            }
                        }
                    })
                }
            },
            // "elimina" cambia estatus del usuario 
            eliminarUsuario(usuario) {
                Swal.fire({
                  title: '¿Eliminar Usuario?',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085D6',
                  cancelButtonColor: '#D33',
                  confirmButtonText: 'Si, eliminar',
                  cancelButtonText: 'Cancelar',
                  showLoaderOnConfirm: true,
                  preConfirm: async () => {
                      try {
                          let response = await axios.post('/api/usuarios/eliminar-usuario', usuario)
                          return response
                      } catch (error) {
                          errorSweetAlert('Ocurrió un error al eliminar este usuario.')
                      }
                  },
                  allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                  if (result.isConfirmed) {
                      if (result.value.status === 200) {
                          if (result.value.data.status === "ok") {
                              successSweetAlert(result.value.data.message)
                              this.$store.commit('setCatalogoUsuarios', result.value.data.usuarios)
                              this.CancelarEditarUsuario()
                              this.getDataPagina(1)
                          } else {
                              errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                          }
                      } else {
                          errorSweetAlert('Ocurrió un error al eliminar este usuario.')
                      }
                  }
              })

            },
            // para mostrar los datos en la tabla principal
            async getCatalogoUsuarios() {
                this.loading = true
                try {
                    let response = await axios.get('/api/catalogos/usuarios')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCatalogoUsuarios', response.data.usuarios)
                            this.mostrar = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catálogo de usuarios')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catálogo de usuarios')
                }
                this.loading = false
          },

          // catalogo de centros de atención para el select
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
                        errorSweetAlert('Ocurrió un error al obtener el catálogo de centros de atención')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catálogo de centros de atención')
                }
                this.loading = false
            },
            // catalogo de roles para el select 
            async getRoles() {
                this.loading = true
                try {
                    let response = await axios.get('/api/catalogos/roles')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCatalogoRoles', response.data.roles)
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catálogo de roles')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catálogo de roles')
                }
                this.loading = false
            },
            totalPaginas() {
                return Math.ceil(this.usuarios.length / this.elementosPorPagina)
            },
            getDataPagina(noPagina) {
                this.paginaActual = noPagina
                this.datosPaginados = []

                let ini = (noPagina * this.elementosPorPagina) - this.elementosPorPagina
                let fin = (noPagina * this.elementosPorPagina)

                for (let index = ini; index < fin; index++) {
                    if (this.usuarios[index]) {
                        this.datosPaginados.push(this.usuarios[index])
                    }
                }

                // Para el texto "Mostrando 1 - 10 de 20 resultados"
                this.from = ini+1
                if (noPagina < this.totalPaginas()) {
                    this.to = fin
                } else {
                    this.to = this.usuarios.length
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