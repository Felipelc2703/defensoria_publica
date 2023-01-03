<template>
    <div class="container my-6">
        <div class="text-center my-6">
            <h2>USUARIOS</h2>
            <v-btn class="mb-4"
                large
                title="Nuevo Usuario"
                @click="Agregarusuario" >
                <v-icon size="30" x-large icon="mdi-pencil-box-outline"></v-icon>
            </v-btn>
        </div>
        <div class="my-6 px-4 py-4">
            <EasyDataTable 
                class="mb-6"
                :headers="headers" 
                :items="usuarios"
                alternating
            >
                <template #item-actions="usuario">                        
                        <v-icon
                            title="Editar Usuario"
                            @click="EditarUsuario(usuario)"
                            class="mr-1" 
                        >
                            mdi-text-box-edit-outline
                        </v-icon>
                        <v-icon
                            title="Eliminar usuario"  
                            @click="eliminarUsuario(usuario)"
                            class="ml-1"
                        >
                            mdi-trash-can
                        </v-icon>
                </template>
            </EasyDataTable>
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
                                        label="Correo Electronico"
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
                                    <v-select
                                            v-model="usuario.centro_atencion"
                                            label="Centro de atención*"
                                            :items="centrosAtencion"
                                            item-title="nombre"
                                            item-value="id"
                                            key="centrosAtencion"
                                            persistent-hint
                                            variant="solo"
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
                        color="warning"
                        @click="cancelarAgregarNuevoUsuario()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
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
                                    label="Correo Electronico"
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

                                <v-select
                                    v-model="usuario.centro_atencion"
                                    label="Centro de atención*"
                                    :items="centrosAtencion"
                                    item-title="nombre"
                                    item-value="id"
                                    key="centrosAtencion"
                                    persistent-hint
                                    variant="solo"
                                ></v-select> 
                                
                            </v-form>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="warning"
                        @click="CancelarEditarUsuario()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
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
  import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"
    export default {
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
                            centro_atencion:''
                        },
                        loading: false,
                        headers: [
                        { 
                            text: "USUARIO", value: "nombre" 
                        },
                        { 
                            text: "CENTRO DE ATENCION", value: "centro_atencion"
                        },
                        { 
                            text: 'ACCIONES', value: 'actions'
                        }
                        ],
                        dialogAgregarCentro: false,
                        rules:{
                                email: value => {
                                const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                                return pattern.test(value) || 'El campo no contiene un correo electrónico valido'
                                },
                            },
                            show1: false,
                            password: 'Password',
                    }
        },
        created(){
            this.getCatalogoUsuarios()
            this.getCentrosAtencion()
            this.getRoles()
        },
        computed:{
            usuarios(){
                if (this.loading) {
                return []
            } else {
                return this.$store.getters.getCatalogoUsuarios
            }

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
            }
        },
        methods: {
            // Abrir modal nuevo usuario
            Agregarusuario() {
                console.log('agregar usuario')
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
                this.usuario.centro_atencion= ''

            },
            // Guardar nuevo usuario 
            async guardarNuevoUsuario() {
                console.log(this.usuario)
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
                this.usuario.centro_atencion= usuario.centro_atencion_id

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

            },
            // Guardar Cambios de usuario 
            async guardarCambiosEditarUsuario() {
                //console.log(this.usuario)
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
                           console.log(this.$store.getters.getCatalogoUsuarios)
                           console.log(this.usuarios)
                      } else {
                          errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                      }
                  } else {
                      errorSweetAlert('Ocurrió un error al obtener el catalogo de usuarios')
                  }
              } catch (error) {
                  errorSweetAlert('Ocurrió un error al obtener el catalogo de usuarios')
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
                        errorSweetAlert('Ocurrió un error al obtener el catalogo de centros de atención')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catalogo de centros de atención')
                }
                this.loading = false
            },
            // catalogo de roles para el select 
            async getRoles() {
                console.log(this.usuario)
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
                        errorSweetAlert('Ocurrió un error al obtener el catalogo de roles')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catalogo de roles')
                }
                this.loading = false
            },
        },
    }
</script>