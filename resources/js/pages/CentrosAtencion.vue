<template>
    <div class="container my-6">
    
        <div class="text-center my-6">
            <h2>CENTRO DE ATENCIÓN</h2>
            <v-btn class="mb-4"
                large
                title="Nuevo Centro de Atención"
                @click="agregarCentro" >
                <v-icon size="30" x-large icon="mdi-pencil-box-outline"></v-icon>
            </v-btn>
        </div>

        <div class="my-6 px-4 py-4">
            <EasyDataTable
                class="mb-6"
                :headers="headers" 
                :items="centrosAtencion"
                alternating
            >
                <template #item-actions="centro">
                    <v-icon 
                        title="Editar Centro"
                        @click="editarCentro(centro)"
                        class="mr-1"
                    >
                        mdi-text-box-edit-outline
                    </v-icon>
                    <v-icon 
                        title="Eliminar Centro"
                        @click="eliminarCentro(centro)"
                        class="ml-1"
                    >
                        mdi-trash-can
                    </v-icon>
                </template>
            </EasyDataTable>
        </div>

        <v-dialog
            v-model="dialogAgregarCentro"
            max-width="800px"
            persistent
        >
            <v-card>
                <v-card-title>
                    <h3>Agregar Oficina</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formAgregarOficina">
                                <v-text-field
                                    v-model="centro.nombre"
                                    label="Nombre"
                                    :rules="nombreRules"
                                ></v-text-field>
                                <v-text-field
                                    v-model="centro.direccion"
                                    label="Direccion"
                                    :rules="direccionRules"
                                ></v-text-field>
                                <div class="row justify-content-between">
                                    <div class="col-sm-6 col-12">
                                        <v-text-field
                                            v-model="centro.telefono"
                                            label="Telefono"
                                        >
                                        </v-text-field>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <v-text-field
                                            v-model="centro.numero_cajas"
                                            label="Numero de cajas"
                                            type="number"
                                            min="0"
                                        >
                                        </v-text-field>
                                    </div>
                                </div>
                                <div v-for="(tramite, index) in tramites" :key="index">
                                    <input type="checkbox" :value="tramite.id" v-model="centro.tramites" :id="`check_${index}`">  <label :for="`check_${index}`">{{tramite.nombre}}</label>
                                </div>
                            </v-form>
                        </v-row>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="warning"
                        @click="cancelarAgregarCentroAtencion()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="guardarNuevoCentroAtencion()"
                    >
                        Guardar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog
            v-model="dialogEditarCentro"
            max-width="800px"
            persistent
        >
            <v-card>
                <v-card-title>
                    <h3>Editar Oficina</h3>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-form class="col-12" ref="formEditarOficina">
                                <v-text-field
                                    v-model="centro.nombre"
                                    label="Nombre"
                                    :rules="nombreRules"
                                ></v-text-field>
                                <v-text-field
                                    v-model="centro.direccion"
                                    label="Direccion"
                                    :rules="direccionRules"
                                ></v-text-field>
                                <div class="row justify-content-between">
                                    <div class="col-sm-6 col-12">
                                        <v-text-field
                                            v-model="centro.telefono"
                                            label="Telefono"
                                            counter="10"
                                            maxlength="10"
                                        >
                                        </v-text-field>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <v-text-field
                                            v-model="centro.numero_cajas"
                                            label="Numero de cajas"
                                            type="number"
                                        >
                                        </v-text-field>
                                    </div>
                                </div>
                                <div v-for="(tramite, index) in tramites" :key="index">
                                    <input type="checkbox" :value="tramite.id" v-model="centro.tramites" :id="`check_${index}`">  <label :for="`check_${index}`">{{tramite.nombre}}</label>
                                </div>
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
                        @click="guardarCambiosCentroAtencion()"
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
        name: 'centros-atencion',
        data() {
            return {
                dialogAgregarCentro: false,
                dialogEditarCentro: false,
                loading: false,
                centro: {
                    id: null,
                    nombre: '',
                    direccion: '',
                    telefono: '',
                    numero_cajas: '',
                    tramites: [],
                },  
                headers: [
                    { 
                        text: 'Nombre Centro de Atención', value: 'nombre'
                    },
                    { 
                        text: 'Dirección', value: 'direccion'
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
            this.getCentrosAtencion()
            this.getTramites()
        },
        computed: {
            centrosAtencion() {
                if (this.loading) {
                    return []
                } else {
                    return this.$store.getters.getCatalogoCentrosAtencion
                }
            },
            tramites() {
                return this.$store.getters.getCatalogoTramites
            }
        },
        methods: {
            // Obtiene el catalogo de centros de atencion
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
            // Obtiene el catalogo de tramites
            async getTramites() {
                try {
                    let response = await axios.get('/api/catalogos/tramites')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.$store.commit('setCatalogoTramites', response.data.tramites)
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el catalogo de tramites')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el catalogo de tramites')
                }
            },
            // Abrir modal nuevo centro de atencion
            agregarCentro() {
                this.dialogAgregarCentro = true
            },
            // Cerrar modal nuevo centro de atencion
            cancelarAgregarCentroAtencion() {
                this.dialogAgregarCentro = false
                this.centro.nombre = ''
                this.centro.direccion = ''
                this.centro.telefono = ''
                this.centro.numero_cajas = ''
                this.centro.tramites = []
            },
            // Guarda un nuevo centro de atencion
            async guardarNuevoCentroAtencion() {
                const { valid } = await this.$refs.formAgregarOficina.validate()
                if (valid) {
                    Swal.fire({
                        title: '¿Guardar nuevo centro de atención?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, guardar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {
                                let response = await axios.post('/api/centro-atencion/guardar-nuevo', this.centro)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al guardar nuevo centro de atención.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoCentrosAtencion', result.value.data.centros_atencion)
                                    this.cancelarAgregarCentroAtencion()
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al guardar nuevo centro de atención.')
                            }
                        }
                    })
                }
            },
            // Abrir modal editar centro de atencion
            editarCentro(centro) {
                this.centro.id = centro.id
                this.centro.nombre = centro.nombre
                this.centro.direccion = centro.direccion
                this.centro.telefono = centro.telefono
                this.centro.numero_cajas = centro.numero_cajas
                this.centro.tramites = centro.tramites
                this.dialogEditarCentro = true
            },
            // Cerrar modal editar centro de atencion
            cancelarEditarCentroAtencion() {
                this.dialogEditarCentro = false
                this.centro.id = null;
                this.centro.nombre = ''
                this.centro.direccion = ''
                this.centro.telefono = ''
                this.centro.numero_cajas = ''
                this.centro.tramites = []
            },
            // Actualiza datos de centro de atencion
            async guardarCambiosCentroAtencion() {
                const { valid } = await this.$refs.formEditarOficina.validate()
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
                                let response = await axios.post('/api/centro-atencion/actualizar-centro', this.centro)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al actualizar centro de atención.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    this.$store.commit('setCatalogoCentrosAtencion', result.value.data.centros_atencion)
                                    this.cancelarEditarCentroAtencion()
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al actualizar centro de atención.')
                            }
                        }
                    })
                }
            },
            // Elimina (cambia el status) de un centro de atencion
            eliminarCentro(centro) {
                Swal.fire({
                    title: '¿Eliminar Centro de Atención?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085D6',
                    cancelButtonColor: '#D33',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                            let response = await axios.post('/api/centro-atencion/eliminar-centro', centro)
                            return response
                        } catch (error) {
                            errorSweetAlert('Ocurrió un error al eliminar centro de atención.')
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.value.status === 200) {
                            if (result.value.data.status === "ok") {
                                successSweetAlert(result.value.data.message)
                                this.$store.commit('setCatalogoCentrosAtencion', result.value.data.centros_atencion)
                                this.cancelarAgregarCentroAtencion()
                            } else {
                                errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error al eliminar centro de atención.')
                        }
                    }
                })
            }
        },
    })
</script>