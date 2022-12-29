<template>
    <div class="container my-6">
        <div class="text-center my-6">
            <h2>Agregar Horario</h2>
        </div>

        <div class="my-6 px-4 py-4">
            <v-select
                v-model="horario.centroAtencion"
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

            <v-form class="col-12" ref="formAgregarHorario">
                <div v-if="mes == true">
                    <v-select
                        v-model="horario.mes"
                        label="Seleccione el mes"
                        variant="solo"
                    >
                    </v-select>
                    <v-row>
                        <v-col
                            cols="12"
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
                            @click=""
                        >
                            Guardar Horarios
                        </v-btn>
                    </v-row>
                </div>
            </v-form>

            <div class="my-6 px-4 py-4" v-if="cargaDias">
                <EasyDataTable
                    class="mb-6"
                    :headers="headers"
                    :items="dias"
                    alternating
                    > 
                    <template #item-inhabil="dia">
                        <v-checkbox>
                        </v-checkbox>
                    </template>

                    <template #item-actions="dia">
                        <v-icon 
                        title="Editar Tramite"
                        @click="editarTramite(tramite)"
                        class="mr-1"
                        >
                            mdi-text-box-edit-outline
                        </v-icon>
                    </template>

                </EasyDataTable>
            </div>
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
                horario: {

                },
                headers: [
                    {
                        text: 'Dia', value: 'dia'
                    },
                    {
                        text: 'Horario Inicial', value: 'horario_inicio'
                    },
                    {
                        text: 'Horario Fin' , value:'horario_fin'
                    },
                    {
                        text: 'Inhabil', value:'inhabil'
                    },
                    {
                        text: 'Editar', value:'actions'
                    }
                ],
                dias: [
                    {
                        dia: 'Dia 1',
                        horario_inicio: '08:30',
                        horario_fin: '15:00'
                    },
                    {
                        dia: 'Dia 2',
                        horario_inicio: '08:30',
                        horario_fin: '15:00'
                    },
                    {
                        dia: 'Dia 3',
                        horario_inicio: '08:30',
                        horario_fin: '15:00'
                    },
                    {
                        dia: 'Dia 4',
                        horario_inicio: '08:30',
                        horario_fin: '15:00'
                    },
                    {
                        dia: 'Dia 5',
                        horario_inicio: '08:30',
                        horario_fin: '15:00'
                    },
                    {
                        dia: 'Dia 6',
                        horario_inicio: '08:30',
                        horario_fin: '15:00'
                    },
                    {
                        dia: 'Dia 7',
                        horario_inicio: '08:30',
                        horario_fin: '15:00'
                    }
                ]

            }
        },
        methods: {
            activarMes()
            {
                if(this.mes == false)
                    this.mes = true
                else
                    this.mes = false
            },
            cargarDias()
            {
                this.cargaDias = true

            }

        }
    })
</script>