<template>
    <div class="container my-6">
        <div class="text-center my-6">
            <h2>Editar Horarios</h2>
        </div>

        <div class="my-6 px-4 py-4">
            <v-form class="col-12" ref="formEditarHorario">

                <v-row>
                    <div class="col-sm-6 col-12">
                        <v-select
                            v-model="horario.centro_atencion_id"
                            :items="centrosAtencion"
                            item-title="nombre"
                            item-value="id"
                            label="Seleccione el centro de atencion"
                            variant="solo"
                            :rules="centroAtencionRules"
                        >
                        </v-select>

                    </div>

                    <div class="col-sm-6 col-12">
                        <v-select
                            v-model="horario.mes"
                            :items="meses"
                            item-title="nombre"
                            item-value="id"
                            label="Seleccione el mes"
                            variant="solo"
                            :rules="mesRules"
                        >
                        </v-select>
                    </div>
                </v-row>

                <v-row class="mt-4">
                    <div class="col-sm-6 col-12">
                        <v-btn
                            variant="flat"
                            color="warning"
                            @click="cargarDias()"
                        >
                            Cargar Dias
                        </v-btn>
                    </div>
                </v-row>

            </v-form>

            <div class="my-6 px-4 py-4" v-if="cargaDias">
                <EasyDataTable
                    class="mb-6"
                    :headers="headers"
                    :items="dias"
                    alternating
                    > 
                    <template #item-inhabil="dia">
                        <v-checkbox
                            v-model="dia.inhabil"
                            @click=checkinhabil(dia)  
                        >
                        </v-checkbox>
                    </template>

                    <template #item-actions="dia">
                        <v-icon 
                        title="Editar Tramite"
                        @click="editarHorario(dia)"
                        class="mr-1"
                        >
                            mdi-text-box-edit-outline
                        </v-icon>
                    </template>

                </EasyDataTable>
            </div>

            <v-dialog
                v-model="dialogEditarDia"
                max-width="800px"
                
            >
                <v-card>
                    <v-card-title>
                        Cambio de Horario
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-container>
                            <v-form class="col-12" ref="formCambioHorario">
                                <v-select
                                    v-model="editar.accion"
                                    :items="acciones"
                                    label="Seleccione una acción"
                                    variant="solo"
                                ></v-select>
                                
                                <p><strong>Dia: </strong>{{ editar.dia }}</p>

                                <h4>Horario de atencion</h4>
                                <div v-if="editar.accion =='AMPLIAR HORARIO' || editar.accion == 'REDUCIR HORARIO'">
                                    <v-text-field
                                        v-model="editar.hora_inicio"
                                        variant="solo"
                                        type="time" 
                                        label="Hora inicio" 
                                    >
                                    </v-text-field>

                                    <v-text-field
                                        v-model="editar.hora_fin"
                                        variant="solo"
                                        type="time" 
                                        label="Hora Fin" 
                                    >
                                    </v-text-field>
                                </div>

                                <div v-else>
                                    <v-text-field
                                        v-model="editar.hora_inicio"
                                        variant="solo"
                                        type="time" 
                                        label="Hora inicio" 
                                        disabled
                                    >
                                    </v-text-field>

                                    <v-text-field
                                        v-model="editar.hora_fin"
                                        variant="solo"
                                        type="time" 
                                        label="Hora Fin" 
                                        disabled
                                    >
                                    </v-text-field>
                                </div>

                                <div v-if="editar.accion == 'CAMBIAR DURACIÓN DE CITA'">
                                    <v-text-field
                                        v-model="editar.duracion"
                                        label="Duracion Cita"
                                        type="number"
                                        variant="solo"
                                    >
                                    </v-text-field>
                                </div>

                                <div v-else>
                                    <v-text-field
                                        v-model="editar.duracion"
                                        label="Duracion Cita"
                                        type="number"
                                        variant="solo"
                                        disabled
                                    >
                                    </v-text-field>
                                </div>

                                <div v-if="editar.accion =='HABILITAR/DESHABILITRA DIA'">
                                    <v-checkbox
                                        v-model="editar.inhabil"
                                        label="Inhabil"
                                    >
                                    </v-checkbox>
                                </div>

                                <div v-else>
                                    <v-checkbox
                                        v-model="editar.inhabil"
                                        label="Inhabil"   
                                        disabled                                 
                                    >
                                    </v-checkbox>
                                </div>

                            </v-form>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            variant="flat"
                            color="warning"
                            @click="cancelarCambioHorario()"
                        >
                            Cerar
                        </v-btn>
                        <v-btn
                            variant="flat"
                            color="error"
                            @click="guardarCambios(dia)"
                        >
                            Guardar Cambios
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>


        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { errorSweetAlert, successSweetAlert } from "../helpers/sweetAlertGlobals"

    export default defineComponent({
        name:'editar-horario',

        data() {
            return {
                loading: false,
                cargaDias: false,
                dialogEditarDia: false,

                horario: {
                    centro_atencion_id: '',
                    mes: '',
                    pmes: true,
                },
                editar: {
                    id: null, 
                    accion: '',
                    dia: '',
                    hora_inicio: '',
                    hora_fin: '',
                    duracion: '',
                    inhabil: false,
                    mes: '',
                    centro_atencion_id: ''
                },

                acciones: [
                    'HABILITAR/DESHABILITRA DIA', 'AMPLIAR HORARIO','REDUCIR HORARIO', 'CAMBIAR DURACIÓN DE CITA'
                ],

                meses: [
                    {
                        id: '1',
                        nombre: 'Enero'
                    },
                    {
                        id: '2',
                        nombre: 'Febrero'
                    },
                    {
                        id: '3',
                        nombre: 'Marzo'
                    },
                    {
                        id: '4',
                        nombre: 'Abril'
                    }
                ],
                headers: [
                    {
                        text: 'Dia', value: 'dia'
                    },
                    {
                        text: 'Horario Inicial', value: 'hora_inicio'
                    },
                    {
                        text: 'Horario Fin' , value:'hora_fin'
                    },
                    {
                        text: 'Inhabil', value:'inhabil'
                    },
                    {
                        text: 'Editar', value:'actions'
                    }
                ],
                centroAtencionRules: [
                    v => !!v || 'El campo de centro de atención es requerido'
                ],
                mesRules: [
                    v => !!v || 'El campo mes es requerido'
                ],

            }
        },
        created() {
            this.getCentrosAtencion()
        },
        computed: {
            dias() {
                if(this.loading) {
                    return []
                } else {
                    return this.$store.getters.getDias
                }
            },
            centrosAtencion() {
                if (this.loading) {
                    return []
                } else {
                    return this.$store.getters.getCatalogoCentrosAtencion
                }
            },
        },
        methods: {
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

            async cargarDias()
            {
                console.log(this.horario)
                try {
                    let response = await axios.post('/api/horarios/dias-editar', this.horario)
                    if(response.status === 200) {
                        if(response.data.status === "ok") {
                            console.log(response.data.dias)
                            this.$store.commit('setDias', response.data.dias)
                            this.cargaDias = true
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al cargar dias')
                    }
                    
                }catch (error) {
                    errorSweetAlert('Ocurrió un error al cargar dias')
                }

            },

            editarHorario(dia)
            {
                this.editar.id = dia.id
                this.editar.dia = dia.dia
                this.editar.hora_inicio = dia.hora_inicio
                this.editar.hora_fin = dia.hora_fin
                this.editar.duracion = dia.duracion
                this.editar.inhabil = dia.inhabil
                this.editar.mes = dia.mes
                this.editar.centro_atencion_id = dia.centro_atencion_id
                this.dialogEditarDia = true
            },

            async guardarCambios()
            {
                console.log(this.editar)
                const { valid } = await this.$refs.formCambioHorario.validate()
                // this.horario.dias = this.dias
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
                                let response = await axios.post('/api/horarios/actualizar-horario', this.editar)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al editar el dias.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    successSweetAlert(result.value.data.message)
                                    // this.$store.commit('setDias', response.data.dias)
                                    console.log(result.value.data.dias)
                                    this.$store.commit('setDias', result.value.data.dias)
                                    // this.limpiarFormulario()
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al editar dias.')
                            }
                        }
                    })
                }
            },
            limpiarFormulario()
            {
                this.horario.centro_atencion_id =''
                this.horario.mes =  ''
                this.dialogEditarDia = false
            }

        }
    })
</script>