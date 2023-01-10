<template>
    <div class="container mb-6">
        <div class="text-center my-6">
            <h2>Requisitos</h2>
            <div>
                <v-btn
                    color="#6a73a0"
                    class="mt-4 mb-2 boton-nuevo"
                    large
                    title="Nuevo Requisito"
                    @click="agregarRequisito"
                    append-icon="mdi-plus"
                    >
                    Nuevo Requisito
                </v-btn>
            </div>
        </div>

        <div class="my-6 px-4 py-4">
            <EasyDataTable
                class="mb-6"
                :headers="headers" 
                :items="requisitos"
                alternating
            >
                <template #item-actions="requisito">
                    <v-icon 
                        title="Editar Centro"
                        @click="editarRequisito(requisito)"
                        class="mr-1"
                    >
                        mdi-text-box-edit-outline
                    </v-icon>
                    <v-icon 
                        title="Eliminar Centro"
                        @click="eliminarRequisito(requisito)"
                        class="ml-1"
                    >
                        mdi-trash-can
                    </v-icon>
                </template>
            </EasyDataTable>
        </div>

      <v-dialog
          v-model="dialogAgregarRequisito"
          max-width="800px"
          persistent
      >
          <v-card>
              <v-card-title>
                  <h3>Agregar Requisito</h3>
              </v-card-title>
              <v-divider></v-divider>
              <v-card-text>
                  <v-container>
                      <v-row>
                          <v-form class="col-12" ref="formAgregarRequisito">
                            <v-select
                                v-model="requisito.tipo_tramite_id"
                                label="Tipo de tramite asociado al requisito*"
                                :items="tiposTramite"
                                item-title="nombre"
                                item-value="id"
                                key="tiposTramite"
                                persistent-hint
                                variant="solo"
                            ></v-select>
                            <br>
                            <label for="">Nombre del Requisito*</label>
                            <v-text-field
                                variant="solo"
                                v-model="requisito.nombre"
                                type="text" 
                            ></v-text-field>
                          </v-form>
                      </v-row>
                  </v-container>
              </v-card-text>

              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                      variant="flat"
                      color="warning"
                      @click="cancelarAgregarRequisito()"
                  >
                      Cancelar
                  </v-btn>
                  <v-btn
                      variant="flat"
                      color="error"
                      @click="guardarNuevoRequisito()"
                  >
                      Guardar
                  </v-btn>
              </v-card-actions>
          </v-card>
      </v-dialog>

      <v-dialog
          v-model="dialogEditarRequisito"
          max-width="800px"
          persistent
      >
          <v-card>
              <v-card-title>
                  <h3>Editar Requisito</h3>
              </v-card-title>
              <v-divider></v-divider>
              <v-card-text>
                  <v-container>
                      <v-row>
                          <v-form class="col-12" ref="formeditarRequisito">
                            
                            <v-select
                                v-model="requisito.tipo_tramite_id"
                                label="Por favor selecciona el tipo de carpeta"
                                :items="tiposTramite"
                                item-title="nombre"
                                item-value="id"
                                variant="solo"
                            ></v-select>
                            <br>
                            <label for="">Nombre del Requisito*</label>
                            <v-text-field
                                variant="solo"
                                v-model="requisito.nombre"
                                type="text" 
                            ></v-text-field>
                          </v-form>
                      </v-row>
                  </v-container>
              </v-card-text>

              <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                      variant="flat"
                      color="warning"
                      @click="cancelarEditarCentroAtencion()"
                  >
                      Cancelar
                  </v-btn>
                  <v-btn
                      variant="flat"
                      color="error"
                      @click="guardarCambiosRequisito()"
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
      name: 'catalogo-requisitos',
      data() {
        return {
            dialogAgregarRequisito: false,
            dialogEditarRequisito: false,
            loading: false,
            requisito: {
                id: null,
                tipo_tramite_id:'',
                nombre:'',
                // req_padre: '',
            },  
            headers: [
                { 
                    text: 'Requisito', value: 'nombre'
                },
                { 
                    text: 'Requisito Padre', value: 'direccion'
                },
                { 
                    text: 'Acciones', value: 'actions'
                }
            ],
            nombreRules: [
                v => !!v || 'El nombre del centro de atención es requerido'
            ],
            direccionRules: [
                v => !!v || 'La dirección del centro de atención es requerida'
            ],
        }
        },
      created() {
          this.getCatalogoRequisitos()
          this.getTiposTramite();
      },
      computed: {
        centrosAtencion() {
            if (this.loading) {
                return []
            } else {
                return this.$store.getters.getCatalogoCentrosAtencion
            }
        },
        requisitos() {
            if (this.loading) {
                return []
            } else {
                return this.$store.getters.getCatalogoRequisitos
            }
        },
        tiposTramite() {
            return this.$store.getters.getCatalogoTiposTramites
        }
      },
      methods: {
            //Obtiene el catalogo de requisitos
          async getCatalogoRequisitos() {
              this.loading = true
              try {
                  let response = await axios.get('/api/catalogos/requisitos')
                  if (response.status === 200) {
                      if (response.data.status === "ok") {
                          this.$store.commit('setCatalogoRequisitos', response.data.requisitos)
                        //   console.log($response.data.requisitos)
                      } else {
                          errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                      }
                  } else {
                      errorSweetAlert('Ocurrió un error al obtener el catalogo de requisitos')
                  }
              } catch (error) {
                  errorSweetAlert('Ocurrió un error al obtener el catalogo de requisitos')
              }
              this.loading = false
          },
          // Abrir modal nuevo centro de atencion
          agregarRequisito() {
              this.dialogAgregarRequisito = true
          },
          // Cerrar modal nuevo centro de atencion
          cancelarAgregarRequisito() {
              this.dialogAgregarRequisito = false
              this.requisito.tipo_tramite_id = '',
              this.requisito.nombre = '',
              this.requisito.req_padre = ''
          },
          // Guarda un nuevo centro de atencion
          async guardarNuevoRequisito() {
              const { valid } = await this.$refs.formAgregarRequisito.validate()
              if (valid) {
                  Swal.fire({
                      title: '¿Guardar nuevo requisito?',
                      icon: 'question',
                      showCancelButton: true,
                      confirmButtonColor: '#3085D6',
                      cancelButtonColor: '#D33',
                      confirmButtonText: 'Si, guardar',
                      cancelButtonText: 'Cancelar',
                      showLoaderOnConfirm: true,
                      preConfirm: async () => {
                          try {
                              let response = await axios.post('/api/requisito/guardar-nuevo', this.requisito)
                              return response
                          } catch (error) {
                              errorSweetAlert('Ocurrió un error al guardar nuevo requisito.')
                          }
                      },
                      allowOutsideClick: () => !Swal.isLoading()
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if (result.value.status === 200) {
                              if (result.value.data.status === "ok") {
                                  successSweetAlert(result.value.data.message)
                                  this.$store.commit('setCatalogoRequisitos', result.value.data.requisitos)
                                  this.cancelarAgregarRequisito()
                              } else {
                                  errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                              }
                          } else {
                              errorSweetAlert('Ocurrió un error al guardar nuevo requisito.')
                          }
                      }
                  })
              }
          },
          // Abrir modal editar centro de atencion
          editarRequisito(req) {
            // console.log(req)

            this.requisito.id = req.id
            this.requisito.tipo_tramite_id = req.tipo_tramite
            this.requisito.nombre = req.nombre
            // this.requisito.req_padre = req.req_padre
            this.dialogEditarRequisito = true

            console.log(this.requisito  )
          },
          // Cerrar modal editar centro de atencion
          cancelarEditarCentroAtencion() {
              this.dialogEditarRequisito = false
            //   this.centro.id = null;
            //   this.centro.nombre = ''
            //   this.centro.direccion = ''
            //   this.centro.telefono = ''
            //   this.centro.numero_cajas = ''
            //   this.centro.tramites = []
          },
          // Actualiza datos de centro de atencion
          async guardarCambiosRequisito() {
              const { valid } = await this.$refs.formeditarRequisito.validate()
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
                            let response = await axios.post('/api/requisito/actualizar-requisito', this.requisito)
                            return response
                          } catch (error) {
                              errorSweetAlert('Ocurrió un error al actualizar requisito.')
                          }
                      },
                      allowOutsideClick: () => !Swal.isLoading()
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if (result.value.status === 200) {
                              if (result.value.data.status === "ok") {
                                  successSweetAlert(result.value.data.message)
                                  this.$store.commit('setCatalogoRequisitos', result.value.data.requisitos)
                                  this.cancelarEditarCentroAtencion()
                              } else {
                                  errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                              }
                          } else {
                              errorSweetAlert('Ocurrió un error al actualizar requisito.')
                          }
                      }
                  })
              }
          },
          // Elimina (cambia el status) de un centro de atencion
          eliminarRequisito(requisito) {
              Swal.fire({
                  title: '¿Eliminar Requisito?',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085D6',
                  cancelButtonColor: '#D33',
                  confirmButtonText: 'Si, eliminar',
                  cancelButtonText: 'Cancelar',
                  showLoaderOnConfirm: true,
                  preConfirm: async () => {
                      try {
                          let response = await axios.post('/api/requisito/eliminar-requisito', requisito)
                          return response
                      } catch (error) {
                          errorSweetAlert('Ocurrió un error al eliminar requisito.')
                      }
                  },
                  allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                  if (result.isConfirmed) {
                      if (result.value.status === 200) {
                          if (result.value.data.status === "ok") {
                              successSweetAlert(result.value.data.message)
                              this.$store.commit('setCatalogoRequisitos', result.value.data.requisitos)
                              this.cancelarAgregarRequisito()
                          } else {
                              errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                          }
                      } else {
                          errorSweetAlert('Ocurrió un error al eliminar requisito.')
                      }
                  }
              })
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
          
      },
  })
</script>