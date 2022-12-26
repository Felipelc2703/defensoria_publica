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
                      @click="editarRequisito(tramite)"
                      class="mr-1"
                    >
                        mdi-text-box-edit-outline
                    </v-icon>
                    <v-icon 
                        title="Eliminar Tramite"
                        @click="eliminarRequisito(tramite)"
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
                <h3>Agregar Tramite</h3>

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

        }


    })
</script>