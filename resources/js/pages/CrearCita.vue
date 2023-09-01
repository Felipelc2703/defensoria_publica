<template>
    <div class="m-0">
        <div class="row contenedor">
            <div class="col-sm-9 col-12 contenedor-uno">
                <div class="text-center py-2">
                    <img class="scale-logo-defensoria logo-defensoria" width="150" height="75" src="../../../public/images/defensoria-publica-titulo.svg" alt="">
                </div>
            </div>
            <div class="col-sm-3 hidden-xs contenedor-dos">
                <p class="titulo-nombre-tramite">Resumen de cita:</p>
            </div>
            <div class="w-100"></div>
            <div class="col-sm-9 col-12 contenedor-tres">
                <div class="text-center mt-4 mb-4 ml-10 mr-10">
                    <div class="container">
                        <div class="row justify-content-around">
                            <div class="col-6 text-left">
                                <p class="titulo_tipo_tramite">{{tramiteSeleccionado.nombre}}</p>
                            </div>
                            <div class="col-6 text-right">
                                <v-btn class="boton-regresar" variant="text" prepend-icon="mdi-arrow-left" @click="volverInicio()">Regresar</v-btn>
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
                                                    <p class="text-left m-0">Si requiere conocer la ubicación de cada uno de los lugares donde puede realizar el trámite, de <span class="texto-click-aqui" @click="mostrarUbicacionCentrosAtencion()">click aquí</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                                <v-expansion-panel v-if="mostrarPaso2" @click="dibujarCalendario()">
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
                                        <div class="row  justify-content-between mt-4">
                                            <div class="col-md-1 col-12 text-center"></div>
                                            <div class="col-md-8 col-12 text-center">
                                                <table class="m-0 w-100" id="calendar">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="7">
                                                                <table class="w-100 calendar-header">
                                                                    <tbody>
                                                                        <tr class="tr-header">
                                                                            <td class="previous-month" @click="previousMonth()" v-if="bandera_mes_actual && showPrevious"><span>&lt;</span></td>
                                                                            <td class="calendar-month">{{fecha_calendario.mes}} de {{fecha_calendario.año}}</td>
                                                                            <td class="next-month" @click="nextMont()" v-if="showNext"><span>&gt;</span></td>
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
                                                <div class="row justify-content-between">
                                                    <div class="col-md-6 col-12 mt-2 text-left">
                                                        <span class="cuadro-disponible">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <span>Día disponible</span>
                                                    </div>
                                                    <div class="col-md-6 col-12 mt-2 text-left">
                                                        <span class="cuadro-no-disponible">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <span>Día sin disponibilidad</span>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col-md-6 col-12 mt-2 text-left">
                                                        <span class="cuadro-sin-servicio">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <span>Día sin servicio</span>
                                                    </div>
                                                    <div class="col-md-6 col-12 mt-2 text-left">
                                                        <span class="cuadro-pasados-disponibles">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                        <span>Días pasados disponibles</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-12 text-center"></div>
                                        </div>
                                        <div class="row justify-content-between mt-5">
                                            <div class="col-md-1 col-12"></div>
                                            <div class="col-md-8 col-12 select-horario">
                                                <v-select
                                                    v-model="cita.hora_cita"
                                                    label="Seleccione el horario"
                                                    :items="horarios_disponibles"
                                                    item-title="hora_inicio"
                                                    item-value="id"
                                                    variant="outlined"
                                                ></v-select>
                                                <div class="texto-ubicacion-centros">
                                                    <p class="text-left m-0">Estimado usuario: Se informa que las citas se habilitan una semana antes de que inicie el siguiente mes.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-12"></div>
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
                                                        <v-form class="col-12 mt-4 mb-4" ref="form">
                                                            <v-text-field
                                                                v-model="cita.nombre"
                                                                label="Nombre"
                                                                :rules="nombreRules"
                                                            ></v-text-field>
                                                            <v-text-field
                                                                v-model="cita.email"
                                                                label="Correo Electrónico"
                                                                :rules="[rules.email]"
                                                            ></v-text-field>
                                                            <div class="row justify-content-between">
                                                                <div class="col-sm-6 col-12">
                                                                    <v-text-field
                                                                        v-model="cita.telefono"
                                                                        label="Teléfono"
                                                                        :rules="[rules.tel]"
                                                                        maxlength="10"
                                                                    ></v-text-field>
                                                                </div>
                                                                <div class="col-sm-6 col-12">
                                                                    <v-select
                                                                        v-model="cita.sexo"
                                                                        label="Seleccione el sexo"
                                                                        :items="['Hombre', 'Mujer']"
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
                                                                        :rules="tieneDiscapacidadRules"
                                                                    ></v-select>
                                                                </div>
                                                                <div class="col-sm-6 col-12">
                                                                    <v-select
                                                                        v-if="cita.tiene_discapacidad == 'Si'"
                                                                        v-model="cita.discapacidad"
                                                                        label="¿Cuál?"
                                                                        :items="['Motriz', 'Auditiva', 'Visual', 'Intelectual', 'Psicosocial']"
                                                                    ></v-select>
                                                                </div>
                                                            </div>
                                                            <div class="row justify-content-between">
                                                                <div class="col-sm-6 col-12">
                                                                    <v-text-field
                                                                        v-model="cita.curp"
                                                                        label="Curp"
                                                                        :rules="[rules.curp]"
                                                                        
                                                                    ></v-text-field>
                                                                    <a class="boton_inicio" @click="irCurp()">CONSULTE SU CURP AQUÍ</a>
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
            <div class="col-sm-3 hidden-xs contenedor-cuatro">
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
                            <span id="span_dia_cita" class="texto-dinamico-resumen-cita">{{resumen_cita.dia_cita}}</span>
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
            <div class="col-12 hidden-sm hidden-md hidden-lg hidden-xl contenedor-dos">
                <p class="titulo-nombre-tramite">Resumen de cita:</p>
            </div>
            <div class="col-sm-3 hidden-sm hidden-md hidden-lg hidden-xl contenedor-cuatro">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <span class="texto-estatico-resumen-cita">Centro de Atención:</span>
                            <br>
                            <span class="texto-dinamico-resumen-cita">{{resumen_cita.centro_atencion}}</span>
                            <br>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <span class="texto-estatico-resumen-cita">Día de la Cita:</span>
                            <br>
                            <span id="span_dia_cita" class="texto-dinamico-resumen-cita">{{resumen_cita.dia_cita}}</span>
                            <br>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
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

        <v-dialog
            v-model="dialogCentrosAtencion"
            max-width="600px"
        >
            <v-card>
                <v-card-title class="text-center">
                    <span class="titulo-modal-requisitos">Sistema de Citas</span>
                    <div class="first-line"></div>
                </v-card-title>
                <div class="container mb-2">
                    <p class="texto-saludo"><span class="">Ubicación de Centros de Atención:</span></p>
                    <div class="second-line"></div>
                    <table class="mt-2 table table-striped table-sm">
                        <thead>
                            <tr class="encabezado-tabla-centros-atencion">
                                <th class="text-center texto-encabezado-tabla-centros-atencion">Centro de atención</th>
                                <th class="text-center texto-encabezado-tabla-centros-atencion">Domicilio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(centro, index) in tramiteSeleccionado.centrosAtencion" :key="index">
                                <td><span class="texto-requisito-tabla">{{centro.nombre}}</span></td>
                                <td><span>{{centro.direccion}}</span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="third-line"></div>
                </div>
                <v-card-actions class="mb-4">
                    <v-spacer></v-spacer>
                    <button class="boton-aceptar" @click="dialogCentrosAtencion = false">Cerrar</button>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { errorSweetAlert, successSweetAlert, warningSweetAlert } from './../helpers/sweetAlertGlobals'

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
                    dia: '',
                    horario: '',
                    curp:'',
                },
                nombreRules: [
                    v => !!v || 'El nombre es requerido'
                ],
                telefonoRules: [
                    v => !!v || 'El telefono es requerido',
                ],
                sexoRules: [
                    v => !!v || 'El sexo es requerido',
                ],
                tieneDiscapacidadRules: [
                    v => !!v || 'Seleccione una opción',
                ],
                discapacidadRules: [
                    v => !!v || 'Seleccione una opción',
                ],
                rules:{
                    email: value => {
                        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                        return pattern.test(value) || 'El campo no contiene un correo electrónico valido'
                    },

                    tel: value =>{
                        const pattern = (/^[0-9]{10}$/)
                        return pattern.test(value) || 'El campo no contiene un número valido'

                    },
                    curp: value =>{
                        const pattern = /^([A-Z&]|[a-z&]{1})([AEIOU]|[aeiou]{1})([A-Z&]|[a-z&]{1})([A-Z&]|[a-z&]{1})([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])([HM]|[hm]{1})([AS|as|BC|bc|BS|bs|CC|cc|CS|cs|CH|ch|CL|cl|CM|cm|DF|df|DG|dg|GT|gt|GR|gr|HG|hg|JC|jc|MC|mc|MN|mn|MS|ms|NT|nt|NL|nl|OC|oc|PL|pl|QT|qt|QR|qr|SP|sp|SL|sl|SR|sr|TC|tc|TS|ts|TL|tl|VZ|vz|YN|yn|ZS|zs|NE|ne]{2})([^A|a|E|e|I|i|O|o|U|u]{1})([^A|a|E|e|I|i|O|o|U|u]{1})([^A|a|E|e|I|i|O|o|U|u]{1})([A-Z&]|[a-z&]|[0-9]{1})([0-9]{1})$/
                        return pattern.test(value) || 'El campo no contiene una curp valida'

                    },

                },
                resumen_cita: {
                    centro_atencion: '',
                    dia_cita: '',
                    hora_cita: '',
                },
                horarios_disponibles: [],
                bandera_requisitos_obligatorios: false,
                panel: [0],
                mostrarPaso2: false,
                mostrarPaso3: false,
                dialogRequisitos: true,
                semana_uno: [],
                semana_dos: [],
                semana_tres: [],
                semana_cuatro: [],
                semana_cinco: [],
                semana_seis: [],
                dialogCentrosAtencion: false,
                variables_calendario: {
                    centro_atencion_id: null,
                    mes: null,
                    year: null,
                },
                fecha_calendario: {
                    mes: '',
                    año: '',
                    numero_mes: ''
                },
                bandera_mes_actual: false,
                showPrevious: true,
                showNext: true,
            }
        },
        created() {
            // this.cita.requisitos = this.tramiteSeleccionado.requisitos
            this.cita.requisitos = this.tramiteSeleccionado.requisitos
            this.cita.requisitos.forEach(element => {
                element.checked = '0'
            })
            let date = new Date()
            this.fecha_calendario.numero_mes = date.getMonth() + 1
            this.fecha_calendario.mes = this.formatearMes(date.getMonth() + 1)
            this.fecha_calendario.año = date.getFullYear()
        },
        computed: {
            tramiteSeleccionado() {
                return this.$store.getters.getTramiteSeleccionado
            },
        },
        watch: {
            'cita.centro_atencion': function () {
                this.variables_calendario.centro_atencion_id = this.cita.centro_atencion
                this.variables_calendario.mes = new Date().getMonth() + 1
                this.variables_calendario.year = new Date().getFullYear()
                this.getCalendar()
                this.tramiteSeleccionado.centrosAtencion.forEach(e => {
                    if (e.id == this.cita.centro_atencion) {
                        this.resumen_cita.centro_atencion = e.nombre
                    }
                })
                this.mostrarPaso2 = true
                this.panel = [1]
                setTimeout(() => {
                    this.dibujarCalendario()
                }, "500")
            },
            'cita.dia_cita': function () {
                this.resumen_cita.dia_cita = this.cita.fecha_formateada
            },
            'cita.hora_cita': function () {
                this.horarios_disponibles.forEach(e => {
                    if (this.cita.hora_cita == e.id) {
                        this.resumen_cita.hora_cita = ''
                        this.resumen_cita.hora_cita = `${e.hora_inicio} Horas`
                        this.cita.horario = e.hora_inicio
                    }
                })
                this.mostrarPaso3 = true
                this.panel = [2]
                this.showNext = true
                this.showPrevious = true
            },
        },
        methods: {
            irCurp() {
                window.open("https://www.gob.mx/curp/")
            },
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
            mostrarUbicacionCentrosAtencion() {
                this.dialogCentrosAtencion = true
            },
            async getCalendar() {
                try {
                    let response = await axios.post('/api/calendario-citas', this.variables_calendario)
                    if (response.status === 200) {
                        if (response.data.status === "ok") {
                            this.semana_uno = response.data.calendario_citas.semana_uno
                            this.semana_dos = response.data.calendario_citas.semana_dos
                            this.semana_tres = response.data.calendario_citas.semana_tres
                            this.semana_cuatro = response.data.calendario_citas.semana_cuatro
                            this.semana_cinco = response.data.calendario_citas.semana_cinco
                            this.semana_seis = response.data.calendario_citas.semana_seis
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
            dibujarCalendario() {
                this.showNext = false
                this.showPrevious = false
                let band = 0 
                setTimeout(() => {
                    
                    if (!document.getElementById('row_semana_uno')) {
    
                        let tbodyCalendar = document.getElementById('calendar').getElementsByTagName('tbody')[0]
                                    
                        let row_semana_uno = tbodyCalendar.insertRow()
                        row_semana_uno.id = 'row_semana_uno'
                        this.semana_uno.forEach(e => {
                            let cel_dia = row_semana_uno.insertCell()
                            let text = document.createTextNode(`${e.dia}`)
                            cel_dia.style.border = '1px solid #6a73a0'
                            cel_dia.style.height = '35px'

                            if(e.dia_sin_servicio == true) {
                                cel_dia.style.backgroundColor = '#B20202'
                                cel_dia.style.color = '#ffffff'
                            } else {
                                if(e.dia_disponible == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                } else {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                    cel_dia.onclick = () => {
                                        let dias_seleccionados = document.getElementsByClassName('eliminar-color')
                                        for (let item of dias_seleccionados) {
                                            item.style.backgroundColor = '#ffffff'
                                        }
                                        this.cita.hora_cita = ''
                                        this.resumen_cita.hora_cita = ''
                                        this.horarios_disponibles = e.horarios_disponibles
                                        this.cita.dia_cita = e.fecha_completa
                                        this.cita.fecha_formateada = e.fecha_formateada
                                        cel_dia.style.backgroundColor = '#CDCDD1'
                                        cel_dia.className = 'eliminar-color'
                                        setTimeout(() => {
                                            this.showNext = true
                                            this.showPrevious = true
                                        }, "200")
                                    }
                                }
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
                            
                            if(e.dia_sin_servicio == true) {
                                cel_dia.style.backgroundColor = '#B20202'
                                cel_dia.style.color = '#ffffff'
                            } else {
                                if(e.dia_disponible == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                } else {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                    cel_dia.onclick = () => {
                                        let dias_seleccionados = document.getElementsByClassName('eliminar-color')
                                        for (let item of dias_seleccionados) {
                                            item.style.backgroundColor = '#ffffff'
                                        }
                                        this.cita.hora_cita = ''
                                        this.resumen_cita.hora_cita = ''
                                        this.horarios_disponibles = e.horarios_disponibles
                                        this.cita.dia_cita = e.fecha_completa
                                        this.cita.fecha_formateada = e.fecha_formateada
                                        cel_dia.style.backgroundColor = '#CDCDD1'
                                        cel_dia.className = 'eliminar-color'
                                        setTimeout(() => {
                                            this.showNext = true
                                            this.showPrevious = true
                                        }, "200")
                                    }
                                }
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

                            if(e.dia_sin_servicio == true) {
                                cel_dia.style.backgroundColor = '#B20202'
                                cel_dia.style.color = '#ffffff'
                            } else {
                                if(e.dia_disponible == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                } else {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                    cel_dia.onclick = () => {
                                        let dias_seleccionados = document.getElementsByClassName('eliminar-color')
                                        for (let item of dias_seleccionados) {
                                            item.style.backgroundColor = '#ffffff'
                                        }
                                        this.cita.hora_cita = ''
                                        this.resumen_cita.hora_cita = ''
                                        this.horarios_disponibles = e.horarios_disponibles
                                        this.cita.dia_cita = e.fecha_completa
                                        this.cita.fecha_formateada = e.fecha_formateada
                                        cel_dia.style.backgroundColor = '#CDCDD1'
                                        cel_dia.className = 'eliminar-color'
                                        setTimeout(() => {
                                            this.showNext = true
                                            this.showPrevious = true
                                        }, "200")
                                    }
                                }
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

                            if(e.dia_sin_servicio == true) {
                                cel_dia.style.backgroundColor = '#B20202'
                                cel_dia.style.color = '#ffffff'
                            } else {
                                if(e.dia_disponible == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                } else {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                    cel_dia.onclick = () => {
                                        let dias_seleccionados = document.getElementsByClassName('eliminar-color')
                                        for (let item of dias_seleccionados) {
                                            item.style.backgroundColor = '#ffffff'
                                        }
                                        this.cita.hora_cita = ''
                                        this.resumen_cita.hora_cita = ''
                                        this.horarios_disponibles = e.horarios_disponibles
                                        this.cita.dia_cita = e.fecha_completa
                                        this.cita.fecha_formateada = e.fecha_formateada
                                        cel_dia.style.backgroundColor = '#CDCDD1'
                                        cel_dia.className = 'eliminar-color'
                                        setTimeout(() => {
                                            this.showNext = true
                                            this.showPrevious = true
                                        }, "200")
                                    }
                                }
                            }
                            cel_dia.appendChild(text)
                        })
        
                        let row_semana_cinco = tbodyCalendar.insertRow()
                        row_semana_cinco.id = 'row_semana_cinco'
                        this.semana_cinco.forEach(e => {
                            let cel_dia = row_semana_cinco.insertCell()
                            let text = document.createTextNode(`${e.dia}`)
                            cel_dia.style.border = '1px solid #6a73a0'
                            cel_dia.style.height = '35px'

                            if(e.dia_sin_servicio == true) {
                                cel_dia.style.backgroundColor = '#B20202'
                                cel_dia.style.color = '#ffffff'
                            } else {
                                if(e.dia_disponible == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                } else {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                    cel_dia.onclick = () => {
                                        let dias_seleccionados = document.getElementsByClassName('eliminar-color')
                                        for (let item of dias_seleccionados) {
                                            item.style.backgroundColor = '#ffffff'
                                        }
                                        this.cita.hora_cita = ''
                                        this.resumen_cita.hora_cita = ''
                                        this.horarios_disponibles = e.horarios_disponibles
                                        this.cita.dia_cita = e.fecha_completa
                                        this.cita.fecha_formateada = e.fecha_formateada
                                        cel_dia.style.backgroundColor = '#CDCDD1'
                                        cel_dia.className = 'eliminar-color'
                                        setTimeout(() => {
                                            this.showNext = true
                                            this.showPrevious = true
                                        }, "200")
                                    }
                                }
                            }
                            cel_dia.appendChild(text)
                        })
        
                        let row_semana_seis = tbodyCalendar.insertRow()
                        row_semana_seis.id = 'row_semana_seis'
                        this.semana_seis.forEach(e => {
                            let cel_dia = row_semana_seis.insertCell()
                            let text = document.createTextNode(`${e.dia}`)
                            cel_dia.style.border = '1px solid #6a73a0'
                            cel_dia.style.height = '35px'

                            if(e.dia_sin_servicio == true) {
                                cel_dia.style.backgroundColor = '#B20202'
                                cel_dia.style.color = '#ffffff'
                            } else {
                                if(e.dia_disponible == false) {
                                    cel_dia.style.backgroundColor = '#b1bced'
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                } else {
                                    cel_dia.style.cursor = 'pointer';
                                    cel_dia.style.fontFamily = 'Lato, sans-serif'
                                    cel_dia.style.fontWeight = 'bold'
                                    cel_dia.onclick = () => {
                                        let dias_seleccionados = document.getElementsByClassName('eliminar-color')
                                        for (let item of dias_seleccionados) {
                                            item.style.backgroundColor = '#ffffff'
                                        }
                                        this.cita.hora_cita = ''
                                        this.resumen_cita.hora_cita = ''
                                        this.horarios_disponibles = e.horarios_disponibles
                                        this.cita.dia_cita = e.fecha_completa
                                        this.cita.fecha_formateada = e.fecha_formateada
                                        cel_dia.style.backgroundColor = '#CDCDD1'
                                        cel_dia.className = 'eliminar-color'
                                        setTimeout(() => {
                                            this.showNext = true
                                            this.showPrevious = true
                                        }, "200")
                                    }
                                }
                            }
                            cel_dia.appendChild(text)
                        })
                        this.showNext = true
                        this.showPrevious = true
                    }
                }, "500")
            },
            limpiarCalendario() {
                let node_1 = document.getElementById('row_semana_uno')
                node_1.parentElement.removeChild(node_1)
                let node_2 = document.getElementById('row_semana_dos')
                node_2.parentElement.removeChild(node_2)
                let node_3 = document.getElementById('row_semana_tres')
                node_3.parentElement.removeChild(node_3)
                let node_4 = document.getElementById('row_semana_cuatro')
                node_4.parentElement.removeChild(node_4)
                let node_5 = document.getElementById('row_semana_cinco')
                node_5.parentElement.removeChild(node_5)
                let node_6 = document.getElementById('row_semana_seis')
                node_6.parentElement.removeChild(node_6)
            },
            formatearMes(mes) {
                let nombre_mes = ''
                switch (mes) {
                    case 1:
                    nombre_mes = 'Enero';
                    break;
                case 2:
                    nombre_mes = 'Febrero';
                    break;
                case 3:
                    nombre_mes = 'Marzo';
                    break;
                case 4:
                    nombre_mes = 'Abril';
                    break;
                case 5:
                    nombre_mes = 'Mayo';
                    break;
                case 6:
                    nombre_mes = 'Junio';
                    break;
                case 7:
                    nombre_mes = 'Julio';
                    break;
                case 8:
                    nombre_mes = 'Agosto';
                    break;
                case 9:
                    nombre_mes = 'Septiembre';
                    break;
                case 10:
                    nombre_mes = 'Octubre';
                    break;
                case 11:
                    nombre_mes = 'Noviembre';
                    break;
                case 12:
                    nombre_mes = 'Diciembre';
                    break;
                }
                return nombre_mes
            },
            previousMonth() {
                let current_date = new Date()
                if (this.fecha_calendario.numero_mes == 1) {
                    this.fecha_calendario.numero_mes = 12
                    this.fecha_calendario.año--
                } else {
                    this.fecha_calendario.numero_mes--
                }
                this.fecha_calendario.mes = this.formatearMes(this.fecha_calendario.numero_mes)
                this.variables_calendario.mes = this.fecha_calendario.numero_mes
                this.variables_calendario.year = this.fecha_calendario.año
                this.getCalendar()
                this.limpiarCalendario()
                if (this.fecha_calendario.numero_mes == (current_date.getMonth()+1) && this.fecha_calendario.año == current_date.getFullYear()) {
                    this.bandera_mes_actual = false
                }
            },
            nextMont() {
                let current_date = new Date()
                if (this.fecha_calendario.numero_mes == 12) {
                    this.fecha_calendario.numero_mes = 1
                    this.fecha_calendario.año++
                } else {
                    this.fecha_calendario.numero_mes++
                }
                this.fecha_calendario.mes = this.formatearMes(this.fecha_calendario.numero_mes)
                this.variables_calendario.mes = this.fecha_calendario.numero_mes
                this.variables_calendario.year = this.fecha_calendario.año
                this.getCalendar()
                this.limpiarCalendario()
                if ((this.fecha_calendario.numero_mes > current_date.getMonth()+1 && this.fecha_calendario.año == current_date.getFullYear()) || (this.fecha_calendario.año < current_date.getFullYear())) {
                    this.bandera_mes_actual = true
                }
            },
            async agendarCita() {
                this.cita.tramite = this.tramiteSeleccionado.id
                console.log(this.cita)
                const { valid } = await this.$refs.form.validate()
                if (valid) {
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
                                }else if(result.value.data.status === "no_data") {
                                        warningSweetAlert(result.value.data.message)
                                
                                } else  {
                                    errorSweetAlert(`${result.value.data.message}<br>Error: ${result.value.data.error}<br>Location: ${result.value.data.location}<br>Line: ${result.value.data.line}`)
                                }
                            } else {
                                errorSweetAlert('Ocurrió un error al agendar la cita.')
                            }
                        }
                    })
                }
            },
        },
    })
</script>