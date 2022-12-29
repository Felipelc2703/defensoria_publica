<template>
    <div class="m-0">
        <v-dialog
            v-model="dialogRequisitos"
            max-width="600px"
            persistent
        >
            <v-card>
                <v-card-title class="text-center">
                    <span class="titulo-modal-requisitos">Sistema de Citas</span>
                    <div class="first-line"></div>
                </v-card-title>
                <div class="container mb-2">
                    <p class="texto-saludo"><span class="">Estimado ciudadano:</span></p>
                    <div class="second-line"></div>
                    <p class="texto-instrucciones">A continuación se muestran los requisitos que deberá presentar ante el Centro de Atención para realizar el trámite; favor de seleccionar aquéllos con los que cuenta:</p>
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr class="encabezado-tabla-requisitos">
                                <th scope="col" class="text-center texto-encabezado-tabla-requisitos">Requisitos</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(requisito, index) in tramiteSeleccionado.requisitos" :key="index">
                                <td><span class="texto-requisito-tabla">{{requisito.nombre}}</span></td>
                                <td><input type="checkbox" @change="checkRequisito(requisito)"></td>
                                <td><p class="campo-obligatorio" v-if="requisito.obligatorio">*</p></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="ultimos-textos-modal-requisitos">
                        <p>Si usted ya cuenta con una cita agendada y desea consultarla, dé <span class="texto-click-aqui">click aquí</span>.</p>
                        <p>Todos los trámites son personales. Para verificar las especificaciones de los requisitos dé <span class="texto-click-aqui">click aquí</span>.</p>
                        <p class="texto-requisitos-obligatorios">(*) Requisitos obligatorios</p>
                        <div class="text-center">
                            <p v-if="bandera_requisitos_obligatorios" class="texto-faltan-requisitos-obligatorios">Atención: Debe seleccionar al menos una opción para continuar.</p>
                        </div>
                    </div>
                    <div class="third-line"></div>
                </div>
                <v-card-actions class="mb-4">
                    <v-spacer></v-spacer>
                    <button class="boton-cancelar" @click="cancelarSolicitud()">Cancelar</button>
                    <button class="boton-aceptar" @click="aceptarRequisitos()">Aceptar</button>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <div class="row contenedor">
            <div class="col-sm-9 col-12 contenedor-uno">
                <div class="text-center py-2">
                    <img class="scale-logo-defensoria" width="200" height="75" src="../../../public/images/logo_defensoria_publica.svg" alt="">
                </div>
            </div>
            <div class="col-sm-3 col-12 contenedor-dos">
                <p class="titulo-nombre-tramite">Resumen de cita:</p>
            </div>
            <div class="w-100"></div>
            <div class="col-sm-9 col-12 contenedor-tres">
                <div class="text-center mt-4 mb-4 ml-10 mr-10">
                    <div class="container">
                        <div class="row justify-content-around">
                            <div class="col-sm-12 col-md-6 text-left">
                                <p class="titulo_tipo_tramite">{{tramiteSeleccionado.nombre}}</p>
                            </div>
                            <div class="col-sm-12 col-md-6 text-right">
                                <v-btn variant="text" prepend-icon="mdi-arrow-left" @click="volverInicio()">Regresar</v-btn>
                            </div>
                        </div>
                        <div class="mt-4">
                            <v-expansion-panels v-model="panel">
                                <v-expansion-panel>
                                    <v-expansion-panel-title v-slot="{ open }">
                                        <v-row no-gutters>
                                            <v-col cols="8" class="d-flex justify-start">
                                                <h6><span class="texto-pasos">PASO 1:</span> <span class="texto-nombre-paso">Seleccione el centro de atención</span></h6>
                                            </v-col>
                                            <v-col cols="8" class="text--secondary">
                                                <v-fade-transition leave-absolute>
                                                    <span v-if="open" key="0"></span>
                                                    <span v-else key="1"></span>
                                                </v-fade-transition>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-title>
                                    <v-expansion-panel-text>
                                        <div class="row mt-4">
                                            <div class="col-md-6 col-12">
                                                <v-select
                                                    @update:modelValue="seleccionarCentroAtencion()"
                                                    v-model="cita.centro_atencion"
                                                    :items="tramiteSeleccionado.centrosAtencion"
                                                    item-title="nombre"
                                                    item-value="id"
                                                    variant="outlined"
                                                    label="Centro de Atención:"
                                                >
                                                </v-select>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="texto-ubicacion-centros">
                                                    <p class="text-left m-0">Si requiere conocer la ubicación de cada uno de los lugares donde puede realizar el trámite, de <span class="texto-click-aqui">click aqui</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                                <v-expansion-panel v-if="mostrarPaso2">
                                    <v-expansion-panel-title v-slot="{ open }">
                                        <v-row no-gutters>
                                            <v-col cols="8" class="d-flex justify-start">
                                                <h6><span class="texto-pasos">PASO 2: </span> <span class="texto-nombre-paso">Seleccione la fecha y hora de la cita</span></h6>
                                            </v-col>
                                            <v-col cols="8" class="text--secondary">
                                                <v-fade-transition leave-absolute>
                                                    <span v-if="open"></span>
                                                    <v-row v-else no-gutters style="width: 100%"></v-row>
                                                </v-fade-transition>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-title>
                                    <v-expansion-panel-text>
                                        <div class="row mt-4">
                                            <div class="col-md-6 col-12 text-center">
                                                <table class="m-0 w-100" id="calendar">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="7">
                                                                <table class="w-100 calendar-header">
                                                                    <tbody>
                                                                        <tr class="tr-header">
                                                                            <td class="previous-month"></td>
                                                                            <td class="calendar-month">Diciembre de 2022</td>
                                                                            <td class="next-month"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr class="w-100">
                                                            <th class="calendar-day-name">dom.</th>
                                                            <th class="calendar-day-name">lun.</th>
                                                            <th class="calendar-day-name">mar.</th>
                                                            <th class="calendar-day-name">mié.</th>
                                                            <th class="calendar-day-name">jue.</th>
                                                            <th class="calendar-day-name">vie.</th>
                                                            <th class="calendar-day-name">sab.</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <v-select
                                                    v-model="cita.hora_cita"
                                                    label="Seleccione el horario"
                                                    :items="horarios_disponibles"
                                                    item-title="hora"
                                                    item-value="hora"
                                                    variant="outlined"
                                                ></v-select>
                                            </div>
                                        </div>
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                                <v-expansion-panel v-if="mostrarPaso3">
                                    <v-expansion-panel-title v-slot="{ open }">
                                        <v-row no-gutters>
                                            <v-col cols="8" class="d-flex justify-start">
                                                <h6><span class="texto-pasos">PASO 3: </span> <span class="texto-nombre-paso">Ingrese los datos del solicitante</span></h6>
                                            </v-col>
                                            <v-col cols="8" class="text--secondary">
                                                <v-fade-transition leave-absolute>
                                                    <span v-if="open"></span>
                                                    <v-row v-else no-gutters style="width: 100%"></v-row>
                                                </v-fade-transition>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-title>
                                    <v-expansion-panel-text>
                                        <v-card>
                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-form class="col-12 mt-4 mb-4">
                                                            <v-text-field
                                                                v-model="cita.nombre"
                                                                label="Nombre"
                                                                :rules="nombreRules"
                                                            ></v-text-field>
                                                            <v-text-field
                                                                v-model="cita.email"
                                                                label="Correo Electrónico"
                                                                :rules="emailRules"
                                                            ></v-text-field>
                                                            <div class="row justify-content-between">
                                                                <div class="col-sm-6 col-12">
                                                                    <v-text-field
                                                                        v-model="cita.telefono"
                                                                        label="Teléfono"
                                                                        :rules="telefonoRules"
                                                                    ></v-text-field>
                                                                </div>
                                                                <div class="col-sm-6 col-12">
                                                                    <v-select
                                                                        v-model="cita.sexo"
                                                                        label="Seleccione el sexo"
                                                                        :items="['Masculino', 'Femenino']"
                                                                        :rules="sexoRules"
                                                                    ></v-select>
                                                                </div>
                                                            </div>
                                                            <div class="row justify-content-between">
                                                                <div class="col-sm-6 col-12">
                                                                    <v-select
                                                                        v-model="cita.tiene_discapacidad"
                                                                        label="¿Presenta alguna discapacidad?"
                                                                        :items="['Si', 'No']"
                                                                    ></v-select>
                                                                </div>
                                                                <div class="col-sm-6 col-12">
                                                                    <v-select
                                                                        v-if="cita.tiene_discapacidad == 'Si'"
                                                                        v-model="cita.discapacidad"
                                                                        label="¿Cuál?"
                                                                        :items="['Uno', 'Dos']"
                                                                    ></v-select>
                                                                </div>
                                                            </div>
                                                        </v-form>
                                                    </v-row>
                                                </v-container>
                                            </v-card-text>
                                            <v-card-actions class="mb-6">
                                                <v-spacer></v-spacer>
                                                <button class="boton-cancelar" @click="cancelarSolicitud()">Cancelar</button>
                                                <button class="boton-aceptar" @click="agendarCita()">Agendar</button>
                                                <v-spacer></v-spacer>
                                            </v-card-actions>
                                        </v-card>
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-12 contenedor-cuatro">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <span class="texto-estatico-resumen-cita">Centro de Atención:</span>
                            <br>
                            <span class="texto-dinamico-resumen-cita">{{resumen_cita.centro_atencion}}</span>
                            <br>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <span class="texto-estatico-resumen-cita">Día de la Cita:</span>
                            <br>
                            <span id="span_dia_cita" class="texto-dinamico-resumen-cita"></span>
                            <br>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <span class="texto-estatico-resumen-cita">Hora de la Cita:</span>
                            <br>
                            <span class="texto-dinamico-resumen-cita">{{resumen_cita.hora_cita}}</span>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input id="input_aux_dia_cita" type="text" style="display: none;" value="0">
        <input id="input_aux_fecha_formateada" type="text" style="display: none;" value="0">
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { errorSweetAlert, successSweetAlert } from './../helpers/sweetAlertGlobals'

    export default defineComponent({
        name: 'crear-cita',
        data() {
            return {
                cita: {
                    requisitos: [],
                    centro_atencion: '',
                    tramite: '',
                    dia_cita: '',
                    fecha_formateada: '',
                    hora_cita: '',
                    nombre: '',
                    email: '',
                    telefono: '',
                    sexo: '',
                    tiene_discapacidad: '',
                    discapacidad: '',
                },
                nombreRules: [
                    v => !!v || 'El nombre es requerido'
                ],
                emailRules: [
                    v => !!v || 'El email es requerido',
                ],
                telefonoRules: [
                    v => !!v || 'El telefono es requerido',
                ],
                sexoRules: [
                    v => !!v || 'El sexo es requerido',
                ],
                resumen_cita: {
                    centro_atencion: '',
                    dia_cita: '',
                    hora_cita: '',
                },
                horarios_disponibles: [
                    {
                        id: 1,
                        hora: '09:30:00'
                    },
                    {
                        id: 2,
                        hora: '10:00:00'
                    },
                    {
                        id: 3,
                        hora: '10:30:00'
                    },
                    {
                        id: 4,
                        hora: '11:00:00'
                    },
                    {
                        id: 5,
                        hora: '11:30:00'
                    },
                    {
                        id: 6,
                        hora: '12:00:00'
                    }
                ],
                bandera_requisitos_obligatorios: false,
                panel: [0, 1, 2],
                mostrarPaso2: true,
                mostrarPaso3: true,
                dialogRequisitos: true,
                semana_uno: [],
                semana_dos: [],
                semana_tres: [],
                semana_cuatro: [],
                semana_cinco: [],
                semana_seis: [],
            }
        },
        created() {
            this.cita.requisitos = this.tramiteSeleccionado.requisitos
            this.cita.requisitos = this.tramiteSeleccionado.requisitos
            this.cita.requisitos.forEach(element => {
                element.checked = '0'
            })
            this.getCalendar()
        },
        computed: {
            tramiteSeleccionado() {
                return this.$store.getters.getTramiteSeleccionado
            }
        },
        watch: {
            'cita.centro_atencion': function () {
                this.tramiteSeleccionado.centrosAtencion.forEach(e => {
                    if (e.id == this.cita.centro_atencion) {
                        this.resumen_cita.centro_atencion = e.nombre
                    }
                })
            },
            'cita.hora_cita': function () {
                this.horarios_disponibles.forEach(e => {
                    // if (e.id == this.cita.hora_cita) {
                    //     this.resumen_cita.hora_cita = e.hora
                    // }
                    this.resumen_cita.hora_cita = `${this.cita.hora_cita} Horas`
                })
            }
        },
        methods: {
            cancelarSolicitud() {
                this.dialogRequisitos = false
                this.$router.push('/')
            },
            aceptarRequisitos() {
                let faltan_requisitos_obligatorios = false
                this.cita.requisitos.forEach(element => {
                    if (element.obligatorio == 1 && element.checked == '0') {
                        faltan_requisitos_obligatorios = true
                    }
                })
                if (faltan_requisitos_obligatorios) {
                    this.bandera_requisitos_obligatorios = true
                } else {
                    this.dialogRequisitos = false
                }
            },
            checkRequisito(requisito) {
                this.cita.requisitos.forEach(element => {
                    if (element.id == requisito.id) {
                        if (element.checked == '0') {
                            element.checked = '1'
                        } else {
                            element.checked = '0'
                        }
                    }
                })
            },
            volverInicio() {
                this.$router.push('/')
                this.cita.requisitos = []
            },
            seleccionarCentroAtencion() {
                // this.tramiteSeleccionado.centrosAtencion.forEach(e => {
                //     console.log("en foreach")
                //     console.log("e.id: ", e.id)
                //     console.log("e.nombre: ", e.nombre)
                //     console.log("this.cita.centro: ", this.cita.centro_atencion)
                //     if (e.id == this.cita.centro_atencion) {
                //         this.resumen_cita.centro_atencion = e.nombre
                //     }
                // })
                // this.mostrarPaso2 = true
                // this.panel = [1]
                // let tbodyRef = document.getElementById('calendar').getElementsByTagName('tbody')[0]
                // let tbodyRef = document.getElementById('calendar')
                // console.log("asdf", tbodyRef)

                // let row_semana_uno = tbodyRef.insertRow()
                // let cel_dia = row_semana_uno.insertCell()
                // let text = document.createTextNode('1')
                // cel_dia.appendChild(text)
            },
            async getCalendar() {
                try {
                    let response = await axios.get('/api/calendario-citas')
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.semana_uno = response.data.calendario_citas.semana_uno
                            this.semana_dos = response.data.calendario_citas.semana_dos
                            this.semana_tres = response.data.calendario_citas.semana_tres
                            this.semana_cuatro = response.data.calendario_citas.semana_cuatro
                            this.semana_cinco = response.data.calendario_citas.semana_cinco
                            this.semana_seis = response.data.calendario_citas.semana_seis

                            let tbodyCalendar = document.getElementById('calendar').getElementsByTagName('tbody')[0]
                            
                            let row_semana_uno = tbodyCalendar.insertRow()
                            row_semana_uno.id = 'row_semana_uno'
                            this.semana_uno.forEach(e => {
                                let cel_dia = row_semana_uno.insertCell()
                                let text = document.createTextNode(`${e.dia}`)
                                cel_dia.style.border = '1px solid #6a73a0'
                                cel_dia.style.height = '35px'
                                if (e.dia_disponible == true) {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                } else if (e.dia_sin_servicio == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                }
                                if (e.dia_sin_servicio == true) {
                                    cel_dia.style.backgroundColor = '#B20202'
                                    cel_dia.style.color = '#ffffff'
                                }
                                cel_dia.appendChild(text)
                            })

                            let row_semana_dos = tbodyCalendar.insertRow()
                            row_semana_dos.id = 'row_semana_dos'
                            this.semana_dos.forEach(e => {
                                let cel_dia = row_semana_dos.insertCell()
                                let text = document.createTextNode(`${e.dia}`)
                                cel_dia.style.border = '1px solid #6a73a0'
                                cel_dia.style.height = '35px'
                                if (e.dia_disponible == true) {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                } else if (e.dia_sin_servicio == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                }
                                if (e.dia_sin_servicio == true) {
                                    cel_dia.style.backgroundColor = '#B20202'
                                    cel_dia.style.color = '#ffffff'
                                }
                                cel_dia.appendChild(text)
                            })

                            let row_semana_tres = tbodyCalendar.insertRow()
                            row_semana_tres.id = 'row_semana_tres'
                            this.semana_tres.forEach(e => {
                                let cel_dia = row_semana_tres.insertCell()
                                let text = document.createTextNode(`${e.dia}`)
                                cel_dia.style.border = '1px solid #6a73a0'
                                cel_dia.style.height = '35px'
                                if (e.dia_disponible == true) {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                } else if (e.dia_sin_servicio == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                }
                                if (e.dia_sin_servicio == true) {
                                    cel_dia.style.backgroundColor = '#B20202'
                                    cel_dia.style.color = '#ffffff'
                                }
                                cel_dia.appendChild(text)
                            })

                            let row_semana_cuatro = tbodyCalendar.insertRow()
                            row_semana_cuatro.id = 'row_semana_cuatro'
                            this.semana_cuatro.forEach(e => {
                                let cel_dia = row_semana_cuatro.insertCell()
                                let text = document.createTextNode(`${e.dia}`)
                                cel_dia.style.border = '1px solid #6a73a0'
                                cel_dia.style.height = '35px'
                                if (e.dia_disponible == true) {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                } else if (e.dia_sin_servicio == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                }
                                if (e.dia_sin_servicio == true) {
                                    cel_dia.style.backgroundColor = '#B20202'
                                    cel_dia.style.color = '#ffffff'
                                }
                                cel_dia.appendChild(text)
                            })

                            let row_semana_cinco = tbodyCalendar.insertRow()
                            row_semana_cinco.id = 'row_semana_cinco'
                            this.semana_cinco.forEach(e => {
                                let cel_dia = row_semana_cinco.insertCell()
                                let text = document.createTextNode(`${e.dia}`)
                                
                                cel_dia.appendChild(text)

                                cel_dia.style.border = '1px solid #6a73a0'
                                cel_dia.style.height = '35px'
                                if (e.dia_disponible == true) {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                    cel_dia.onclick = function () {
                                        document.getElementById('span_dia_cita').innerText = `${e.fecha_formateada}`
                                        document.getElementById('input_aux_dia_cita').value = e.fecha_completa
                                        document.getElementById('input_aux_fecha_formateada').value = e.fecha_formateada
                                    }
                                } else if (e.dia_sin_servicio == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                }
                                if (e.dia_sin_servicio == true) {
                                    cel_dia.style.backgroundColor = '#B20202'
                                    cel_dia.style.color = '#ffffff'
                                }
                            })

                            let row_semana_seis = tbodyCalendar.insertRow()
                            row_semana_seis.id = 'row_semana_seis'
                            this.semana_seis.forEach(e => {
                                let cel_dia = row_semana_seis.insertCell()
                                let text = document.createTextNode(`${e.dia}`)
                                cel_dia.style.border = '1px solid #6a73a0'
                                cel_dia.style.height = '35px'
                                if (e.dia_disponible == true) {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                    // cel_dia.addEventListener('click', this.seleccionarDia(e))
                                } else if (e.dia_sin_servicio == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                }
                                if (e.dia_sin_servicio == true) {
                                    cel_dia.style.backgroundColor = '#B20202'
                                    cel_dia.style.color = '#ffffff'
                                }
                                cel_dia.appendChild(text)
                            })
                        } else {
                            errorSweetAlert(`${response.data.message}<br>Error: ${response.data.error}<br>Location: ${response.data.location}<br>Line: ${response.data.line}`)
                        }
                    } else {
                        errorSweetAlert('Ocurrió un error al obtener el calendario de citas disponibles.')
                    }
                } catch (error) {
                    errorSweetAlert('Ocurrió un error al obtener el calendario de citas disponibles.')
                }
            },
            agendarCita() {
                this.cita.dia_cita = document.getElementById('input_aux_dia_cita').value
                this.cita.fecha_formateada = document.getElementById('input_aux_fecha_formateada').value
                this.cita.tramite = this.tramiteSeleccionado.id
                // if (valid) {
                    Swal.fire({
                        title: '¿Confirma para agendar la cita?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085D6',
                        cancelButtonColor: '#D33',
                        confirmButtonText: 'Si, agendar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: async () => {
                            try {
                                let response = await axios.post('/api/citas/agendar-cita', this.cita)
                                return response
                            } catch (error) {
                                errorSweetAlert('Ocurrió un error al agendar la cita.')
                            }
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (result.value.status === 200) {
                                if (result.value.data.status === "ok") {
                                    this.$store.commit('setCitaAgendada', result.value.data.cita_agendada)
                                    this.$router.push('/confirmacion-cita')
                                } else {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al agendar la cita.')
                            }
                        }
                    })
                // }
            }
        },
    })
</script>

<style scoped>
    .contenedor {
        padding: 0!important;
    }

    .contenedor-uno {
        border-style: none solid solid none;
        border-color: #adadad;
        border-width: 2px;
        padding: 0!important;
        height: 100px;
    }

    .contenedor-dos {
        border-style: none none solid none;
        border-color: #adadad;
        border-width: 2px;
        padding: 0!important;
        height: 100px;
    }

    .contenedor-tres {
        border-style: none solid none none;
        border-color: #adadad;
        border-width: 2px;
        padding: 0!important;
    }

    .contenedor-cuatro {
        padding: 0!important;
    }

    .scale-logo-defensoria {
        transform: scale(1.8);
    }

    .titulo_tipo_tramite {
        font-size: 20px;
        font-weight: bold;
        font-family: 'Lato', sans-serif;
    }

    .espacio-blanco {
        height: 93px;
    }

    .titulo-resumen-cita {
        font-size: 40;
        font-weight: bold;
    }

    .campo-obligatorio {
        color: red;
    }

    .titulo-modal-requisitos {
        font-family: 'Lato', sans-serif;
        font-weight: bold;
        font-size: 18pt;
        text-align: center;

    }

    .first-line {
        background-color: #6a73a0;
        height: 3px;
        width: 560px;
    }

    .texto-saludo {
        font-family: 'Lato', sans-serif;
        font-size: 14pt;
        margin-bottom: 8px;
    }

    .second-line {
        background-color: #a4bc4b;
        height: 3px;
        width: 560px;;
    }

    .texto-instrucciones {
        font-family: 'Lato', sans-serif;
        font-size: 12pt;
        margin-bottom: 4px
    }

    .encabezado-tabla-requisitos {
        background-color: #6a73a0;   
    }

    .texto-encabezado-tabla-requisitos {
        color: white;
        font-family: 'Lato', sans-serif;
        font-weight: 900;
        font-size: 13pt;
    }

    .texto-requisito-tabla {
        font-family: 'Lato', sans-serif;
        font-size: 12pt;
    }

    .ultimos-textos-modal-requisitos {
        font-family: 'Lato', sans-serif;
        font-size: 12pt;
        margin-top: 10px;
    }

    .texto-click-aqui {
        color: #6a73a0;
    }

    .texto-click-aqui:hover {
        cursor: pointer;
    }

    .texto-requisitos-obligatorios {
        color: #6a73a0;
    }

    .texto-faltan-requisitos-obligatorios {
        color: red;
        font-weight: bold;
    }

    .third-line {
        background-color: #a4bc4b;
        height: 2px;
        width: 560px;
        margin-bottom: 6px;
        margin-top: 6px;
    }

    .boton-cancelar {
        background-color: #6a73a0;
        color: white;
        font-family: 'Lato', sans-serif;
        font-size: 12pt;
        font-weight: bold;
        padding: 6px 10px;
        margin-right: 15px;
        border-radius: 20px;
    }

    .boton-aceptar {
        background-color: #a4bc4b;
        color: white;
        font-family: 'Lato', sans-serif;
        font-size: 12pt;
        font-weight: bold;
        padding: 6px 10px;
        margin-left: 15px;
        border-radius: 20px;
    }

    .titulo-nombre-tramite {
        font-family: 'Lato', sans-serif;
        font-size: 30pt;
        font-weight: 900;
        line-height: 40px;
        text-align: center;
        padding: 20px;
    }

    .texto-estatico-resumen-cita {
        font-family: 'Lato', sans-serif;
        font-weight: bold;
        font-size: 16pt;
    }

    .texto-dinamico-resumen-cita {
        font-family: 'Lato', sans-serif;
        font-weight: 900;
        font-size: 10pt;
        color: #8c8c8c;
    }
    
    .texto-pasos {
        font-family: 'Lato', sans-serif;
        font-size: 14pt;
        font-weight: 900;
    }

    .texto-nombre-paso {
        font-family: 'Lato', sans-serif;
        font-size: 16pt;
        font-weight: 300;
    }

    .texto-ubicacion-centros {
        font-family: 'Lato', sans-serif;
        font-size: 10pt;
        background-color: #e5e5e5;
        padding: 7px 10px 7px 10px;
        border-radius: 5px;
    }

    .calendar-header {
        border-style: solid;
        border-color: #6a73a0;
        border-width: 2px;
    }

    .calendar-month {
        font-family: 'Lato', sans-serif;
        font-size: 14pt;
        font-weight: bold;
        text-transform: uppercase;
        width: 70%;
    }

    .previous-month {
        width: 15%;
    }

    .next-month {
        width: 15%;
    }

    .tr-header {
        height: 40px;
    }

    .calendar-day-name {
        width: 14.28%;
        text-transform: uppercase;
        background-color: #6a73a0;
        color: white;
        font-family: 'Lato', sans-serif;
        font-weight: 100;
        font-size: 10pt;
        padding: 2px 2px;
        border-width: 1px;
        border-style: solid;
        border-color: #8c8c8c;
    }

    .celDia {
        color: white;
        background-color: black;
    }
</style>