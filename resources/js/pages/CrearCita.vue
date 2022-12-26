<template>
    <div>
        <v-dialog
            v-model="dialogRequisitos"
            max-width="800px"
        >
            <v-card>
                <v-card-title>
                    Sistema de Citas
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <div class="m-1">
                        <p><span>Estimado ciudadano:</span></p>
                        <v-divider></v-divider>
                        <p>A continuación se muestran los requisitos que deberá presentar ante el Centro de Atención para realizar el trámite; favor de seleccionar aquéllos con los que cuenta:</p>
                        <v-card class="mb-14">
                            <v-toolbar color="#691C32">
                                <v-toolbar-title class="text-white">Requisitos</v-toolbar-title>
                            </v-toolbar>
                            <v-list lines="three" select-strategy="multiple">
                                <v-list-item value="notifications">
                                    <v-list-item-title>Acta de matrimonio (en su caso de existir).</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Notify me about updates to apps or games that I downloaded
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="sound">
                                    

                                    <v-list-item-title>Acta de nacimiento de sus hijos.</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Auto-update apps at any time. Data charges may apply
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="domicilio">

                                    <v-list-item-title>Domicilio de la persona que se va a demandar (calle, número, colonia).</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Automatically add home screen widgets when downloads complete
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="testigos">

                                    <v-list-item-title>Nombre y domicilio de 2 testigos con copia de credencial de elector, (pueden ser familiares y una vez propuestos no los puede cambiar) traerlos a los testigos hasta que se les indique</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Automatically add home screen widgets when downloads complete
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>

                                <v-list-item value="hechos">

                                    <v-list-item-title>Descripción detallada de los hechos (por escritos señalando circunstancia de tiempo, modo y lugar)</v-list-item-title>

                                    <!-- <v-list-item-subtitle>
                                    Automatically add home screen widgets when downloads complete
                                    </v-list-item-subtitle> -->

                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action end>
                                            <v-checkbox-btn :model-value="isActive"></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                </v-list-item>
                            </v-list>
                        </v-card>
                        <p>Si usted ya cuenta con una cita agendada y desea consultarla, dé click aquí. Todos los trámites son personales. Para verificar las especificaciones de los requisitos dé click <span class="text-red">aquí</span>.</p>
                    </div>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="cancelar()"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        variant="flat"
                        color="error"
                        @click="aceptar()"
                    >
                        Aceptar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <div class="row justify-content-between">
            <div class="col-sm-9 col-12 border-uno">
                <div class="text-center border-dos py-2">
                    <img class="scale-logo-defensoria" width="200" height="75" src="../../../public/images/logo_defensoria_publica.svg" alt="">
                </div>
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
                            <v-expansion-panels>
                                <v-expansion-panel>
                                    <v-expansion-panel-title v-slot="{ open }">
                                        <v-row no-gutters>
                                            <v-col cols="8" class="d-flex justify-start">
                                                PASO 1: Seleccione el centro de atención
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
                                        <v-row no-gutters>
                                            <v-col cols="6">
                                                <v-select
                                                    v-model="trip.location"
                                                    :items="locations"
                                                    flat
                                                    variant="underlined"
                                                >
                                                </v-select>
                                            </v-col>

                                            <v-divider vertical class="mx-4"></v-divider>

                                            <v-col cols="4">
                                                Si requiere conocer la ubicación de cada uno de los lugares donde puede realizar el trámite, 
                                                <br>
                                                <a href="#"> de click aqui</a>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                                <v-expansion-panel>
                                    <v-expansion-panel-title v-slot="{ open }">
                                        <v-row no-gutters>
                                            <v-col cols="8" class="d-flex justify-start">
                                                PASO 2: Seleccione la fecha y hora de la cita 
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
                                        <v-row justify="space-around" no-gutters>
                                            <v-col cols="10">
                                                Fecha:
                                                <div id="calendario">
                                                        <div id="posterior" onclick="mesdespues()">-></div>
                                                        <h2 id="titulos">Diciembre 2022</h2>
                                                        <table id="diasc">
                                                            <tr id="fila0"><th>Dom</th><th>Lun</th><th>Mar</th><th>Mier</th><th>Jue</th><th>Vie</th><th>Sabado</th></tr>
                                                            <tr id="fila1"><td id="dia" onclick="dia()"></td><td id="dia" onclick="dia()"></td><td></td><td></td><td>1</td><td>2</td><td>3</td></tr>
                                                            <tr id="fila2"><td id="dia" onclick="dia()">4</td><td id="dia" onclick="dia()">5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td></tr>
                                                            <tr id="fila3"><td id="dia" onclick="dia()">11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td></tr>
                                                            <tr id="fila4"><td id="dia" onclick="dia()">18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td></tr>
                                                            <tr id="fila5"><td id="dia" onclick="dia()">25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td></tr>
                                                            <tr id="fila6"><td id="dia" onclick="dia()"></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                                                        </table>                                                            
                                                        </div>
                                                
                                            </v-col>
                                            <v-col cols="2">
                                                Hora:
                                                <v-select
                                                v-model="trip.Hour"
                                                :items="Hour"
                                                flat
                                                variant="underlined"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                                <v-expansion-panel>
                                    <v-expansion-panel-title>
                                        <template v-slot:default="{ expanded }">
                                            <v-row no-gutters>
                                                <v-col cols="8" class="d-flex justify-start">
                                                PASO 3: Ingrese los datos del solicitante 
                                                </v-col>
                                                <v-col
                                                cols="8"
                                                class="text-grey"
                                                >
                                                <v-fade-transition leave-absolute>
                                                    <span
                                                    v-if="expanded"
                                                    key="0"
                                                    >
                                                    </span>
                                                    <span
                                                    v-else
                                                    key="1"
                                                    >
                                                    </span>
                                                </v-fade-transition>
                                                </v-col>
                                            </v-row>
                                        </template>
                                    </v-expansion-panel-title>
                                    <v-expansion-panel-text>
                                        <v-form ref="form">
                                            Nombre:*
                                            <v-text-field
                                                ref="name"
                                                v-model="name"
                                                :rules="[rules.required]"
                                                variant="underlined"
                                            ></v-text-field>
                                            Correo Electrónico:*
                                            <v-text-field
                                                ref="email"
                                                v-model="email"
                                                :rules="[rules.required, rules.email]"
                                                variant="underlined"
                                            ></v-text-field>
                                            Teléfono:*
                                            <v-text-field
                                                counter="10"
                                                maxlength="10"
                                                ref="tel"
                                                v-model="tel"
                                                :rules="[rules.required]"
                                                variant="underlined"
                                            ></v-text-field>
                                            Seleccione sexo:*
                                            <v-radio-group ref="sexo" v-model="sexo" inline :rules="[rules.required]">
                                                <v-radio
                                                    label="Masculino"
                                                    value="M"
                                                ></v-radio>
                                                <v-radio
                                                    label="Femenino"
                                                    value="F"
                                                ></v-radio>
                                            </v-radio-group>
                                            ¿Presenta alguna discapacidad?*
                                            <v-radio-group ref="disc" v-model="disc" inline :rules="[rules.required]">
                                                <v-radio label="Si" v-model="disc" value="si"></v-radio>
                                                <v-radio label="No" v-model="disc" value="no"></v-radio>
                                            </v-radio-group>
                                            <!--si la respuesta es si-->
                                            <v-select v-if="disc == 'si'" label="¿Cual?"
                                                v-model="trip.disca"
                                                :items="disca"
                                                flat
                                                variant="underlined"
                                                :rules="[rules.required]"
                                            ></v-select>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    color="primary"
                                                    variant="text"
                                                    @click="validar"
                                                >
                                                    Enviar
                                                </v-btn>
                                            </v-card-actions>
                                        </v-form> 
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-12">
                <div class="text-center py-2 espacio-blanco"></div>
                <div class="text-center mt-4 mb-4 ml-4 mr-4">
                    <div>
                        <fieldset class="text-left">
                            <legend><h2 class="titulo-resumen-cita">Resumen de Cita:</h2></legend>
                        </fieldset>
                        <div>
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <span class="texto-estatico-resumen-cita">Centro de Atención:</span>
                                    <br>
                                    <span class="texto-dinamico-resumen-cita"></span>
                                    <br>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <span class="texto-estatico-resumen-cita">Día de la Cita:</span>
                                    <br>
                                    <span class="texto-dinamico-resumen-cita"></span>
                                    <br>
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-left">
                                    <span class="texto-estatico-resumen-cita">Hora de la Cita:</span>
                                    <br>
                                    <span class="texto-dinamico-resumen-cita"></span>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
        * { margin: auto; }
        /*cabecera de la página*/
        h1 { text-align: center; padding: 0.5em; }
        /*div principal del calendario*/
        #calendario { border: 4px double black ; max-width: 536px; 
                    background-color:#fffafa; text-align: center; }
        /*tabla del calendario*/
        #diasc { border: 1px solid black; border-collapse: 
                separate; border-spacing: 4px; }
        #dia:hover{color: blue; text-decoration: underline; cursor: pointer ;}
        
        #diasc th,#diasc td { font: normal 14pt arial; width: 70px; height: 30px; }
        #diasc th { color: #990099; background-color: #5ecdec }
        #diasc td { color: #492736; background-color: #9bf5ff }
        
        #posterior { float: right; width: 100px; font: bold 12pt arial; 
                padding: 0.5em 0.1em; cursor: pointer ;}
        #posterior:hover {color: blue; text-decoration: underline;}
        #titulos { font: normal 20pt "arial black"; padding: 0.2em; }
</style>

<script>

    import { defineComponent } from 'vue'
    import { errorSweetAlert } from './../helpers/sweetAlertGlobals'

    export default defineComponent({
        name: 'crear-cita',
        data() {
            return {
                name: '',
                email: '',
                tel: '',
                sexo: null,
                disc: null,
                   
                trip: {
                    disca: null,
                },
                disca: ['Motriz', 'Auditiva', 'Visual', 'Intelectual', 'Psicosocial'],
                dialogRequisitos: true,
                trip: {
                    location: null,
                },
                locations: ['Dirección asuntos civiles, familiares y administrativos(Puebla Capital)', 'DISTRITO JUDICIAL ACATLÁN', 'DISTRITO JUDICIAL ALATRISTE', 'DISTRITO JUDICIAL ATLIXCO', 'DISTRITO JUDICIAL CHALCHICOMULA', 'DISTRITO JUDICIAL CHIAUTLA', 'DISTRITO JUDICIAL CHOLULA'],
                dialogRequisitos: true,    
                trip: {
                    Hour: null,
                },
                Hour: ['8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30'],
                dialogRequisitos: true,

                rules: {
                    required: value => !!value || 'Campo requerido',
                    email: value => {
                        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                        return pattern.test(value) || 'El campo no contiene un correo electrónico valido'
                    },
                },
            }
        },
        created() {
            console.log("tramite: ", this.tramiteSeleccionado)
            // prueba
        },
        computed: {
            tramiteSeleccionado() {
                return this.$store.getters.getTramiteSeleccionado
            }
        },
        methods: {
            dia: {
        dia: () => alert("¡Has hecho click!"),
        mouseleave: () => alert("¡Has sacado el ratón del botón!"),
        mousewheel: (event) => console.log("¡Has movido la rueda del ratón!", event.deltaY)
      },
            cancelar() {
                this.dialogRequisitos = false
                this.$router.push('/')
            },
            aceptar() {
              this.dialogRequisitos = false
            },
            async validar() {
                this.loading = true
                const { valid } = await this.$refs.form.validate()
                if (valid) {
                    try {
                        let response = await axios.post('/api/login', this.form)
                        if (response.status === 200) {
                            if (response.data.status === "ok") {
                                this.$store.dispatch('setToken', response.data.data.token)
                                this.$router.push({name: 'Dashboard'})
                            } else {
                                errorSweetAlert(response.data.message)
                            }
                        } else {
                            errorSweetAlert('Ocurrió un error')
                        }
                    } catch (error) {
                        errorSweetAlert('Ocurrió un error')
                    }
                }
                this.loading = false
            }
        },
    })
</script>
