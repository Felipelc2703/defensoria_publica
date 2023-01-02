<template>
    <div class="container my-6">
        <div class="text-center my-6">
            <h2>Agregar Horario</h2>
        </div>

        <div class="my-6 px-4 py-4">
            <v-form class="col-12" ref="formAgregarHorario">
                <v-select
                    v-model="horario.centroAtencion"
                    :items="centrosAtencion"
                    item-title="nombre"
                    item-value="id"
                    label="Seleccione el centro de atencion"
                    variant="solo"
                >
                </v-select>

                <v-row>
                    <v-col
                        cols="12"
                        sm="4"
                    >
                    <v-label> Seleccione el mes o el rango de fechas </v-label>
                    </v-col>
                    <v-radio
                        v-model="mes"
                        label="Por Mes"
                        @click=activarMes()
                    >
                    </v-radio>
                    <v-radio
                        v-model="fecha"
                        label="Por Fechas"
                    >
                    </v-radio>
                </v-row>

                <!-- <v-form class="col-12" ref="formAgregarHorario"> -->
                    <div v-if="mes == true">
                        <v-select
                            v-model="horario.mes"
                            :items="meses"
                            item-title="nombre"
                            item-value="id"
                            label="Seleccione el mes"
                            variant="solo"
                        >
                        </v-select>
                        <v-row>
                            <v-col
                                cols="2"
                                sm="4"
                            >
                                <v-label for="">Seleccione el horario de atención </v-label>
                            </v-col>
                            <v-col
                                cols="2"
                                sm="4"
                            >
                                <v-text-field
                                    v-model="horario.hora_inicio"
                                    variant="solo"
                                    type="time"
                                    label="Hora inicio" 
                                >
                                </v-text-field>
                            </v-col>
                            <v-col
                                cols="2"
                                sm="4"
                            >
                                <v-text-field
                                    v-model="horario.hora_fin"
                                    variant="solo"
                                    type="time" 
                                    label="Hora Fin" 
                                >
                            </v-text-field>
                            </v-col>
                        </v-row>
                        
                        <v-text-field
                            v-model="horario.duracion"
                            variant="solo" 
                            type="number" 
                            label="Proporcione el tiempo de duracion de las citas en minutos"
                        ></v-text-field>

                        <v-spacer></v-spacer>
                        <v-row>
                            <v-col
                                cols="12"
                                sm="9"
                            >
                                <v-btn
                                    variant="flat"
                                    color="warning"
                                    @click="cargarDias()"
                                >
                                    Cargar Dias
                                </v-btn>
                            </v-col>
                            <v-btn
                                variant="flat"
                                color="error"
                                @click="guardarHorarios()"
                            >
                                Guardar Horarios
                            </v-btn>
                        </v-row>
                    </div>
                <!-- </v-form> -->

                <div class="my-6 px-4 py-4" v-if="cargaDias">
                    <EasyDataTable
                        class="mb-6"
                        :headers="headers"
                        :items="dias"
                        alternating
                        > 
                        <template #item-inhabil="dia">
                            <v-checkbox
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
            </v-form>

            <v-dialog
                v-model="dialogEditarDia"
                max-width="800px"
                persistent
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
                            @click="guardarCambios()"
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
        name:'catalogo-tramites',
        data() {
            return { 
                loading: false,
                mes: false,
                fecha: false,
                cargaDias: false,
                dialogEditarDia : false,
                horario: {
                    mes: '',
                    hora_inicio: '',
                    hora_fin: '',
                    duracion: '',
                    inhabil: false,
                    dias: [],
                },
                editar: {
                    id: null, 
                    accion: '',
                    dia: '',
                    hora_inicio: '',
                    hora_fin: '',
                    duracion: '',
                    inhabil: false
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
            activarMes()
            {
                if(this.mes == false)
                    this.mes = true
                else
                    this.mes = false
            },
            async cargarDias()
            {
                console.log(this.horario)
                try {
                    let response = await axios.post('/api/horarios/llenar-dias', this.horario)
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
            checkinhabil(dia)
            {
                // console.log(dia)


                this.dias.forEach(element => {
                    if (element.id == dia.id) {
                        // console.log("encontrado")
                        if (element.inhabil == false) {
                            element.inhabil = true
                        } else {
                            element.inhabil = false
                        }
                    }
                })

                console.log(this.dias)
            },
            guardarHorarios() {
                this.horario.dias = this.dias
                console.log(this.horario.dias)
            },

            editarHorario(dia)
            {
                this.editar.id = dia.id
                this.editar.dia = dia.fecha
                this.editar.hora_inicio = dia.hora_inicio
                this.editar.hora_fin = dia.hora_fin
                this.editar.duracion = dia.duracion
                this.editar.inhabil = dia.inhabil
                this.dialogEditarDia = true
            },

            cancelarCambioHorario()
            {
                this.editar.id = null
                this.editar.dia = ''
                this.editar.hora_inicio = ''
                this.editar.hora_fin = ''
                this.editar.duracion = ''
                this.dialogEditarDia = false
            },

            guardarCambios()
            {
                this.dias.forEach(element => {
                    if (element.id == this.editar.id) {
                        element.hora_inicio = this.editar.hora_inicio
                        element.hora_fin =  this.editar.hora_fin
                        element.duracion = this.editar.duracion
                        element.inhabil = this.editar.inhabil
                    }
                })
                this.dialogEditarDia = false
                // console.log(this.dias)
            }

        }
    })
</script>