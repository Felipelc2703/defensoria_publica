<template>
    <div class="container my-6">
        <div class="text-center my-6">
            <h2>TRAMITES</h2>
            <v-btn
                large
                title="Nuevo Tramite"
                @click="agregarTramite">
                <v-icon size="30" x-large icon="mdi-pencil-box-outline"></v-icon>
            </v-btn>
        </div>
        <div class="my-6 px-4 py-4">
            <EasyDataTable
                class="mb-6"
                :headers="headers"
                :items="tramites"
                alternating
                >
                <template #item-actions="tramite">
                    <v-icon 
                      title="Editar Tramite"
                      @click="editarTramite(tramite)"
                      class="mr-1"
                    >
                        mdi-text-box-edit-outline
                    </v-icon>
                    <v-icon 
                        title="Eliminar Tramite"
                        @click="eliminarTramite(tramite)"
                        class="ml-1"
                    >
                        mdi-trash-can
                    </v-icon>
                </template>
            </EasyDataTable>
        </div>

        <v-dialog
            v-model="dialogAgregarTramite"
            max-width="800px"
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
                    tipo_tramite_id: ''
                },
                headers: [
                    {
                        text: 'Nombre tramite', value: 'nombre'
                    },
                    {
                        text: 'Descripcion Corta', value: 'descripcion'
                    },
                    {
                        text: 'Acciones', value:'actions'
                    }
                ],
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
                            //   console.log($response.data.requisitos)
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
                this.tramite.id = tramite.id
                this.tramite.nombre = tramite.nombre
                this.tramite.descripcion = tramite.descripcion
                this.tramite.url = tramite.url_informacion
                this.tramite.tipo_tramite_id = tramite.tipo_tramite_id
                this.dialogEditarTramite = true
            },
            cancelarEditartramite() {
                this.tramite.id = null
                this.tramite.nombre = ''
                this.tramite.descripcion = ''
                this.tramite.url = ''
                this.tramite.tipo_tramite_id = ''
                this.dialogEditarTramite = false
            },
            async  guardarCambiosTramite()
            {
                const { valid } = await this.$refs.formEditarTramite.validate()
                //   console.log(this.requisito)
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
                                let response = await axios.post('/api/tramite/actualizar-tramite', this.tramite)
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

            },
        }


    })
</script>