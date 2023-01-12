<template>
    <div class="container my-6">
        <div class="text-center my-6">
            <h2>NOTAS</h2>
            <v-btn class="mb-4"
                large
                title="Nueva Nota"
                @click="Agregarnota" >
                <v-icon size="30" x-large icon="mdi-pencil-box-outline"></v-icon>
            </v-btn>
        </div>
        <div class="my-6 px-4 py-4">
            <EasyDataTable 
                class="mb-6"
                :headers="headers" 
                :items="notas"
                alternating
            >
                <template #item-actions="nota">                        
                        <v-icon
                            title="Editar Nota"
                            @click="EditarNota(nota)"
                            class="mr-1" 
                        >
                            mdi-text-box-edit-outline
                        </v-icon>
                        <v-icon
                            title="Eliminar nota"  
                            @click="eliminarNota(nota)"
                            class="ml-1"
                        >
                            mdi-trash-can
                        </v-icon>
                </template>
            </EasyDataTable>
        </div>
        <!-- modal para agregar usuario -->
        <v-dialog
            v-model="dialogAgregarNota"
            max-width="700px"
            persistent
            >
            <v-card>
                <v-card-title>
                    <h3>Agregar Nota</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formAgregarNota">
                                
                                    <v-text-field
                                        variant="solo"
                                        v-model="nota.nombre"
                                        label="Nombre Nota"
                                    ></v-text-field>
                                    <v-text-field
                                        variant="solo"
                                        v-model="nota.descripcion"
                                        label="Descripcion"
                                    ></v-text-field>
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
                        @click="cancelarAgregarNuevaNota()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="guardarNuevaNota()"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        
        <v-dialog
            v-model="dialogEditarNota"
            max-width="800px"
            persistent
        >
            <v-card>
                <v-card-title>
                    <h3>Editar Nota</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formEditarNota">
                                <v-text-field
                                    v-model="nota.nombre"
                                    label="Nombre Nota"
                                ></v-text-field>
                                <v-text-field
                                    v-model="nota.descripcion"
                                    label="Descripcion"
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
                        @click="CancelarEditarNota()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="guardarCambiosEditarNota()"
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
                        dialogAgregarNota: false,
                        dialogEditarNota: false,
                        nota: {
                            id: null,
                            nombre: '',
                            descripcion: '',
                        },
                        loading: false,
                        headers: [
                        { 
                            text: "Nombre", value: "nombre" 
                        },
                        { 
                            text: "Descripción", value: "descripcion"
                        },
                        { 
                            text: 'ACCIONES', value: 'actions'
                        }
                        ],
                        dialogAgregarCentro: false,
                        
                    }
        },
        created(){
            this.getCatalogoNotas()
        },
        computed:{
            notas(){
                if (this.loading) {
                return []
            } else {
                return this.$store.getters.getCatalogoNotas
            }

            },
        },
        methods: {
            // Abrir modal nueva nota
            Agregarnota() {
                console.log('agregar nota')
                this.dialogAgregarNota = true
            },
            //Cerrar modal nueva nota 
            cancelarAgregarNuevaNota() {
                this.dialogAgregarNota = false
                this.nota.nombre = ''
                this.nota.descripcion = ''
            },
            // Guardar nueva nota 
            async guardarNuevaNota() {
                //console.log(this.)
                const { valid } = await this.$refs.formAgregarNota.validate()
                if (valid) {
                    Swal.fire({
                        title: '¿Guardar nueva nota?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {
                                let response = await axios.post('/api/notas/agregar-nota', this.nota)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar la nueva nota.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoNotas', result.value.data.notas)
                                    this.cancelarAgregarNuevaNota()
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar la nueva nota.')
                            }
                        }
                    })
                }
            },
            // Abrir modal de editar nota ya con los datos cargados
            EditarNota(nota) {
                this.dialogEditarNota = true
                this.nota.id = nota.id
                this.nota.nombre = nota.nombre
                this.nota.descripcion = nota.descripcion
            },
            // boton para cerrar el modal
            CancelarEditarNota() {
                this.dialogEditarNota = false
                this.nota.id = null,
                this.nota.nombre = ''
                this.nota.descripcion = ''
            },
            // Guardar Cambios de nota
            async guardarCambiosEditarNota() {
                //console.log(this.usuario)
                const { valid } = await this.$refs.formEditarNota.validate()
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
                                let response = await axios.post('/api/notas/actualizar-nota', this.nota)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar los datos de la nota.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoNotas', result.value.data.notas)
                                    this.CancelarEditarNota()
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar los datos de la nota.')
                            }
                        }
                    })
                }
            },
            // "elimina" cambia estatus del usuario 
            eliminarNota(nota) {
                Swal.fire({
                  title: '¿Eliminar Nota?',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085D6',
                  cancelButtonColor: '#D33',
                  confirmButtonText: 'Si, eliminar',
                  cancelButtonText: 'Cancelar',
                  showLoaderOnConfirm: true,
                  preConfirm: async () => {
                      try {
                          let response = await axios.post('/api/notas/eliminar-nota', nota)
                          return response
                      } catch (error) {
                          errorSweetAlert('Ocurrió un error al eliminar esta nota.')
                      }
                  },
                  allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                  if (result.isConfirmed) {
                      if (result.value.status === 200) {
                          if (result.value.data.status === "ok") {
                              successSweetAlert(result.value.data.message)
                              this.$store.commit('setCatalogoNotas', result.value.data.notas)
                              this.CancelarEditarNota()
                          } else {
                              errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                          }
                      } else {
                          errorSweetAlert('Ocurrió un error al eliminar esta nota.')
                      }
                  }
              })

            },
            // para mostrar los datos en la tabla principal
            async getCatalogoNotas() {
              this.loading = true
              try {
                  let response = await axios.get('/api/catalogos/notas')
                  if (response.status === 200) {
                      if (response.data.status === "ok") {
                          this.$store.commit('setCatalogoNotas', response.data.notas)
                           console.log(this.$store.getters.getCatalogoNotas)
                           console.log(this.notas)
                      } else {
                          errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                      }
                  } else {
                      errorSweetAlert('Ocurrió un error al obtener el catalogo de notas')
                  }
              } catch (error) {
                  errorSweetAlert('Ocurrió un error al obtener el catalogo de notas')
              }
              this.loading = false
          },
        },
    }
</script>